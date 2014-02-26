<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Upload.class.php');
if (User::isAdminSession()) {
	$image = new Upload();
	$image->setUploadMaxSize(100000000000);
	$image->setDirectoryPath('../../uploads');
	$image->setUploadTmpName($_FILES['image']['tmp_name']);
	$image->setUploadFileSize($_FILES['image']['size']);
	$image->setUploadFileType($_FILES['image']['type']);
	$image->setUploadFileName($_FILES['image']['name']);
	$image->uploadFile();
}
?>