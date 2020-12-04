<?php 
	
	include_once('./core/initialize.php');
	/**
	 * 
	 */
	class Api extends Rest
	{
		protected $request;
		protected $serviceName;
		protected $param;
		protected $dbConn;
		protected $userId;
		
		function __construct()
		{
			parent::__construct();
			//echo "good";
		}

		function echoService()
		{
			echo "this is echo";
		}

		function verifyToken()
		{
			$this->returnResponse(SUCCESS_RESPONSE, "Token is valid");
		}

		function generateToken()
		{
			$flag = 1;
			$email = isset($this->param['email']) ? $this->param['email'] : $flag = 0;
			$password = isset($this->param['pass']) ? $this->param['pass'] : $flag = 0;

			if($flag)
			{
				$email = $this->validateParameter( 'email', $this->param['email'], STRING);

				$password = $this->validateParameter( 'password', $this->param['pass'], STRING);

				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$user = new Users($db->conn);

				//print_r($user->varify_user($email,$password));

				try 
				{
					
					if(!$user->varify_user($email,$password))
					{
						$this->returnResponse(INVALID_USER_PASS, "Email and password not matched");
					}
					
					$userData = $user->getSingelUsersDataByEmail($email);
					//print_r($userData['id']);
					//die();
					$payload = [
						'iat' => time(),
						'iss' => 'localhost',
						'exp' => time() + (60*60*2),
						'userId' => $userData['id']
					];

					$token = JWT::encode($payload, SECRETE_KEY);
					$data = ['token'=>$token];
					$this->returnResponse(SUCCESS_RESPONSE, $data);
					
				} catch (Exception $e) 
				{
					$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Email and Pass JSON data is required ");
			}
			
		}

		//--------------------------------Category-----------------
		function addNewCategory()
		{
			$flag = 1;
			$name = isset($this->param['name']) ? $this->param['name'] : $flag = 0;
			$description = isset($this->param['description']) ? $this->param['description'] : null;

			if($flag)
			{
				$name = $this->validateParameter( 'name', $this->param['name'], STRING);
				if (!$description == null) {
					$description = $this->validateParameter( 'description', $this->param['description'], STRING);
				}
				
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$category = new Category($db->conn);

				try 
				{
					
					if(!$category->insertNewCategory($name,$description))
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_ADDING_NEW_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Inserted Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Category Name and Description as JSON data is required ");
			}
			
		}

		function getAllCategory()
		{
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, "Problem with loding category data. ".$e->getMessage());
				}
				
				$category = new Category($db->conn);
				try 
				{
					$data = $category->getAllCategoryData();
					$this->returnResponse(SUCCESS_RESPONSE, $data);
					
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, "Problem with loding category data. ".$e->getMessage());
				}						
		}

		function updateCategory()
		{
			$flag = 1;
			$id = isset($this->param['category_id']) ? $this->param['category_id'] : $flag = 0;
			$name = isset($this->param['category_name']) ? $this->param['category_name'] : null;
			$description = isset($this->param['category_description']) ? $this->param['category_description'] : null;

			if($flag)
			{
				$name = $this->validateParameter( 'category_name', $this->param['category_name'], STRING);

				$description = $this->validateParameter( 'category_description', $this->param['category_description'], STRING);

				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$category = new Category($db->conn);

				try 
				{
					
					if(!$category->update($id,$name,$description))
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_ADDING_NEW_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Updated Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Category Name and Description as JSON data is required ");
			}
			
		}

		function deleteCategory()
		{
			$flag = 1;
			$id = isset($this->param['category_id']) ? $this->param['category_id'] : $flag = 0;

			if($flag)
			{
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$category = new Category($db->conn);

				try 
				{
					$result = $category->delete($id);
					if(!$result)
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_DELETING_THIS_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Deleted Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Category Name and Description as JSON data is required ");
			}
			
		}

		//--------------------------------supplier-----------------
		function addNewSupplier()
		{
			$flag = 1;
			$name = isset($this->param['supplier_name']) ? $this->param['supplier_name'] : $flag = 0;
			$description = isset($this->param['supplier_description']) ? $this->param['supplier_description'] : null;

			if($flag)
			{
				$name = $this->validateParameter( 'supplier_name', $this->param['supplier_name'], STRING);
				if (!$description == null) {
					$description = $this->validateParameter( 'supplier_description', $this->param['supplier_description'], STRING);
				}
				
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$category = new Supplier($db->conn);

				try 
				{
					
					if(!$category->insertNewSupplier($name,$description))
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_ADDING_NEW_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Inserted Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Supplier Name and Description as JSON data is required ");
			}
			
		}

		function getAllSupplier()
		{
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, "Problem with loding category data. ".$e->getMessage());
				}
				
				$category = new Supplier($db->conn);
				try 
				{
					$data = $category->getAllSupplierData();
					$this->returnResponse(SUCCESS_RESPONSE, $data);
					
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, "Problem with loding category data. ".$e->getMessage());
				}						
		}

		function updateSupplier()
		{
			$flag = 1;
			$id = isset($this->param['supplier_id']) ? $this->param['supplier_id'] : $flag = 0;
			$name = isset($this->param['supplier_name']) ? $this->param['supplier_name'] : null;
			$description = isset($this->param['supplier_description']) ? $this->param['supplier_description'] : null;

			if($flag)
			{
				$name = $this->validateParameter( 'supplier_name', $this->param['supplier_name'], STRING);

				$description = $this->validateParameter( 'supplier_description', $this->param['supplier_description'], STRING);

				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$category = new Supplier($db->conn);

				try 
				{
					
					if(!$category->update($id,$name,$description))
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_ADDING_NEW_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Updated Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Supplier Name and Description as JSON data is required ");
			}
			
		}

		function deleteSupplier()
		{
			$flag = 1;
			$id = isset($this->param['supplier_id']) ? $this->param['supplier_id'] : $flag = 0;

			if($flag)
			{
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$category = new Supplier($db->conn);

				try 
				{
					$result = $category->delete($id);
					if(!$result)
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_DELETING_THIS_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Deleted Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Supplier Name and Description as JSON data is required ");
			}
			
		}

		//--------------------------------Product-----------------
		function getAllProduct()
		{
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, "Problem with loding category data. ".$e->getMessage());
				}
				
				$category = new Product($db->conn);
				try 
				{
					$data = $category->getAllProductData();
					$this->returnResponse(SUCCESS_RESPONSE, $data);
					
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, "Problem with loding Product. ".$e->getMessage());
				}						
		}

		function getSingleProduct()
		{
			$flag = 1;
			$pId = isset($this->param['pid']) ? $this->param['pid'] : $flag = 0;
			try 
			{
				$db = new Database();
			} catch (Exception $e) 
			{
				$this->throwError(DATABASE_ERROR, "Problem with loding category data. ".$e->getMessage());
			}
			
			$category = new Product($db->conn);
			try 
			{
				$data = $category->getSingelProductData($pId);
				$this->returnResponse(SUCCESS_RESPONSE, $data);
				
			} catch (Exception $e) 
			{
				$this->throwError(DATABASE_ERROR, "Problem with loding Product. ".$e->getMessage());
			}

		}

		function addNewProduct()
		{
			$flag = 1;
			$name = isset($this->param['product_name']) ? $this->param['product_name'] : $flag = 0;
			$cId = isset($this->param['product_category_id']) ? $this->param['product_category_id'] : $flag = 0;
			$sId = isset($this->param['product_supplier_id']) ? $this->param['product_supplier_id'] : $flag = 0;
			$price = isset($this->param['price']) ? $this->param['price'] : $flag = 0;
			$description = isset($this->param['product_description']) ? $this->param['product_description'] : null;
			$img = isset($this->param['image']) ? $this->param['image'] : null;

			if($flag)
			{
				$name = $this->validateParameter( 'product_name', $this->param['product_name'], STRING);				
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$product = new Product($db->conn);

				try 
				{
					
					if(!$product->insertNewProduct($name,$cId, $sId, $description, $img, $price))
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_ADDING_NEW_PRODUCT");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Inserted Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "JSON formated data is required ");
			}
			
		}

		function updateProduct()
		{
			$flag = 1;
			$id = isset($this->param['product_id']) ? $this->param['product_id'] : $flag = 0;
			$name = isset($this->param['product_name']) ? $this->param['product_name'] : null;
			$description = isset($this->param['product_description']) ? $this->param['product_description'] : null;
			$supplier_id = isset($this->param['product_supplier_id']) ? $this->param['product_supplier_id'] : null;
			$category_id = isset($this->param['product_category_id']) ? $this->param['product_category_id'] : null;
			$price = isset($this->param['product_price']) ? $this->param['product_price'] : null;
			$image = isset($this->param['product_image']) ? $this->param['product_image'] : null;

			if($flag)
			{
				
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$product = new Product($db->conn);

				try 
				{
					
					if(!$product->update($id,$name,$category_id, $supplier_id, $description, $image, $price))
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_ADDING_NEW_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Updated Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Supplier Name and Description as JSON data is required ");
			}
		}

		function deleteProduct()
		{
			$flag = 1;
			$id = isset($this->param['product_id']) ? $this->param['product_id'] : $flag = 0;

			if($flag)
			{
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$product = new Product($db->conn);

				try 
				{
					$result = $product->delete($id);
					if(!$result)
					{
						$this->returnResponse(UNSUCCESSFUL_ADDING_NEW_CATEGORY, "UNSUCCESSFUL_DELETING_THIS_CATEGORY");
					}
					else
					{
						$this->returnResponse(SUCCESS_RESPONSE, "Deleted Successfully");
					}
										
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
			}
			else
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, "Supplier Name and Description as JSON data is required ");
			}
			
		}

		function placeOrder()
		{
			$this->returnResponse(SUCCESS_RESPONSE, "Order Placesed successfully");
		}





		function processApi()
		{
	
			 $serviceName = $this->serviceName;
			 if (is_callable([$this, $serviceName])) {
			  $this->$serviceName();
			 } else {
			  $this->throwError(API_DOES_NOT_EXIST, 'service not found');
			 }
		}
	}

	


 ?>