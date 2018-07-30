<?php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once DOCUMENT_ROOT.'/libs/smarty/libs/Smarty.class.php';
Route::start();