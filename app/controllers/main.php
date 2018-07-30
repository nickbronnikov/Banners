<?php

require_once DOCUMENT_ROOT.'/app/models/User.php';

class main extends Controller {

    function index(){
        $local['main_temp'] = LOCAL['main'];
        $this->view->assign('localisation', $local);
        $this->view->assign('is_admin_panel', false);
        $this->view->assign('DOCUMENT_ROOT', DOCUMENT_ROOT);
        $this->view->assign('title', LOCAL['main']['index']['title']);

        $user = new User(true);
        if($user->is_auth){
            $this->view->assign('is_auth', true);
            $this->view->assign('username', $user->user_name);
        } else {
            $this->view->assign('is_auth', false);
        }

        $banner = new Banner();

        $banners = $banner->getAllBanners();

        $this->view->assign('banners', $banners);

        $this->view->showPage('main/index');
    }
}