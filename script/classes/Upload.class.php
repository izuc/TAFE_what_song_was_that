<?php
class Upload {
	private $_directoryPath;
	private $_uploadTmpName;
	private $_uploadFileName;
	private $_uploadMaxSize;
	private $_uploadFileSize;
	private $_uploadFileType;
	private $_errors = array();
	
	private function getUploadFullName() {
		return $this->_directoryPath . '/' . $this->_uploadFileName;
	}
	
	private function addError($message) {
		$this->_errors[] = $message;
	}
	
	public function setDirectoryPath($directoryPath = '.') {
		$this->_directoryPath = $directoryPath;
	}
	
	public function setUploadTmpName($uploadTmpName) {
		$this->_uploadTmpName = $uploadTmpName;
	}
	
	public function setUploadFileName($uploadFileName) {
		$this->_uploadFileName = $uploadFileName;
	}
	
	public function setUploadMaxSize($uploadMaxSize = 200000) {
		$this->_uploadMaxSize = $uploadMaxSize;
	}
	
	public function setUploadFileSize($uploadFileSize) {
		$this->_uploadFileSize = $uploadFileSize;
	}
	
	public function setUploadFileType($uploadFileType) {
		$this->_uploadFileType = $uploadFileType;
	}
	
	public function setUploadFullName($uploadFullName) {
		$this->_uploadFullName = $uploadFullName;
	}
	
	public function showErrors() {
		foreach ($this->_errors as $error) {
			echo $error . '<br />';
		}
	}
	
	public function hasErrors() {
		return (sizeof($this->_errors) > 0);
	}
			
	public function uploadFile() {
		if (!isset($this->_uploadFileName)) {
			$this->addError("You must define a file name");
		}
		
		if ($this->_uploadFileSize <= 0) {
			$this->addError("File must have some mass");
		}
		
		if ($this->_uploadFileSize > $this->_uploadMaxSize) {
			$this->addError("File size cannot exceed " . $this->_uploadMaxSize);
		}
		
		if (!$this->hasErrors()) {
			$destination = ((!empty($this->_directoryPath))? $this->getUploadFullName() : basename($this->_uploadFileName));
			if (!is_uploaded_file($this->_uploadTmpName)) {
				$this->addError("File " . $this->_uploadTmpName . " has not been uploaded correctly.");
			}
			if (!@move_uploaded_file($this->_uploadTmpName, $destination)) {
				$this->addError("Impossible to copy " . $this->_uploadFileName . " to destination directory");
			}
		} else {
			foreach ($this->_errors as $error) {
				echo $error . '<br />';
			}
		}
	}
}
?>