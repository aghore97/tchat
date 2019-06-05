<?php

$user = new User($session['user_id']);
$user->save(['connected' => 0]);
unset($session['user_id']);  
header('Location:'._URL_HOME);

?>