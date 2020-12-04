<?php 
	
	
	//headers
	//'Access-Control-Allow-Origin'
	
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Content-Type: application/json');

	//initializing our api
	//include_once('./core/initialize.php');
	require_once('api.main.php');

	$api = new Api();
	$api->processApi();
	


 ?>