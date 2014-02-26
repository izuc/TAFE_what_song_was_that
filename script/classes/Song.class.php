<?php
require_once('Base.class.php');
require_once('Pagination.class.php');
require_once('Artist.class.php');
require_once('Genre.class.php');

define('SQL_SONG_FETCH', 'SELECT * FROM `song_lyrics` WHERE `song_id` = ? LIMIT 1');
define('SQL_SONG_INSERT', 'INSERT INTO song_lyrics (artist_id, genre_id, song_title, song_release_year, song_lyrics) VALUES(?, ?, ?, ?, ?)');
define('SQL_SONG_DELETE', 'DELETE FROM `song_lyrics` WHERE `song_id` = ? LIMIT 1');
define('SQL_SONG_UPDATE', 'UPDATE song_lyrics SET artist_id = ?, genre_id = ?, song_title = ?, song_release_year = ?, song_lyrics = ? WHERE song_id = ?');

class Song extends Base {
	private $_songID;
	private $_artistID;
	private $_genreID;
	private $_songTitle;
	private $_songReleaseYear;
	private $_songLyrics;

	public function Song($songID, $artistID, $genreID, $songTitle, $songReleaseYear, $songLyrics) {
		$this->setSongID($songID);
		$this->setArtistID($artistID);
		$this->setGenreID($genreID);
		$this->setSongTitle($songTitle);
		$this->setReleaseYear($songReleaseYear);
		$this->setSongLyrics($songLyrics);
	}
	
	public function getSongID() {
		return $this->_songID;
	}
	
	public function setSongID($songID) {
		$this->_songID = $songID;
	}
	
	public function getArtistID() {
		return $this->_artistID;
	}
	
	public function setArtistID($artistID) {
		$this->_artistID = $artistID;
	}
	
	public function getGenreID() {
		return $this->_genreID;
	}
	
	public function setGenreID($genreID) {
		$this->_genreID = $genreID;
	}
	
	public function getSongTitle() {
		return $this->_songTitle;
	}
	
	public function setSongTitle($songTitle) {
		$this->_songTitle = $songTitle;
	}
	
	public function getReleaseYear() {
		return $this->_songReleaseYear;
	}
	
	public function setReleaseYear($songReleaseYear) {
		$this->_songReleaseYear = $songReleaseYear;
	}
	
	public function getSongLyrics() {
		return $this->_songLyrics;
	}
	
	public function setSongLyrics($songLyrics) {
		$this->_songLyrics = $songLyrics;
	}
	
	public function getArtist() {
		return Artist::create($this->getArtistID());
	}
	
	public function getGenre() {
		return Genre::create($this->getGenreID());
	}

	public function insert() {
		$db = new DB();
		$statement = $db->prepare(SQL_SONG_INSERT);
		$statement->bind_param('iisss', $this->getArtistID(), $this->getGenreID(), 
								$this->getSongTitle(), $this->getReleaseYear(), $this->getSongLyrics());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public function update() {
		$db = new DB();
		$statement = $db->prepare(SQL_SONG_UPDATE);
		$statement->bind_param('iisssi', $this->getArtistID(), $this->getGenreID(), $this->getSongTitle(), $this->getReleaseYear(),
								$this->getSongLyrics(), $this->getSongID());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public static function delete($songID) {
		$db = new DB();
		$statement = $db->prepare(SQL_SONG_DELETE);
		$statement->bind_param("i", $songID);
		$statement->execute();
		$db->close();
		return true;
	}
	
	public static function create($songID) {
		$db = new DB();
		$statement = $db->prepare(SQL_SONG_FETCH);
		$statement->bind_param("i", $songID);
		$statement->execute();
		$statement->bind_result($songID, $artistID, $genreID, $songTitle, $songReleaseYear, $songLyrics);
		$statement->fetch();
		$db->close();
		return new Song($songID, $artistID, $genreID, $songTitle, $songReleaseYear, $songLyrics);
	}
	
	private static function fetchArray($result) {
		$songs = array();
		if ($result) {
			while($row = $result->fetch_assoc()) {
				$songs[] = new Song($row['song_id'], $row['artist_id'], $row['genre_id'], $row['song_title'], $row['song_release_year'], $row['song_lyrics']);
			}
		}
		return $songs;
	}
	
	public static function fetchAll($query = "", $genreID = 0) {
		$where_clause = "";
		if ((!empty($query)) || ($genreID > 0)) {
			$genre_clause = (($genreID > 0) ? "genre_id = ".$genreID."" : "");
			$match_clause = ((!empty($query)) ? "MATCH (song_title, song_lyrics) AGAINST ('".$query."')" : "");
			$where_clause = " WHERE " . ((!empty($genre_clause))? $genre_clause.((!empty($match_clause))? " AND " . $match_clause : "") : $match_clause);
		}
		$pagination = new Pagination("SELECT COUNT( * ) FROM `song_lyrics`" . $where_clause);
		return array('list'=>self::fetchArray($pagination->getResult("SELECT * FROM `song_lyrics`" . $where_clause)),'pagination'=>$pagination);
	}
}
?>