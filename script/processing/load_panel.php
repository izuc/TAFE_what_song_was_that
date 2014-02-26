<?php
session_start();
require_once('../classes/User.class.php');
$user = User::getLoggedInUser();
if ($user != null) { 
	$user->loadMyPanel();
} else { 
	User::showLoginArea();
}
?>