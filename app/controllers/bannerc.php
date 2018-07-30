<?php
require_once DOCUMENT_ROOT.'/app/models/User.php';
require_once DOCUMENT_ROOT.'/app/models/Banner.php';
class bannerc extends Controller{

    function index(){
        $banner = new Banner();
        $res = $banner->getBannerByURL(Route::getUrlSegment(1));
        $user = new User();
        $user = $user->getUserByID($res['user_id']);
        $this->view->assign('DOCUMENT_ROOT', DOCUMENT_ROOT);
        $local = LOCAL['admin'];
        $local['main_temp'] = LOCAL['main'];
        $this->view->assign('localisation', $local);
        $this->view->assign('title', $res['name']);
        $this->view->assign('user', $user);
        $this->view->assign('banner', $res);
        $this->view->showPage('banner/index');
    }

}