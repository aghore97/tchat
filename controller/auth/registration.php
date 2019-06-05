<?php

	$user = new User();
	$user->generateUser();
	
	if(isset($user['id'])){
		$tpl->assign("login", $user['login']);
		$tpl->assign("pass", $user['pass']);
		$tpl->display("home.tpl");
	}else{
		$tpl->assign("error", "Un problème technique est survenu, veuillez reessayer plus tard");
		$tpl->display("home.tpl");
	}

?>