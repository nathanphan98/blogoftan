<?php
class database
{
	//DB Params
	private $dns = "mysql:host=bz04p5joz9eocaxxpli4-mysql.services.clever-cloud.com;dbname=bz04p5joz9eocaxxpli4";
	private $username = "u2agpwal6duhee3x";
	private $password = "EANi9cU5HiD9lakUcbnK";
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
