<?php 

class Database {
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $name = 'blogit';
	
	public function connect() {
		return new MySQLi($this->host, $this->user, $this->pass, $this->name);
	}
}

?>