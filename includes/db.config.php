<?php


/**
 * 
 */
class Database
{

	private $servername = "127.0.0.1";
	private $username = "root";
	private $password = "";
	private $dbname = "vue_ecommerce";

	
	function __construct()
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) 
		{
			//die("Connection failed: " . $this->conn->connect_error);
			throw new Exception("Database Connection Error", 1);
			
		}
		//echo "Connected successfully";
	}


	function __destruct() 
	{
		$this->conn->close();
   		 //echo "<br>Connection close successfully";
	}
}

?>