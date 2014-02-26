<?php
require_once('Base.class.php');
require_once('Pagination.class.php');

define('SQL_ARTIST_LIST', 'SELECT * FROM `song_artists`');
define('SQL_ARTIST_FETCH', 'SELECT * FROM `song_artists` WHERE `artist_id` = ? LIMIT 1');
define('SQL_ARTIST_INSERT', 'INSERT INTO song_artists (artist_name, artist_image) VALUES(?, ?)');
define('SQL_ARTIST_DELETE', 'DELETE FROM `song_artists` WHERE `artist_id` = ? LIMIT 1');
define('SQL_ARTIST_UPDATE', 'UPDATE song_artists SET artist_name = ?, artist_image = ? WHERE artist_id = ?');

class Artist extends Base {
	private $_artistID;
	private $_artistName;
	private $_artistImage;
	
	public function Artist($artistID, $artistName, $artistImage) {
		$this->setArtistID($artistID);
		$this->setArtistName($artistName);
		$this->setArtistImage($artistImage);
	}
	
	public function getArtistID() {
		return $this->_artistID;
	}
	
	public function setArtistID($artistID) {
		$this->_artistID = $artistID;
	}
	
	public function getArtistName() {
		return $this->_artistName;
	}
	
	public function setArtistName($artistName) {
		$this->_artistName = $artistName;
	}
	
	public function getArtistImage() {
		return $this->_artistImage;
	}
	
	public function setArtistImage($artistImage) {
		$this->_artistImage = $artistImage;
	}
	
	public function displayImage() {
		echo '<img src="uploads/'.(((strlen($this->getArtistImage()) > 0) && (file_exists('../../uploads/'.$this->getArtistImage())))? $this->getArtistImage() : "default_image.png").'" width="80px" height="80px" />';
	}
	
	public function insert() {
		$db = new DB();
		$statement = $db->prepare(SQL_ARTIST_INSERT);
		$statement->bind_param('ss', $this->getArtistName(), $this->getArtistImage());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public function update() {
		$db = new DB();
		$statement = $db->prepare(SQL_ARTIST_UPDATE);
		$statement->bind_param('ssi', $this->getArtistName(), $this->getArtistImage(), $this->getArtistID());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public static function create($artistID) {
		$db = new DB();
		$statement = $db->prepare(SQL_ARTIST_FETCH);
		$statement->bind_param("i", $artistID);
		$statement->execute();
		$statement->bind_result($artistID, $artistName, $artistImage);
		$statement->fetch();
		$db->close();
		return new Artist($artistID, $artistName, $artistImage);
	}
	
	public static function delete($artistID) {
		$db = new DB();
		$statement = $db->prepare(SQL_ARTIST_DELETE);
		$statement->bind_param("i", $artistID);
		$statement->execute();
		$db->close();
		return true;
	}
	
	public static function fetchAll() {
		$artists = array();
		$pagination = new Pagination("SELECT COUNT(*) FROM song_artists");
		$result = $pagination->getResult("SELECT * FROM song_artists");
		if ($result) {
			while($row = $result->fetch_assoc()) {
				$artists[] = new Artist($row['artist_id'], $row['artist_name'], $row['artist_image']);
			}
		}
		return array('list'=>$artists,'pagination'=>$pagination);
	}
	
	public static function fetchList() {
		$db = new DB();
		$statement = $db->prepare(SQL_ARTIST_LIST);
		$artists = array();
		$statement->execute();
		$statement->bind_result($artistID, $artistName, $artistImage);
		while($statement->fetch()) {
			$artists[] = new Artist($artistID, $artistName, $artistImage);
		}
		$db->close();
		return $artists;
	}
	
	public static function displaySelectOptions($artistID = 0) {
		foreach (self::fetchList() as $artist) {
			echo '<option value="'.$artist->getArtistID().'" '.(($artistID == $artist->getArtistID())? 'selected="true" ': '').'>'.ucfirst($artist->getArtistName()).'</option>';
		}
	}
}

?>