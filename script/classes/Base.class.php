<?php
require_once('DB.class.php');

abstract class Base {
	public function Base() {
		
	}

	abstract public function insert();
	abstract public function update();
}
?>