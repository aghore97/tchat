<?php

if(!isset($session['user_id'])){
    header('Location:'._URL_HOME);
    exit;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty($_POST['message'])){
		$message = new Message();
		$message->save(['user_id' => $session['user_id'], 'date_insert' => date('Y-m-d H:i:s'), 'message' => $_POST['message']]);
	}
}

$message_list = new MessageList();
$message_records = $message_list->all_records();
$tpl->assign("message_records", $message_records);

$user_list = new UserList();
$user_records = $user_list->getConnected();
$tpl->assign("user_records", $user_records);

$tpl->display("account/main.tpl");

?>