<?php
session_start();
require_once('script/classes/User.class.php');
require_once('script/classes/Log.class.php');
require_once('script/classes/Song.class.php');
$success = false;
$user = User::getLoggedInUser();
if ($user != null) {
	$log = $user->fetchCart();
	if ($log != null) {    
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="downloaded.pdf"');
		echo $log->generatePDF();
	}
}
?>


