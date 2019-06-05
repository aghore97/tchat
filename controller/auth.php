<?php

if ( isset($_REQUEST['s']) and is_file(_DIR_CONTROLLER.'auth/'.$_REQUEST['s'].'.php')) {
   include _DIR_CONTROLLER.'auth/'.$_REQUEST['s'].'.php';   
}

?>