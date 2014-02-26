<?php
	session_start();
	require_once('../classes/User.class.php');
	require_once('../classes/Artist.class.php');
	require_once('../classes/Song.class.php');
	require_once('../classes/Genre.class.php');
	$success = false;
	$message = '';
	if (User::isAdminSession()) {	
		if (isset($_POST['class_name']) && isset($_POST['record_id'])) {
			$method = new ReflectionMethod($_POST['class_name'], 'delete');
			$success = $method->invoke(NULL, $_POST['record_id']);
			$message = 'DELETED Record ' . $_POST['record_id'] . ' FROM ' . $_POST['class_name'];
		}
	}
	echo json_encode(array ('success'=>$success, 'message'=>$message));
?>