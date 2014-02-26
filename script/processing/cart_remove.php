<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Log.class.php');
require_once('../classes/Song.class.php');

$success = false;
$user = User::getLoggedInUser();
if ($user != null) {
	if (isset($_POST['song_id'])) {
		$log = $user->fetchCart();
		if ($log != null) {
			$success = $log->removeLogItem($_POST['song_id']);
			$message = 'Item Deleted';
		}
	}
}
echo json_encode(array ('success'=>$success,'message'=>$message));
?>