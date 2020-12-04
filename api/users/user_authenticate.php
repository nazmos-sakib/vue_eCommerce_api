<?php 
	
	//headers
	//'Access-Control-Allow-Origin'
	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Content-Type: application/json');

	//initializing our api
	include_once('../../core/initialize.php');

	//instantiate post
	$user = new Users();

	//get raw posted data
	$data = json_decode(file_get_contents('php://input'));
	
	$username = $data->username;
	$password = $data->password;

	print_r($data);
	exit;

	$flag = 0;

	/*$username = isset($_POST['username']) ? $_POST['username'] : $flag = 1 ;
	$password = isset($_POST['password']) ? $_POST['password'] : $flag = 1*/ ;

	//$user->varify_user($data->username,$data->password);

	//create post
	if (!$flag) 
	{
		if($user->varify_user($username,$password))
		{
			echo json_encode(
				array('message' => 'Log in successful','error' => false)
			);
		}
		else
		{
			echo json_encode(
				array('message' => 'Log in unsuccessful','error' => true)
			);
		}
	}
	else
	{
		echo json_encode(
				array('message' => 'insert name and password','error' => true)
			);
	}



 ?>

 