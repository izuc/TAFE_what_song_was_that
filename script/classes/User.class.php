<?php
require_once('Base.class.php');
require_once('Log.class.php');

define('SQL_USER_CART', 'SELECT * FROM `user_song_log` WHERE `user_id` = ? && `log_status` = 0 ORDER BY log_date DESC, log_id DESC LIMIT 1');
define('SQL_LOGIN_CREDENTIALS', 'SELECT user_id FROM `user_accounts` WHERE `user_email_address` = ? AND `user_account_password` = SHA1(?) LIMIT 1');
define('SQL_USER_FETCH', 'SELECT * FROM `user_accounts` WHERE `user_id` = ? LIMIT 1');
define('SQL_PANEL_LINKS', 'SELECT link_name, link_settings FROM `user_panel_links` WHERE `user_account_type` = ?');
define('SQL_USER_INSERT', 'INSERT INTO user_accounts (user_first_name, user_last_name, user_email_address, user_favourite_genre, user_phone_number, user_account_password, user_account_type) VALUES(?, ?, ?, ?, ?, SHA1(?), ?)');
define('SQL_USER_UPDATE', 'UPDATE user_accounts SET user_first_name = ?, user_last_name = ?, user_email_address = ?, user_favourite_genre = ?, user_phone_number = ?, user_account_type = ? WHERE user_id = ?');
define('SQL_USER_CHANGE_PASSWORD', 'UPDATE user_accounts SET user_account_password = SHA1(?) WHERE user_id = ?');
define('SQL_CHECK_EMAIL', 'SELECT count(user_id) FROM `user_accounts` WHERE `user_email_address` = ? LIMIT 1');

class User extends Base {
	private $_userID;
	private $_userFirstName;
	private $_userLastName;
	private $_userEmailAddress;
	private $_userFavouriteGenre;
	private $_userPhoneNumber;
	private $_userAccountPassword;
	private $_userAccountType;

	public function User($userID, $userFirstName, $userLastName, $userEmailAddress, $userFavouriteGenre, $userPhoneNumber, $userAccountPassword, $userAccountType) {
		$this->setUserID($userID);
		$this->setUserFirstName($userFirstName);
		$this->setUserLastName($userLastName);
		$this->setUserEmailAddress($userEmailAddress);
		$this->setUserFavouriteGenre($userFavouriteGenre);
		$this->setUserPhoneNumber($userPhoneNumber);
		$this->setUserAccountPassword($userAccountPassword);
		$this->setUserAccountType($userAccountType);
	}
	
	public function getUserID() {
		return $this->_userID;
	}
	
	public function setUserID($userID) {
		$this->_userID = $userID;
	}
	
	public function getUserFirstName() {
		return $this->_userFirstName;
	}
	
	public function setUserFirstName($userFirstName) {
		$this->_userFirstName = $userFirstName;
	}
	
	public function getUserLastName() {
		return $this->_userLastName;
	}
	
	public function setUserLastName($userLastName) {
		$this->_userLastName = $userLastName;
	}
	
	public function getUserEmailAddress() {
		return $this->_userEmailAddress;
	}
	
	public function setUserEmailAddress($userEmailAddress) {
		$this->_userEmailAddress = $userEmailAddress;
	}
	
	public function getUserFavouriteGenre() {
		return $this->_userFavouriteGenre;
	}
	
	public function setUserFavouriteGenre($userFavouriteGenre) {
		$this->_userFavouriteGenre = $userFavouriteGenre;
	}
	
	public function getUserPhoneNumber() {
		return $this->_userPhoneNumber;
	}
	
	public function setUserPhoneNumber($userPhoneNumber) {
		$this->_userPhoneNumber = $userPhoneNumber;
	}
	
	public function getUserAccountPassword() {
		return $this->_userAccountPassword;
	}
	
	public function setUserAccountPassword($userAccountPassword) {
		$this->_userAccountPassword = $userAccountPassword;
	}
	
	public function getUserAccountType() {
		return $this->_userAccountType;
	}
	
	public function setUserAccountType($userAccountType) {
		$this->_userAccountType = $userAccountType;
	}
	
	public function loadMyPanel() {
		echo '<div id="menu_links">';
		switch ($this->_userAccountType) {
			case 2: // Administration Account
				self::loadPanelLinks(2);
			case 1: // Normal User Account
				self::loadPanelLinks(1);
				break;
		}
		echo '	<a href="#" id="menu_logout"></a>
				<script type="text/javascript">
					$(\'#menu_logout\').click(function () { 
						var parameters = {};
						parameters.action = \'logout\';
						process_request(\'login_actions\', parameters, login_response);
					});
				</script>
			</div>';
	}
	
	public function fetchCart() {
		$db = new DB();
		$statement = $db->prepare(SQL_USER_CART);
		$statement->bind_param("i", $this->getUserID());
		$statement->execute();
		$statement->bind_result($logID, $userID, $logDate, $logStatus);
		return ($statement->fetch()) ? new Log($logID, $userID, $logDate, $logStatus) : null;
	}
	
	public function checkEmail() {
			$user = self::getLoggedInUser();
			if (($user != null && $user->getUserEmailAddress() != $this->getUserEmailAddress()) || ($user == null))	{
				$db = new DB();
				$statement = $db->prepare(SQL_CHECK_EMAIL);
				$statement->bind_param("s", $this->getUserEmailAddress());
				$statement->execute();
				$statement->bind_result($count);
				$statement->fetch();
				$db->close();
				if ($count == 0) {
					return true;
				}
				return false;
			}
			return true;
	}
	
	public function insert() {
		$db = new DB();
		$statement = $db->prepare(SQL_USER_INSERT);
		$statement->bind_param('sssissi', $this->getUserFirstName(), 
							$this->getUserLastName(), 
							$this->getUserEmailAddress(),
							$this->getUserFavouriteGenre(),
							$this->getUserPhoneNumber(),
							$this->getUserAccountPassword(),
							$this->getUserAccountType());
		$statement->execute();
		$db->close();
		return true;
	}
	
	public function update() {
		$db = new DB();
		$statement = $db->prepare(SQL_USER_UPDATE);
		$statement->bind_param('sssisii', $this->getUserFirstName(), 
							$this->getUserLastName(), 
							$this->getUserEmailAddress(),
							$this->getUserFavouriteGenre(),
							$this->getUserPhoneNumber(),
							$this->getUserAccountType(),
							$this->getUserID());
		$statement->execute();
		if (strlen($this->getUserAccountPassword()) > 0) {
			$statement = $db->prepare(SQL_USER_CHANGE_PASSWORD);
			$statement->bind_param('si', $this->getUserAccountPassword(), $this->getUserID());
			$statement->execute();
		}
		$db->close();
		return true;
	}
	
	private static function loadPanelLinks($userAccountType) {
		$db = new DB();
		$statement = $db->prepare(SQL_PANEL_LINKS);
		$statement->bind_param("i", $userAccountType);
		$statement->execute();
		$statement->bind_result($linkName, $parameters);
		while($statement->fetch()) {
			echo '	<span id="menu_'.$linkName.'"></span>
					<script type="text/javascript">
						$(\'#menu_'. $linkName .'\').click(function () {
							load_content(\''. $linkName .'.php'.((strlen($parameters) > 0)? '?'.$parameters : '').'\');
						});
					</script>';
		}
		$db->close();
	}
		
	public static function showLoginArea() {
		echo '<div id="menu_links">';
		self::loadPanelLinks(0);
		echo '
		</div>
		<form id="login">
		  <fieldset id="login_menu">
			<p>
			  <label for="email_address">Email Address</label>
			  <input id="email_address" class="validate[required, custom[email]] text-input" name="email_address" value="" title="email address" tabindex="1" type="text" />
			</p>
			<p>
			  <label for="account_password">Password</label>
			  <input id="account_password" class="validate[required,custom[noSpecialCaracters],length[0,20]] text-input" name="account_password" value="" title="password" tabindex="2" type="password" />
			</p>
			<p class="login">
				<input value="Sign in" tabindex="3" type="submit" class="buttonSubmit" />
			</p>
		  </fieldset>
		</form>
		<script type="text/javascript">
		$(\'#login\').validationEngine({
			success : function() {
				var parameters = $(\'#login\').serializeForm();
				parameters.action = \'login\';
				process_request(\'login_actions\', parameters, login_response);
			},
			failure: function() {}
		});
		</script>';
	}
	
	public static function login($userEmailAddress, $userAccountPassword) {
		if (self::getLoggedInUser() == null) {
			$db = new DB();
			$statement = $db->prepare(SQL_LOGIN_CREDENTIALS);
			$statement->bind_param("ss", $userEmailAddress, $userAccountPassword);
			$statement->execute();
			$statement->bind_result($userID);
			$statement->fetch();
			$db->close();
			if ($userID > 0) {
				$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
				$_SESSION['user'] = $userID;
				return true;
			}
		}
		return false;
	}
	
	public static function logout() {
		session_unset();  
		session_destroy();
		return true;
	}
	
	public static function getLoggedInUser() {
		if (isset($_SESSION['agent']) AND ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT']))) {
			if (isset($_SESSION['user'])) {
				$userID = $_SESSION['user'];
				if ($userID > 0) {
					return self::create($userID);
				}
			}
		}
		return null;
	}
	
	public static function isAdminSession() {
		$user = self::getLoggedInUser();
		return (($user != null) && ($user->getUserAccountType() == 2));
	}
	
	public static function create($userID) {
		$db = new DB();
		$statement = $db->prepare(SQL_USER_FETCH);
		$statement->bind_param("i", $userID);
		$statement->execute();
		$statement->bind_result($userID, $userFirstName, $userLastName, $userEmailAddress, $userFavouriteGenre, $userPhoneNumber, $userAccountPassword, $userAccountType);
		$statement->fetch();
		$db->close();
		return new User($userID, $userFirstName, $userLastName, $userEmailAddress, $userFavouriteGenre, $userPhoneNumber, $userAccountPassword, $userAccountType);
	}
}
?>