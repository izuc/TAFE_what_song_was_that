<?php
session_start();
require_once('../classes/User.class.php');
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case "login":
			$success = User::login($_POST['email_address'], $_POST['account_password']);
			$title = "Welcome User";
			$message = "Login Successful";
			break;
		case "logout":
			$success = User::logout();
			$title = "Goodbye User";
			$message = "Logout Successful";
			break;
	}
	echo json_encode(array ('success'=>$success,'title'=>$title,'message'=>$message));
}
?>