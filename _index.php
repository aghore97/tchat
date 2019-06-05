<?php

require_once "config/config.php";
require_once "config/global.php";

$dir_controller = _DIR_HOME."controller/";

if (isset($_REQUEST['c']) and is_file($dir_controller.$_REQUEST['c'].".php")) {
    include $dir_controller.$_REQUEST['c'].".php";
}else{
	include $dir_controller."error404.php";
}

?>