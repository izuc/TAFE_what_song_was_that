<?php
class Validation {
    public static function checkLength($value, $maxLength, $minLength = 0) {
        if (!(strlen($value) > $maxLength) && !(strlen($value) < $minLength)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getFormValue($name, $default = '') {
        if (isset($_POST[$name])) {
            return trim($_POST[$name]);
        }
    }

    public static function hasValue($value) {
        if (strlen($value) < 1 || is_null($value) || empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    public static function isAlpha($value, $allow = '') {
        if (preg_match('/^[a-zA-Z' . $allow . ']+$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAlphaNumeric($value){
        if (preg_match("/^[A-Za-z0-9 ]+$/", $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isDate($value) {
        $date = date('Y', strtotime($value));
        if ($date == "1969" || $date == '') {
            return false;
        } else {
            return true;
        }
    }

    public static function isEmail($email) {
        $pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
        if (preg_match($pattern, $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isNumber($number) {
        if (preg_match("/^\-?\+?[0-9e1-9]+$/", $number)) {
            return true;
        } else {
            return false;
        }
    }
	
	public static function isSelected($value) {
		return (self::isNumber($value) && ($value > 0));
	}
}
?>