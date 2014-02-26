<?php
require_once('DB.class.php');

class Pagination {
	private $_page;
	private $_limit;
	private $_sidx;
	private $_sord;
	private $_count;
	
    public function Pagination($countQuery) {
		$this->setLimit((isset($_REQUEST['rows']) ? $_REQUEST['rows'] : 10));
		$this->setSidx((isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : 1)); 
		$this->setSord((isset($_REQUEST['sord']) ? $_REQUEST['sord'] : 'ASC'));
		$this->setCount($countQuery);
		$this->setPage((isset($_REQUEST['page']) ? $_REQUEST['page'] : 1)); 
    }
	
	private function getNextPage() {
		$page = $this->getPage();
		$total = $this->getTotalPages();
		return ((($page > 0) && ($page < $total))? ++$page : (($page == $total)? $total : 1));
    }
    
    private function getPrevPage() {
		$page = $this->getPage();
		$total = $this->getTotalPages();
        return ((($page > 1) && ($page <= $total))? --$page: 1); 
    }
	
	public function getPage() {	
		return (($this->_page > $this->getTotalPages())? $this->getTotalPages() : ($this->_page <= 1)? 1 : $this->_page);
	}
	
	public function setPage($page) {
		$this->_page = $page;
	}
	
	public function getLimit() {
		return $this->_limit;
	}
	
	public function setLimit($limit) {
		$this->_limit = $limit;
	}
	
	public function getSidx() {
		return $this->_sidx;
	}
	
	public function setSidx($sidx) {
		$this->_sidx = $sidx;
	}
	
	public function getSord() {
		return $this->_sord;
	}
	
	public function setSord($sord) {
		$this->_sord = $sord;
	}
	
	public function getCount() {
		return $this->_count;
	}
	
	public function setCount($countQuery) {
		$db = new DB();
		$result = $db->query($countQuery);
		if ($result) {
			$row = $result->fetch_row();
			$this->_count = (($row[0] > 0) ? $row[0] : 0);
		}
	}
	
	public function getTotalPages() {
		return (($this->getCount() > 0) ? ceil($this->getCount() / $this->getLimit()) : 0);
	}
	
	public function getStart() {
		return ($this->getLimit() * $this->getPage() - $this->getLimit());
	}
	
	public function getResult($query, $order = "") {
		$db = new DB();
		return $db->query($query. " ORDER BY ".$this->getSidx()." ".$this->getSord().$order." LIMIT ".$this->getStart()." , ".$this->getLimit());
	}
	
	public function show($jsFunction) {
			$previous_button = ($this->getPage() <= 1)? ' disablelink' : '';
			$next_button = ($this->getPage() >= $this->getTotalPages())? ' disablelink' : '';
			
			echo '<div class="pagination">
					<ul>
					  <li><a onClick="'.$jsFunction.'('.$this->getPrevPage().');" class="prevnext'.$previous_button.'">< previous</a></li>';
						for ($i = 1; $i <= $this->getTotalPages(); $i++) {
							if ($this->getPage() == $i) {
								echo '<a onClick="'.$jsFunction.'('.$i.');" class="currentpage">'.$i.'</a>';
							} else {
								echo '<a onClick="'.$jsFunction.'('.$i.');">'.$i.'</a>';
							}
						}
			echo '
					  <li><a onClick="'.$jsFunction.'('.$this->getNextPage().');" class="prevnext'.$next_button.'">next ></a></li>
				</ul>
			</div>';
	}
}
?>