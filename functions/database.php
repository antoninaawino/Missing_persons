<?php 
declare(strict_types=1);
/**
 * 
 */
class DB
{
	private $db;
	private $host = 'localhost';
	private $dbname = 'lost_found';
	private $dbuser = 'root';
	private $dbpass = '';

	

	public function __construct()
	{
		if (is_object($this->db)) {
			return $this->db = $this->db;
		}else {
			$dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
			$this->db = new \PDO($dsn,$this->dbuser,$this->dbpass);
			return $this->db;
		}
	}
	
}

	

 ?>