<?php

if ( !defined("_HOME_DIR") ) {
    define("_HOME_DIR","");
}

define("_DIR_HOME",     _DIR_ROOT._HOME_DIR);
define("_URL_HOME",     _URL_ROOT._HOME_DIR);
define("_DIR_CONFIG",   _DIR_ROOT."config/");

//*****    Lib Dirs *****
define("_LIB_DIR",      "lib/");
define("_DIR_LIB",      _DIR_ROOT._LIB_DIR);

define("_TINYMCE_DIR",  _LIB_DIR."tinymce/");
define("_URL_TINYMCE",  _URL_ROOT._TINYMCE_DIR);

define("_DIR_MODEL",    _DIR_ROOT."model/");

require_once(_DIR_CONFIG."tables.php");
require_once(_DIR_CONFIG."includes.php");
define("_DIR_CONTROLLER",    _DIR_ROOT."controller/");

//**********    SMARTY    ****************
$tpl = new Smarty();
if (is_dir(_DIR_HOME.'view/')) {
    $tpl->template_dir    = _DIR_HOME.'view/';
    $tpl->config_dir      = _DIR_HOME.'view/_config/';
    $tpl->compile_dir     = _DIR_HOME.'view/_view_c/';
    $tpl->cache_dir       = _DIR_HOME.'view/_view_c/';
    $tpl->error_reporting = E_ALL ^ E_NOTICE;
}

//**********    SESSION    ***************
$session = new Session();
$tpl->assignByRef("session",$session);

//**********    MySQL CONNECT    *********
require_once(_DIR_CONFIG."db.php");

//**********    Functions    *********
require_once(_DIR_LIB."common.php");

?>