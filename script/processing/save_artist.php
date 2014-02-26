<?php
session_start();
require_once('../classes/Artist.class.php');
require_once('../classes/Validation.class.php');

$message = "";
$success = false;

if (!Validation::checkLength(Validation::getFormValue("artist_name"), 25, 3)) {
    $message .= " * Artist name is required, and should contain 3 - 25 characters <br />";
}

if (!Validation::hasValue($message)) {
	$artist = new Artist(Validation::getFormValue("record_id"), Validation::getFormValue("artist_name"), Validation::getFormValue("artist_image"));
	if ($artist->getArtistID() > 0) {
		$success = $artist->update();
		$message .= "Artist Updated Successfully";
	} else {
		$success = $artist->insert();
		$message .= "Artist Added Successfully";
	}
}
echo json_encode(array ('success'=>$success,'message'=>$message));
?>