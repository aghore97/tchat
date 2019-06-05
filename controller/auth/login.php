<?php

if(isset($session['user_id'])){
    header('Location:'._URL_HOME.'account/');
    exit;
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
	if(isset($_POST['login'])) {
		$init = array(
			'login' => $_POST['login'],
			'pass'  => aes_encrypt($_POST['pass'])
		);
	}
	
	$user = new User($init);
	if (!$user['id']) {
		$tpl->assign("error", "Votre identifiant ou votre mot de passe est incorrect");
	}else{
		$session['user_id'] = $user['id'];
		$user->save(['connected' => 1, 'date_last_connection' => date('Y-m-d H:i:s')]);
		header('Location:'._URL_HOME.'account/');
		exit;
	}
	
	$tpl->display("home.tpl");
}

?>