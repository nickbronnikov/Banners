<?php

class User extends Model{

    private $db;
    public $is_auth = false;
    public $user_id;
    public $user_login;
    public $user_name;

    function __construct($check_user_authentication = false){
        global $CONFIG;
        $this->db = new DB($CONFIG['db']['host'], $CONFIG['db']['name'], $CONFIG['db']['user'], $CONFIG['db']['password'], $CONFIG['db']['port']);

        if($check_user_authentication){
            if(isset($_COOKIE['auth_token'])){
                $user_id = $this->db->single("SELECT user_id FROM `user_tokens` WHERE token=:token AND before_timestamp > :time",
                                                    array('token' => $_COOKIE['auth_token'], "time" => time())
                );
                if($user_id){
                    $user = $this->db->row("SELECT * FROM `users` WHERE id=:user_id", array('user_id' => $user_id));
                    if($user){
                        $this->is_auth = true;
                        $this->user_id = $user['id'];
                        $this->user_login = $user['email'];
                        $this->user_name = $user['name'];
                    }
                }
            }
        }
    }

    function getUserByID($user_id){
        $user = $this->db->row("SELECT * FROM `users` WHERE id=:user_id", array('user_id' => $user_id));
        return $user;
    }

    function disableToken($token){
        $this->db->query("UPDATE `user_tokens` SET `before_timestamp`=:time WHERE token=:token", array('time' => time(), 'token' => $token));
    }

    function checkAuth($params){
        global $CONFIG;
        $result = array();
        $user = $this->db->row("SELECT * FROM `users` WHERE email=:login", array('login' => trim($params['login'])));
        if($user){
            if(password_verify($params['password'],$user['password'])){
                $result['success'] = 1;
                $token = crypt($user['email']);
                $before_timestamp = time() + $CONFIG['authorization']['authorization_time'] * 24 * 60 * 60;
                $this->db->query("INSERT INTO `user_tokens`(`user_id`, `timestamp`, `token`, `before_timestamp`) 
                                  VALUES (:user_id, :timestamp, :token, :before_timestamp)",
                    array('user_id' => $user['id'], 'timestamp' => time(), 'token' => $token, 'before_timestamp' => $before_timestamp));
                setcookie('auth_token', $token, $before_timestamp, '/');

            } else {
                $result['success'] = 0;
                $result['errors']['password'] = 1;
            }
        } else {
            $result['success'] = 0;
            $result['errors']['login'] = 1;
        }
        return $result;
    }

    function createNewUser($data){
        global $CONFIG;
        $this->db->query("INSERT INTO `users`(`name`, `email`, `password`, `timestamp`) VALUES (:name, :email, :password, :timestamp)",
                                array('name' => $data['name'], 'email' => $data['email'], 'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                                'timestamp' => time()));
        $user_id = $this->db->lastInsertId();
        $token = crypt($data['email']);
        $before_timestamp = time() + $CONFIG['authorization']['authorization_time'] * 24 * 60 * 60;
        $this->db->query("INSERT INTO `user_tokens`(`user_id`, `timestamp`, `token`, `before_timestamp`) 
                                  VALUES (:user_id, :timestamp, :token, :before_timestamp)",
                                 array('user_id' => $user_id, 'timestamp' => time(), 'token' => $token, 'before_timestamp' => $before_timestamp));
        setcookie('auth_token', $token, $before_timestamp, '/');
    }

    private function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function checkFields($data){
        $errors = array(
            'name' => array(),
            'email' => array(),
            'password' => array(),
            'repeat_password' => array()
        );
        $everything_ok = true;
        if($data['name'] === ''){
            $everything_ok = false;
            $errors['name']['empty'] = 1;
        }
        if($data['email'] === ''){
            $everything_ok = false;
            $errors['email']['empty'] = 1;
        } else if(!$this->isValidEmail($data['email'])){

            $everything_ok = false;
            $errors['email']['not_correct'] = 1;
        } else if($this->checkUserExistence($data['email'])){
            $everything_ok = false;
            $errors['email']['already_exist'] = 1;
        }
        if($data['password'] === ''){
            $everything_ok = false;
            $errors['password']['empty'] = 1;
        } else if($data['password_repeat'] !== $data['password']){
            $everything_ok = false;
            $errors['password_repeat']['does_not_match'] = 1;
        }
        return array('ok' => intval($everything_ok), 'errors' => $errors);
    }

    private function checkUserExistence($login){
        $this->db->row("SELECT id FROM `users` WHERE email=:email", array('email' => $login));
        if($this->db->rowCount > 0){
            return true;
        } else {
            return false;
        }
    }

}