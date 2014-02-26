<?php
define('DB_HOST_NAME', 'localhost');
define('DB_USER_NAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'music_store');

class DB extends mysqli  {
	public function DB() {
		parent::__construct(DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);
	}
}
?>