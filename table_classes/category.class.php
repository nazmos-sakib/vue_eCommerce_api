<?php 
	
	//require_once('../includes/config.php');

	/**
	 * 
	 */
	class Category //extends Database
	{
		private $categoryId;
		private $categoryName;
		private $categoryDescription;
		private $categoryCreated_at;

		private $table_name = 'category';

		private $conn;


		function getId() {return $this->$id;}

		function setUserName($categoryName) {$this->categoryName = $categoryName;}
		function getUserName() {return $this->categoryName;}

		function setEmail($categoryDescription) {$this->categoryDescription = $categoryDescription;}
		function getEmail() {return $this->categoryDescription;}

		function getCreatedAt() {return $this->categoryCreated_at;}
		
		function __construct($conn)
		{
			//parent::__construct();
			$this->conn = $conn;
		}

		function doesExist($id)
		{
			//echo "varify user";
	  		$sql = "SELECT category_name FROM $this->table_name WHERE category_id ="."'".$id."'";
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

		
		function getAllCategoryData()
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

		function getSingelCategoryData($id)
		{
			$sql = "SELECT * FROM $this->table_name WHERE category_id = '$id'"; //'sakib";
	  		$result = $this->conn->query($sql);
	  		
			return $result->fetch_assoc();
		}

		function insertNewCategory($name, $description)
		{
			$sql = "INSERT INTO $this->table_name (category_name, category_description)
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
					$sql .=	" category_name = '" . $name . "'";
				}
				if(null != $description)
				{
					$sql .=	", category_description = '" . $description . "'";
				}

				$sql .=	" WHERE category_id = '" . $id ."'";

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
					$stmt = $this->conn->prepare('DELETE FROM ' . $this->table_name . ' WHERE category_id = ?');

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
					throw new Exception("Category not found", 1);
					
				}

			}
			else
			{
				throw new Exception("Id Not Found", 1);
			}
		}

	}

 ?>