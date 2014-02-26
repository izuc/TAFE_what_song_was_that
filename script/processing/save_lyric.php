<?php
session_start();
require_once('../classes/Song.class.php');
require_once('../classes/Validation.class.php');

$message = "";
$success = false;

if (!Validation::isSelected(Validation::getFormValue("artist_id"))) {
	$message .= " * Please select a artist <br />";
}

if (!Validation::isSelected(Validation::getFormValue("genre_id"))) {
	$message .= " * Please select the genre <br />";
}

if (!Validation::checkLength(Validation::getFormValue("song_title"), 25, 5)) {
	$message .= " * The Song Title is required, and should contain 5 - 25 characters <br />";
}

if ((!Validation::checkLength(Validation::getFormValue("song_release_year"), 4, 4)) || (!Validation::isNumber(Validation::getFormValue("song_release_year")))) {
	$message .= " * The Song Release Year must be numeric, and four digits in length <br />";
}

if (!Validation::hasValue(Validation::getFormValue("song_lyrics"))) {
	$message .= " * You must enter lyrics <br />";
}

if (!Validation::hasValue($message)) {
	$song = new Song(Validation::getFormValue("record_id"), Validation::getFormValue("artist_id"), Validation::getFormValue("genre_id"), 
					Validation::getFormValue("song_title"), Validation::getFormValue("song_release_year"), Validation::getFormValue("song_lyrics"));
					
	if ($song->getSongID() > 0) {
		$success = $song->update();
		$message .= "Lyric Updated Successfully";
	} else {
		$success = $song->insert();
		$message .= "Lyric Added Successfully";
	}
}
echo json_encode(array ('success'=>$success,'message'=>$message));
?>