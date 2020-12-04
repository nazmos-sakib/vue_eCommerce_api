<?php 
	
	//require_once('../includes/config.php');

	/**
	 * 
	 */
	class Supplier //extends Database
	{
		private $supplierId;
		private $supplierName;
		private $supplierDescription;
		private $supplierCreated_at;

		private $table_name = 'supplier';

		private $conn;


		function getId() {return $this->$supplierId;}

		function setUserName($supplierName) {$this->supplierName = $supplierName;}
		function getUserName() {return $this->supplierName;}

		function setEmail($supplierDescription) {$this->supplierDescription = $supplierDescription;}
		function getEmail() {return $this->supplierDescription;}

		function getCreatedAt() {return $this->supplierCreated_at;}
		
		function __construct($conn)
		{
			//parent::__construct();
			$this->conn = $conn;
		}

		function doesExist($id)
		{
	  		$sql = "SELECT supplier_name FROM $this->table_name WHERE supplier_id ="."'".$id."'";
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

		
		function getAllSupplierData()
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

		function getSingelSupplierData($id)
		{
			$sql = "SELECT * FROM $this->table_name WHERE supplier_id = '$id'"; //'sakib";
	  		$result = $this->conn->query($sql);
	  		
			return $result->fetch_assoc();
		}

		function insertNewSupplier($name, $description)
		{
			$sql = "INSERT INTO $this->table_name (supplier_name, supplier_description)
	  		VALUES (?,?)";
	  		$stmt = $this->conn->prepare($sql);

	  		$stmt->bind_param("ss", $n, $des);

	  		$n = $name;
	  		$des = $description;

	  		if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function update($id = null, $name = null, $description = null) 
		{
			if($id != null)
			{
				$sql = "UPDATE $this->table_name SET";

				if(null != $name)
				{
					$sql .=	" supplier_name = '" . $name . "'";
				}
				if(null != $description)
				{
					$sql .=	", supplier_description = '" . $description . "'";
				}

				$sql .=	" WHERE supplier_id = '" . $id ."'";

				$stmt = $this->conn->prepare($sql);

				//echo $sql;

				if($stmt->execute())
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

		function delete($id = null)
		{

			if($id != null)
			{
				if ($this->doesExist($id)) 
				{
					$stmt = $this->conn->prepare('DELETE FROM ' . $this->table_name . ' WHERE supplier_id = ?');

					$stmt->bind_param('s', $id);

					if($stmt->execute())
					{
						return true;
					}
					if($stmt->execute())
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
					throw new Exception("Supplier not found", 1);
					
				}

			}
			else
			{
				throw new Exception("Id Not Found", 1);
			}
		}

	}

 ?>