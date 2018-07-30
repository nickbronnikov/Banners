<?php

class Page404 extends Controller {


    function main(){
        $this->view->assign('DOCUMENT_ROOT', DOCUMENT_ROOT);
        $local = LOCAL['page404'];
        $local['main_temp'] = LOCAL['main'];
        $this->view->assign('title', $local['index']['title']);
        $this->view->assign('localisation', $local);

        $this->view->showPage('page404/index');
    }
}