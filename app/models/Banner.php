<?php

class Banner extends Model{

    private $db;
    public $is_banner = false;
    public $banner;

    function __construct($banner_id = false){
        global $CONFIG;
        $this->db = new DB($CONFIG['db']['host'], $CONFIG['db']['name'], $CONFIG['db']['user'], $CONFIG['db']['password'], $CONFIG['db']['port']);
        if($banner_id){
            $user = new User(true);
            $res = $this->db->row("SELECT * FROM `banners` WHERE id=:id AND user_id=:user_id", array('id' => $banner_id, 'user_id' => $user->user_id));
            if($this->db->rowCount > 0){
                $this->is_banner = true;
                $this->banner = $res;
            }
        }
    }

    function checkURL($url, $banner_id){
        $result = array('success' => 1);
        $this->db->row("SELECT id FROM `banners` WHERE url=:url AND id!=:id", array('url' => $url, 'id' => $banner_id));
        if($url == ''){
            $result['success'] = 0;
            $result['error'] = 'empty';
        } else if(preg_match('/\s/', $url)){
            $result['success'] = 0;
            $result['error'] = 'space';
        } else if(file_exists(DOCUMENT_ROOT."/app/controllers/".$url.".php")){
            $result['success'] = 0;
            $result['error'] = 'not_correct';
        } else if($this->db->rowCount > 0){
            $result['success'] = 0;
            $result['error'] = 'already_exist';
        }
        return $result;
    }

    function saveBanner($params, $banner_id){

        $user = new User(true);

        if($user->is_auth){

            $check_res = $this->checkURL($params['url'], $banner_id);

            if($check_res['success'] == 1){
                if($banner_id){

                    $res = $this->db->row("SELECT * FROM `banners` WHERE id=:id AND user_id=:user_id", array('id' => $banner_id, 'user_id' => $user->user_id));

                    if($this->db->rowCount > 0){

                        $this->db->query("UPDATE `banners` SET `sort`=sort + 1 WHERE sort >= :sort AND user_id=:user_id",
                            array('sort' => $params['sort'], 'user_id' => $user->user_id));

                        $image_name = '/files/banner_imgs/'.preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "",crypt($params['name'])).'.jpeg';

                        if(file_exists(DOCUMENT_ROOT.$res['image'])){
                            unlink(DOCUMENT_ROOT.$res['image']);
                        }

                        $this->db->query("UPDATE `banners` SET 
                                                 `name`=:name,
                                                 `url`=:url,
                                                 `state`=:state,
                                                 `sort`=:sort,
                                                 `image`=:image 
                                                 WHERE id=:id", array(
                                                    'name' => $params['name'],
                                                    'url' => $params['url'],
                                                    'state' => $params['state'],
                                                    'sort' => $params['sort'],
                                                    'image' => $image_name,
                                                    'id' => $banner_id
                        ));

                        $this->base64_to_jpeg($params['image'], DOCUMENT_ROOT.$image_name);

                        $res_banners = $this->db->query("SELECT id FROM `banners` WHERE user_id=:user_id ORDER BY sort ASC", array('user_id' => $user->user_id));
                        foreach ($res_banners as $index => $banner){
                            $this->db->query("UPDATE `banners` SET `sort`=:sort WHERE id=:id", array('id' => $banner['id'], 'sort' => ($index + 1)));
                        }

                        return array('success' => 1, 'id' => $banner_id);
                    } else {
                        return array('error' => 'Access denied');
                    }
                } else {

                    $this->db->query("UPDATE `banners` SET `sort`=sort + 1 WHERE sort >= :sort AND user_id=:user_id",
                        array('sort' => $params['sort'], 'user_id' => $user->user_id));

                    $image_name = '/files/banner_imgs/'.preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "",crypt($params['name'])).'.jpeg';



                    $this->db->query("INSERT INTO `banners`(`user_id`, `timestamp`, `name`, `url`, `state`, `sort`, `image`, `params`) 
                                      VALUES (
                                        :user_id,
                                        :timestamp,
                                        :name,
                                        :url,
                                        :state,
                                        :sort,
                                        :image,
                                        :params
                                        )", array(
                        'user_id' => $user->user_id,
                        'timestamp' => time(),
                        'name' => $params['name'],
                        'url' => $params['url'],
                        'state' => $params['state'],
                        'sort' => $params['sort'],
                        'image' => $image_name,
                        'params' => ''
                    ));

                    $this->base64_to_jpeg($params['image'], DOCUMENT_ROOT.$image_name);

                    $res_banners = $this->db->query("SELECT id FROM `banners` WHERE user_id=:user_id ORDER BY sort ASC", array('user_id' => $user->user_id));
                    foreach ($res_banners as $index => $banner){
                        $this->db->query("UPDATE `banners` SET `sort`=:sort WHERE id=:id", array('id' => $banner['id'], 'sort' => ($index + 1)));
                    }

                    return array('success' => 1, 'id' => $this->db->lastInsertId());
                }

            } else {
                return array('success' => 0, 'errors' => array('url' => $check_res['error']));
            }

        } else {
            return array('error' => 'Access denied');
        }
    }

    function getUserBanners(){
        $user = new User(true);
        if($user->is_auth){
            $res = $this->db->query("SELECT * FROM `banners` WHERE user_id=:user_id ORDER BY sort ASC", array('user_id' => $user->user_id));

            return $res;
        } else {
            return array();
        }
    }

    function updateSort($action, $id){
        $user = new User(true);
        if($user->is_auth){
            if($action == 'up'){
                $sort = $this->db->single("SELECT sort FROM `banners` WHERE id=:id", array('id' => $id));
                $sort_next = $this->db->row("SELECT id, sort FROM `banners` WHERE sort<:sort AND user_id=:user_id ORDER BY sort DESC LIMIT 1", array('sort' => $sort, 'user_id' => $user->user_id));
                $this->db->query("UPDATE `banners` SET sort=:sort_next WHERE id=:id LIMIT 1", array('id' => $id, 'sort_next' => $sort_next['sort']));
                $this->db->query("UPDATE `banners` SET sort=:sort WHERE id=:id", array('sort' => $sort,'id' => $sort_next['id']));
            } elseif ($action == 'down'){
                $sort = $this->db->single("SELECT sort FROM `banners` WHERE id=:id", array('id' => $id));
                $sort_prev = $this->db->row("SELECT id, sort FROM `banners` WHERE sort>:sort AND user_id=:user_id ORDER BY sort ASC LIMIT 1", array('sort' => $sort, 'user_id' => $user->user_id));
                $this->db->query("UPDATE `banners` SET sort=:sort_next WHERE id=:id LIMIT 1", array('id' => $id, 'sort_next' => $sort_prev['sort']));
                $this->db->query("UPDATE `banners` SET sort=:sort WHERE id=:id", array('sort' => $sort,'id' => $sort_prev['id']));
            }
        } else {
            return '';
        }
    }

    function deleteBanner($id){
        $user = new User(true);
        if($user->is_auth){

            $banner = $this->db->row("SELECT * FROM `banners` WHERE id=:id", array('id' => $id));

            if(file_exists(DOCUMENT_ROOT.$banner['image'])){
                unlink(DOCUMENT_ROOT.$banner['image']);
            }

            $this->db->query("DELETE FROM `banners` WHERE id=:id", array('id' => $id));

            $res_banners = $this->db->query("SELECT id FROM `banners` WHERE user_id=:user_id ORDER BY sort ASC", array('user_id' => $user->user_id));
            foreach ($res_banners as $index => $banner){
                $this->db->query("UPDATE `banners` SET `sort`=:sort WHERE id=:id", array('id' => $banner['id'], 'sort' => ($index + 1)));
            }
        }
    }


    function getBannerByURL($url){
        $res = $this->db->row("SELECT * FROM `banners` WHERE url=:url", array('url' => $url));
        if($this->db->rowCount > 0){
            return $res;
        } else {
            return false;
        }
    }

    function getAllBanners(){
        $result = array();
        $users = $this->db->query("SELECT * FROM `users` ORDER BY id DESC");
        foreach ($users as $i => $user){

            $banners = $this->db->query("SELECT * FROM `banners` WHERE user_id=:user_id AND state != 3 ORDER BY sort ASC", array('user_id' => $user['id']));

            if(count($banners) > 0){
                $result[$i] = $user;
                $result[$i]['banners'] = $banners;
            }
        }
        return $result;
    }

    private function base64_to_jpeg($base64_string, $output_file) {

        $ifp = fopen($output_file, 'wb');


        $data = explode( ',', $base64_string );


        fwrite( $ifp, base64_decode( $data[ 1 ] ) );


        fclose( $ifp );

        return $output_file;
    }
}