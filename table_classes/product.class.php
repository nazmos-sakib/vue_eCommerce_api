<?php 
	
	//require_once('../includes/config.php');

	/**
	 * 
	 */
	class Product //extends Database
	{
		private $id;
		private $name;
		private $description;
		private $category_id;
		private $supplier_id;
		private $price;
		private $image;
		private $created_at;

		private $table_product = 'product';
		private $table_supplier = 'supplier';
		private $table_category = 'category';

		private $conn;


		function getId() {return $this->$id;}

		function setProductName($name) {$this->name = $name;}
		function getProductName() {return $this->name;}

		function setDescription($description) {$this->description = $description;}
		function getDescription() {return $this->description;}

		function setCataegoryId($id) {$this->category_id = $id;}
		function getCategoryId() {return $this->category_id;}

		function setSupplierId($id) {$this->supplier_id = $id;}
		function getSupplierId() {return $this->supplier_id;}

		function getCreatedAt() {return $this->created_at;}
		
		function __construct($conn)
		{
			//parent::__construct();
			$this->conn = $conn;
		}

		function doesExist($id)
		{
			//echo "varify user";
	  		$sql = "SELECT product_name FROM product WHERE product_id ="."'".$id."'";
	  		$result = $this->conn->query($sql);
			//print_r($result);
			if ($result->num_rows == 1) 
			{
			    return true;
			}
			else 
			{
			 	return false;
			}
		}

		//SELECT product.product_id, product.product_name, product.product_description, product.product_supplier_id, supplier.supplier_name, product.product_category_id, category.category_name FROM product LEFT JOIN category ON product.product_category_id = category.category_id LEFT JOIN supplier ON product.product_supplier_id = supplier.supplier_id
		function getAllProductData()
		{
			//$sql = "SELECT * FROM $this->table_name"; //'sakib";
			$sql = "SELECT product.product_id, product.product_name, product.product_description, product.product_supplier_id, supplier.supplier_name, product.product_category_id, category.category_name, product.product_price, product.product_image FROM product LEFT JOIN category ON product.product_category_id = category.category_id LEFT JOIN supplier ON product.product_supplier_id = supplier.supplier_id";
	  		$asd = $this->conn->query($sql);

	  		$result = [];
			while($row = $asd->fetch_assoc())
			{
				array_push($result,$row);
			}
			return $result;
		}

		function getSingelProductData($id)
		{
			//$sql = "SELECT * FROM $this->table_name WHERE id = '$id'"; //'sakib";
			$sql = "SELECT product.product_id, product.product_name, product.product_description, product.product_supplier_id, supplier.supplier_name, product.product_category_id, category.category_name, product.product_price, product.product_image FROM product LEFT JOIN category ON product.product_category_id = category.category_id LEFT JOIN supplier ON product.product_supplier_id = supplier.supplier_id WHERE product.product_id = '$id'";
	  		$result = $this->conn->query($sql);
	  		
			return $result->fetch_assoc();
		}

		//INSERT INTO `product` (`product_id`, `product_name`, `product_category_id`, `product_supplier_id`, `product_description`, `product_image`, `product_price`, `product_created_at`) VALUES (NULL, '', '', '', NULL, NULL, '', current_timestamp());
		function insertNewProduct($name,$catId, $supId, $description, $img, $price)
		{
			$sql = "INSERT INTO $this->table_product (product_name, product_category_id, product_supplier_id, product_description, product_image, product_price)
	  		VALUES (?,?,?,?,?,?)";
	  		$stmt = $this->conn->prepare($sql);

	  		$stmt->bind_param("ssssss", $n, $cId, $sId, $des, $im, $p);

	  		$n = $name;
	  		$cId = $catId;
	  		$sId = $supId;
	  		$des = $description;
	  		$im = $img;
	  		$p = $price;

	  		if($stmt->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function update($id,$name,$catId, $supId, $description, $img, $price)
		{
			if($id != null)
			{
				$sql = "UPDATE $this->table_product SET";

				if(null != $name)
				{
					$sql .=	" product_name = '" . $name . "'";
				}
				if(null != $catId)
				{
					$sql .=	", product_category_id = '" . $catId . "'";
				}
				if(null != $supId)
				{
					$sql .=	", product_supplier_id = '" . $supId . "'";
				}
				if(null != $description)
				{
					$sql .=	", product_description = '" . $description . "'";
				}
				if(null != $img)
				{
					$sql .=	", product_image = '" . $img . "'";
				}
				if(null != $price)
				{
					$sql .=	", product_price = '" . $price . "'";
				}

				$sql .=	" WHERE product_id = '" . $id ."'";

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
					$stmt = $this->conn->prepare('DELETE FROM ' . $this->table_product . ' WHERE product_id = ?');

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