<?php 

	/**
	 * 
	 */
	class Rest 
	{
		
		function __construct()
		{
			if($_SERVER['REQUEST_METHOD'] !== "POST")
			{
				$this->throwError(REQUEST_METHOD_NOT_VALID, "request method not valid");
			}
			else
			{
				//$data = json_decode(file_get_contents('php://input'));
				$handler = fopen('php://input','r');
				$this->request = stream_get_contents($handler);
				//print_r($this->request);
				$this->validateRequest();

				if( 'generatetoken' != strtolower( $this->serviceName) ) 
				{
					$this->validateToken();
				}

			}
		}

		function validateRequest()
		{
			//echo $_SERVER['CONTENT_TYPE'];exit;
			if ($_SERVER['CONTENT_TYPE'] !== 'application/json') 
			{
				$this->throwError(REQUEST_CONTENTTYPE_NOT_VALID, "REQUEST_CONTENTTYPE_NOT_VALID");
			}
			else
			{
				$data = json_decode($this->request,true);
				//print_r($data);

				if(!isset($data['service_name']) || $data['service_name'] == "")
				{
					$this->throwError(API_NAME_REQUIRED, "Service Name is required");
				}
				else
				{
					$this->serviceName = $data['service_name'];
					//echo $this->serviceName;
				}

				if(!is_array($data['param']))
				{
					$this->throwError(API_PARAM_REQUIRED, "Parameter is required");
				}
				else
				{
					$this->param = $data['param'];
				}

			}
		}

		function validateParameter($fieldName, $value, $dataType, $required=true)
		{
			if($required && empty($value))
			{
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName.' PARAMETER_REQUIRED');
			}

			switch ($dataType) {
				case BOOLEAN:
					if(is_bool($value))
					{
						$this->throwError(VALIDATE_PARAMETER_DATATYPE, "datatype not valid for ". $fieldName . " it should be boolean.");
					}
					break;

				case INTEGER:
					if(is_bool($value))
					{
						$this->throwError(VALIDATE_PARAMETER_DATATYPE, "datatype not valid for ". $fieldName . " it should be integer.");
					}
					break;

				case STRING:
					if(is_bool($value))
					{
						$this->throwError(VALIDATE_PARAMETER_DATATYPE, "datatype not valid for ". $fieldName . " it should be string.");
					}
					break;
				
				default:
					$this->throwError(VALIDATE_PARAMETER_DATATYPE, "datatype not valid for ". $fieldName);
					break;
			}

			return $value;
		}

		public function validateToken() 
		{
			try {
				$token = $this->getBearerToken();
				$payload = JWT::decode($token, SECRETE_KEY, ['HS256']);
				//print_r($payload);
				try 
				{
					$db = new Database();
				} catch (Exception $e) 
				{
					$this->throwError(DATABASE_ERROR, $e->getMessage());
				}
				
				$user = new Users($db->conn);

				$single = $user->varify_userById($payload->userId);

				if(!$single) {
					$this->returnResponse(INVALID_USER, "No user found.");
				}

				$this->userId = $payload->userId;
			} catch (Exception $e) {
				$this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
			}
		}

		function returnResponse($code, $data)
		{
			//header("Content-Type: application/json");
			$response = json_encode(['response' => ['error'=> false, 'status'=>$code, 'message'=>$data]]);

			echo $response;
			exit;
		}

		function throwError($code,$message)
		{	
			header('Content-Type: application/json');
			$errorMessage = json_encode(["response"=>['error'=> true, 'status'=>$code, "message"=>$message]]);
			echo $errorMessage;
			exit;
		}


		/**
	    * Get hearder Authorization
	    * */
	    public function getAuthorizationHeader(){
	        $headers = null;
	        if (isset($_SERVER['Authorization'])) {
	            $headers = trim($_SERVER["Authorization"]);
	        }
	        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
	            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	        } elseif (function_exists('apache_request_headers')) {
	            $requestHeaders = apache_request_headers();
	            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	            if (isset($requestHeaders['Authorization'])) {
	                $headers = trim($requestHeaders['Authorization']);
	                //echo $headers;
	            }
	        }
	        return $headers;
	    }
	    /**
	     * get access token from header
	     * */
	    public function getBearerToken() {
	        $headers = $this->getAuthorizationHeader();
	        // HEADER: Get the access token from the header
	        if (!empty($headers)) {
	            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	                return $matches[1];
	            }
	        }
	        $this->throwError( ATHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
	    }
	}

 ?>