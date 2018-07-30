<?php
require_once DOCUMENT_ROOT.'/app/models/User.php';
require_once DOCUMENT_ROOT.'/app/models/Banner.php';


class admin extends Controller{

    function __construct()
    {
        $this->view = new View();
        $this->view->assign('is_admin_panel', true);
        $this->view->assign('DOCUMENT_ROOT', DOCUMENT_ROOT);
        $local = LOCAL['admin'];
        $local['main_temp'] = LOCAL['main'];
        $this->view->assign('localisation', $local);
    }

    function index(){
        $user = new User(true);
        if($user->is_auth){
            $this->view->assign('title', LOCAL['admin']['index']['title']);
            $this->view->assign('is_auth', true);
            $this->view->assign('username', $user->user_name);

            $banner = new Banner();
            $banners = $banner->getUserBanners();
            $this->view->assign('banners', $banners);

            $this->view->assign('list_temp', DOCUMENT_ROOT.'/app/views/admin/list.tpl');
            $this->view->showPage('admin/index');
        } else {
            $this->view->assign('title', LOCAL['admin']['index_auth']['title']);
            $this->view->showPage('admin/index_auth');
        }
    }

    function registration(){
        $user = new User(true);
        if($user->is_auth){
            Route::redirect('/admin');
        } else {
            $this->view->assign('title', LOCAL['admin']['registration']['title']);
            $this->view->showPage('admin/registration');
        }
    }

    function savenewuser(){
        $data = json_decode($_POST['params'], true);
        $user = new User();
        $valid = $user->checkFields($data);
        if($valid['ok']){
            $user = new User();
            $user->createNewUser($data);
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('success' => 0, 'errors' => $valid['errors']));
        }
    }

    function signin(){
        $params = json_decode($_POST['params'], true);
        $user = new User();
        echo json_encode($user->checkAuth($params));
    }

    function exitauth(){
        $user = new User();
        $user->disableToken($_COOKIE['auth_token']);
    }

    function checkurl(){
        $banner = new Banner();
        echo json_encode($banner->checkURL($_POST['url'], $_POST['banner_id']));
    }

    function savenewbanner(){
        $banner = new Banner();
        echo json_encode($banner->saveBanner(json_decode($_POST['params'], true), $_POST['banner_id']));
    }

    function deletebanner(){
        $user = new User(true);
        if($user->is_auth){
            $banner = new Banner();
            $banner->deleteBanner($_POST['banner_id']);
            $this->getbannerslist();
        }
    }

    function add(){
        $user = new User(true);
        if($user->is_auth){
            $this->view->assign('is_auth', true);
            $this->view->assign('username', $user->user_name);
            $this->view->assign('title', LOCAL['admin']['add']['title']);
            $this->view->assign('domain', $_SERVER['HTTP_HOST']);
            $this->view->showPage('admin/add');
        } else {
            Route::redirect('/admin');
        }
    }
    function edit(){
        $user = new User(true);
        $banner_id = Route::getUrlSegment(3);
        if($user->is_auth && $banner_id){
            $banner = new Banner($banner_id);
            if($banner->is_banner){
                $this->view->assign('is_auth', true);
                $this->view->assign('username', $user->user_name);
                $this->view->assign('title', LOCAL['admin']['edit']['title'].$banner->banner['name']);
                $this->view->assign('domain', $_SERVER['HTTP_HOST']);
                $this->view->assign('banner', $banner->banner);
                $this->view->showPage('admin/edit');
            } else {
                Route::redirect('/admin');
            }
        } else {
            Route::redirect('/admin');
        }
    }

    function updatesort(){
        $user = new User(true);
        if($user->is_auth){
            $banner = new Banner();

            $banner->updateSort($_POST['action'], $_POST['banner_id']);

            $this->getbannerslist();
        } else {
            Route::redirect('/admin');
        }
    }

    private function getbannerslist(){
        $user = new User(true);
        if($user->is_auth){
            $banner = new Banner();
            $banners = $banner->getUserBanners();
            $this->view->assign('banners', $banners);

            $this->view->showTemplate('admin/list');
        } else {
            Route::redirect('/admin');
        }

    }
}