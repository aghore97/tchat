<?php

function class_autoload($class_name) {
    if ( substr($class_name,-4) == "List" ) {
        $class_name = substr($class_name,0,strlen($class_name) - 4);
    }
    $filename = _DIR_MODEL . $class_name . '.php';
    if ( is_file($filename) ) {
        require_once $filename;
    }
}
spl_autoload_register('class_autoload');

require_once _DIR_LIB."core/CoreItem.php";
require_once _DIR_LIB."core/CoreList.php";
require_once _DIR_LIB."core/Error.php";
require_once _DIR_LIB."core/Session.php";

require_once _DIR_LIB."smarty/Smarty.class.php";

?>