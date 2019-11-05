<?php
require_once("MDB2.php");
require_once("Smarty/libs/Smarty.class.php");
class MySmarty extends Smarty {
	private $_db;
	public function __construct() {
		$this->Smarty();
		$this->template_dir="./templates";
		$this->compile_dir="./templates_c";
		$this->_db=MDB2::connect("mysql://root:atsuc@localhost/atsuc718");
	
	}
	public function __destruct() {
		$this->_db->disconnect();
	}
	public function getDb() {return $this->_db;}
}
?>