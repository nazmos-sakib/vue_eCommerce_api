<?php 
	
	//require_once('../includes/config.php');

	/**
	 * 
	 */
	class Users //extends Database
	{
		private $id;
		private $username;
		private $email;
		private $password;
		private $created_at;

		private $table_name = 'users';

		private $conn;


		function getId() {return $this->$id;}

		function setUserName($username) {$this->username = $username;}
		function getUserName() {return $this->username;}

		function setEmail($email) {$this->email = $email;}
		function getEmail() {return $this->email;}

		function setPassword($password) {$this->password = $password;}
		function getPassword() {return $this->password;}

		function getCreatedAt() {return $this->password;}
		
		function __construct($conn)
		{
			//parent::__construct();
			$this->conn = $conn;
		}

		function varify_user($email,$password)
		{
			//echo "varify user";
	  		$sql = "SELECT password FROM $this->table_name where email ="."'".$email."'"; //'sakib";
	  		$result = $this->conn->query($sql);

			/*echo $result->num_rows;
			//echo $result->fetch_assoc();
			foreach($result->fetch_assoc() as $x => $x_value) {
			  echo "Key=" . $x . ", Value=" . $x_value;
			  echo "<br>";
			}
			return;
			*/
			
			if ($result->num_rows == 1) 
			{
			    // output data of each row
				$row = $result->fetch_assoc();
				
				if (!strcmp($password, $row["password"]))
				{
					return true;
				} 
				else 
				{
					return false;
				}		
				
			}
			else 
			{
			 	return false;
			}
		}

		function varify_userById($id)
		{
			//echo "varify user";
	  		$sql = "SELECT email FROM $this->table_name WHERE id ="."'".$id."'"; //'sakib";
	  		$result = $this->conn->query($sql);
		
			if ($result->num_rows == 1) 
			{
			    return true;
			}
			else 
			{
			 	return false;
			}
		}

		function getAllUsersData()
		{
			$sql = "SELECT * FROM $this->table_name"; //'sakib";
	  		$asd = $this->conn->query($sql);

	  		$result = [];
			while($row = $asd->fetch_assoc())
			{
				array_push($result,$row);
			}

			return $result;
		}

		function getSingelUsersDataByEmail($email)
		{
			$sql = "SELECT id FROM $this->table_name WHERE email = '$email'"; //'sakib";
	  		$result = $this->conn->query($sql);
	  		
			return $result->fetch_assoc();
		}

		function getSingelUsersDataById($id)
		{
			$sql = "SELECT * FROM $this->table_name WHERE id = '$id'"; //'sakib";
	  		$result = $this->conn->query($sql);
	  		
			return $result->fetch_assoc();
		}

		function insertNewUser($username, $email, $password)
		{
			$sql = "INSERT INTO $this->table_name (username, email, password)
	  		VALUES (?,?,?,?,?)";
	  		$stmt = $this->conn->prepare($sql);

	  		$stmt->bind_param("sss", $fullname, $owneremail, $pass);

	  		$fullname = $username;
	  		$owneremail = $email;
	  		$pass = $password;

	  		if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function update($id = null, $username = null, $password = null) 
		{
			if($id != null)
			{
				$sql = "UPDATE $this->table_name SET";

				if(null != $username)
				{
					$sql .=	" username = '" . $username . "',";
				}
				if(null != $password)
				{
					$sql .=	" password = '" . $password . "',";
				}

				$sql .=	" WHERE id = '" . $id ."'";

				$stmt = $this->conn->prepare($sql);

				if($stmt->execute())
				{
					//return $stmt->affected_rows
					return true;
				}
				else
				{
					die("update error" . $stmt->error);
					return false;
				}

			}
			else
			{
				die("Id require.");
			}
			
			
		}

		function delete($id = null)
		{

			if($id != null)
			{
				$stmt = $this->dbConn->prepare('DELETE FROM ' . $this->tableName . ' WHERE id = ?');

				$stmt = $this->dbConn->prepare($sql);

				$stmt->bindParam('d', $id);

				if($stmt->execute())
				{
					return true;
				}
				else
				{
					die("update error" . $stmt->error);
					return false;
				}
			}

			else
			{
				die("Id require.");
			}
		}


	}

	
	

 ?>