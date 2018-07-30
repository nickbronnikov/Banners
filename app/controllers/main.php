<?php

class main extends Controller {

    function index(){
        $local['main_temp'] = LOCAL['main'];
        $this->view->assign('localisation', $local);
        $this->view->assign('DOCUMENT_ROOT', DOCUMENT_ROOT);
        $this->view->assign('title', LOCAL['main']['index']['title']);

        $banner = new Banner();

        $banners = $banner->getAllBanners();

        $this->view->assign('banners', $banners);

        $this->view->showPage('main/index');
    }
}