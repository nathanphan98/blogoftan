<?php
class database
{
	//DB Params
	// private $dns = "mysql:host=buhmasp5eu6jmldydmdw-mysql.services.clever-cloud.com;dbname=buhmasp5eu6jmldydmdw";
	// private $username = "uose4h1bb2dlhzt3";
	// private $password = "zUwBL4f2SjGOx8tQamqN";

	private $dns = "mysql:host=localhost;dbname=blog";
	private $username = "root";
	private $password = "";
	
	private $conn;

	//DB Connect
	public function connect()
	{
		$this->conn = null;
		try {
			$this->conn = new PDO($this->dns, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}

		return $this->conn;
	}
}
