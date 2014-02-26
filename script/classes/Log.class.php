<?php
require_once('Base.class.php');
require_once('Song.class.php');
require_once('Genre.class.php');
require_once('fpdf/html2fpdf.php');
define('SQL_LOG_LIST', 'SELECT * FROM `user_song_log`');
define('SQL_LOG_FETCH', 'SELECT * FROM `user_song_log` WHERE `log_id` = ? LIMIT 1');
define('SQL_LOG_INSERT', 'INSERT INTO `user_song_log` (user_id, log_date, log_status) VALUES(?, ?, ?)');
define('SQL_LOG_UPDATE', 'UPDATE user_song_log SET user_id = ?, log_date = ?, log_status = ? WHERE log_id = ?');
define('SQL_LOG_FETCH_ITEMS', 'SELECT * FROM `user_song_log_items` WHERE `log_id` = ?');
define('SQL_LOG_ITEM_INSERT', 'INSERT INTO `user_song_log_items` (log_id, song_id) VALUES(?, ?)');
define('SQL_LOG_ITEM_DELETE', 'DELETE FROM `user_song_log_items` WHERE `item_id` = ? LIMIT 1');

class LogItem {
	private $_itemID;
	private $_logID;
	private $_songID;
	
	public function LogItem($itemID, $logID, $songID) {
		$this->setItemID($itemID);
		$this->setLogID($logID);
		$this->setSongID($songID);
	}
	
	public function getItemID() {
		return $this->_itemID;
	}
	
	public function setItemID($itemID) {
		$this->_itemID = $itemID;
	}
	
	public function getLogID() {
		return $this->_logID;
	}
	
	public function setLogID($logID) {
		$this->_logID = $logID;
	}
	
	public function getSongID() {
		return $this->_songID;
	}
	
	public function setSongID($songID) {
		$this->_songID = $songID;
	}
	
	public function getSongObject() {
		return Song::create($this->_songID);
	}
}

class Log extends Base {
	private $_logID;
	private $_userID;
	private $_logDate;
	private $_logStatus;
	private $_logItems = array();
	
	public function Log($logID, $userID, $logDate, $logStatus) {
		$this->setLogID($logID);
		$this->setUserID($userID);
		$this->setLogDate($logDate);
		$this->setLogStatus($logStatus);
		$this->populateLogItems();
	}
	
	private function populateLogItems() {
		$db = new DB();
		$statement = $db->prepare(SQL_LOG_FETCH_ITEMS);
		$statement->bind_param("i", $this->getLogID());
		$statement->execute();
		$statement->bind_result($itemID, $logID, $songID);
		while($statement->fetch()) {
			$this->_logItems[] = new LogItem($itemID, $logID, $songID);
		}
		$db->close();
	}
	
	public function getLogID() {
		return $this->_logID;
	}
	
	public function setLogID($logID) {
		$this->_logID = $logID;
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
	}
	
	public function getLogDate() {
		return $this->_logDate;
	}
	
	public function setLogDate($logDate) {
		$this->_logDate = $logDate;
	}
	
	public function getLogStatus() {
		return $this->_logStatus;
	}
	
	public function setLogStatus($logStatus) {
		$this->_logStatus = $logStatus;
	}
	
	public function getLogItems() {
		return $this->_logItems;
	}
	
	public function generatePDF() {
		$pdf = new HTML2FPDF();
		foreach ($this->getLogItems() as $item) {
			$song = $item->getSongObject();
			$pdf->AddPage();
			$table_text = '
			<table width="600px">
				<tr>
					<td><b>Title:</b></td><td>'. $song->getSongTitle() .'</td>
				</tr>
				<tr>
					<td><b>Genre:</b></td><td>'. $song->getGenre()->getGenreName().'</td>
				</tr>
				<tr>
					<td><b>Year Released:</b></td><td>'. $song->getReleaseYear().'</td>
				</tr>
				<tr>
					<td><b>Song Artist:</b></td><td>'. $song->getArtist()->getArtistName().'</td>
				</tr>
				<tr>
					<td colspan="2"><br />'. nl2br($song->getSongLyrics()).'</td>
				</tr>
			</table>';
			$pdf->WriteHTML($table_text);
		}
		$pdf->Output();
		$this->setLogStatus(1);
		$this->update();
	}
	
	public function addLogItem($songID) {
		if (Song::create($songID) != null) {
			$db = new DB();
			$statement = $db->prepare(SQL_LOG_ITEM_INSERT);
			$statement->bind_param('ii', $this->getLogID(), $songID);
			$statement->execute();
			$db->close();
			return true;
		}
		return false;
	}
	
	public function removeLogItem($itemID) {
		$db = new DB();
		$statement = $db->prepare(SQL_LOG_ITEM_DELETE);
		$statement->bind_param("i", $itemID);
		$statement->execute();
		$db->close();
		return true;
	}
	
	public function insert() {
		$db = new DB();
		$statement = $db->prepare(SQL_LOG_INSERT);
		$statement->bind_param('isi', $this->getUserID(), $this->getLogDate(), $this->getLogStatus());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public function update() {
		$db = new DB();
		$statement = $db->prepare(SQL_LOG_UPDATE);
		$statement->bind_param('isii', $this->getUserID(), $this->getLogDate(), $this->getLogStatus(), $this->getLogID());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public static function create($logID) {
		$db = new DB();
		$statement = $db->prepare(SQL_LOG_FETCH);
		$statement->bind_param("i", $logID);
		$statement->execute();
		$statement->bind_result($logID, $userID, $logDate, $logStatus);
		$statement->fetch();
		$db->close();
		return new Log($logID, $userID, $logDate, $logStatus);
	}
	
	public static function fetchAll() {
		$db = new DB();
		$statement = $db->prepare(SQL_LOG_LIST);
		$logs = array();
		$statement->execute();
		$statement->bind_result($logID, $userID, $logDate, $logStatus);
		while($statement->fetch()) {
			$logs[] = new Log($logID, $userID, $logDate, $logStatus);
		}
		$db->close();
		return $logs;
	}
}
?>