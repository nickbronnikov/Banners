<?php

class View
{

    private $smarty;

    function __construct()
    {
        $this->smarty = new Smarty;
        $this->smarty->setCompileDir(DOCUMENT_ROOT.'/temp/template_c/');
    }

    function assign($name, $value){
        if($name != '' && $value != ''){
            $this->smarty->assign($name, $value);
            return true;
        } else {
            return false;
        }
    }

    function showPage($template){
        $this->smarty->assign('main_temp', DOCUMENT_ROOT.'/app/views/'.$template);
        $this->smarty->display(DOCUMENT_ROOT.'/app/views/index.tpl');
    }

    function showTemplate($template){
        $this->smarty->display(DOCUMENT_ROOT.'/app/views/'.$template.'.tpl');
    }
}