<?php

function trim_text($text, $length) {
	return ((strlen($text) > $length)? substr($text, 0, strrpos(substr($text, 0, $length), ' ')) . '...' : $text);
}
?>