<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Validation.class.php');

$message = "";
$success = false;

if (!Validation::isAlpha(Validation::getFormValue("user_first_name"))) {
    $message .= " * First name is required, and can only be letters <br />";
}
if (!Validation::isAlpha(Validation::getFormValue("user_last_name"))) {
    $message .= " * Last name is required, and can only be letters <br />";
}
if (!Validation::isEmail(Validation::getFormValue("user_email_address"))) {
    $message .= " * You must provide a valid email address <br />";
}
if (!Validation::isNumber(Validation::getFormValue("user_phone_number"))) {
    $message .= " * The phone number must be numeric <br />";
}
if (!Validation::checkLength(Validation::getFormValue("user_phone_number"), 10, 10)) {
    $message .= " * The phone number must be 10 digits <br />";
}
if (((Validation::hasValue(Validation::getFormValue("user_account_password"))) || (!Validation::getFormValue("record_id") > 0)) && 
	(!Validation::checkLength(Validation::getFormValue("user_account_password"), 15, 6))) {
	$message .= " * The password needs to be between 6 - 15 characters <br />";
}

if (!Validation::hasValue($message)) {
	$user_account = new User(Validation::getFormValue("record_id"), 
							Validation::getFormValue("user_first_name"),
							Validation::getFormValue("user_last_name"),
							Validation::getFormValue("user_email_address"),
							Validation::getFormValue("user_favourite_genre"),
							Validation::getFormValue("user_phone_number"),
							Validation::getFormValue("user_account_password"),
							Validation::getFormValue("user_account_type"));
	
	if ($user_account->checkEmail()) {
		if ($user_account->getUserID() > 0) {
			$success = $user_account->update();
			$message .= "User Updated Successfully";
		} else {
			$success = $user_account->insert();
			$message .= "User Added Successfully";
		}
	} else {
		$message .= " * Email Already Exists <br />";
	}
}
echo json_encode(array ('success'=>$success,'message'=>$message));
?>