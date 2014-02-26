<?php
require_once('Base.class.php');

define('SQL_GENRE_LIST', 'SELECT * FROM `song_genres` ORDER BY genre_order ASC');
define('SQL_GENRE_FETCH', 'SELECT * FROM `song_genres` WHERE `genre_id` = ? ORDER BY genre_order ASC LIMIT 1');
define('SQL_GENRE_INSERT', 'INSERT INTO song_genres (genre_name, genre_order) VALUES(?, ?)');
define('SQL_GENRE_UPDATE', 'UPDATE song_genres SET genre_name = ?, genre_order = ? WHERE  genre_id = ?');

class Genre extends Base {
	private $_genreID;
	private $_genreName;
	private $_genreOrder;
	
	public function Genre($genreID, $genreName, $genreOrder) {
		$this->setGenreID($genreID);
		$this->setGenreName($genreName);
		$this->setGenreOrder($genreOrder);
	}
	
	public function getGenreID() {
		return $this->_genreID;
	}
	
	public function setGenreID($genreID) {
		$this->_genreID = $genreID;
	}
	
	public function getGenreName() {
		return $this->_genreName;
	}
	
	public function setGenreName($genreName) {
		$this->_genreName = $genreName;
	}
	
	public function getGenreOrder() {
		return $this->_genreOrder;
	}
	
	public function setGenreOrder($genreOrder) {
		$this->_genreOrder = $genreOrder;
	}
	
	public function insert() {
		$db = new DB();
		$statement = $db->prepare(SQL_GENRE_INSERT);
		$statement->bind_param('si', $this->getGenreName(), $this->getGenreOrder());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public function update() {
		$db = new DB();
		$statement = $db->prepare(SQL_GENRE_UPDATE);
		$statement->bind_param('sii', $this->getGenreName(), $this->getGenreOrder(), $this->getGenreID());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public static function create($genreID) {
		$db = new DB();
		$statement = $db->prepare(SQL_GENRE_FETCH);
		$statement->bind_param("i", $genreID);
		$statement->execute();
		$statement->bind_result($genreID, $genreName, $genreOrder);
		$statement->fetch();
		$db->close();
		return new Genre($genreID, $genreName, $genreOrder);
	}
	
	public static function fetchAll() {
		$db = new DB();
		$statement = $db->prepare(SQL_GENRE_LIST);
		$genres = array();
		$statement->execute();
		$statement->bind_result($genreID, $genreName, $genreOrder);
		while($statement->fetch()) {
			$genres[] = new Genre($genreID, $genreName, $genreOrder);
		}
		$db->close();
		return $genres;
	}
	
	public static function displaySelectOptions($genreID = 0) {
		foreach (self::fetchAll() as $genre) {
			echo '<option value="'.$genre->getGenreID().'" '.(($genreID == $genre->getGenreID())? 'selected="true" ': '').'>'.ucfirst($genre->getGenreName()).'</option>';
		}
	}
}

?>