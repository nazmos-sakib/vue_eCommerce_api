<?php 

	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	defined('SITE_ROOT') ? null : define('SITE_ROOT', DS. 'xampp'.DS.'htdocs'.DS.'vue_eCommerce_api');

	//xampp/htdocs/PHP_REST/includes
	defined('INC_PATH') ? null : define('INC_PATH', SITE_ROOT.DS.'includes');

	//xampp/htdocs/PHP_REST/core
	defined('CORE_PATH') ? null : define('CORE_PATH', SITE_ROOT.DS.'core');
	
	defined('CLASS_PATH') ? null : define('CLASS_PATH', SITE_ROOT.DS.'table_classes');

	//require_once(SITE_ROOT.DS.'api.main.php');

	//load config file
	require_once(INC_PATH.DS.'db.config.php');
	require_once(INC_PATH.DS.'constant.var.php');
	
	//core classes
	require_once(CORE_PATH.DS.'rest.control.php');
	require_once(CORE_PATH.DS.'JWT.php');

	//Auto load DB table classes
	spl_autoload_register(function($className)
	{
		$path = CLASS_PATH.DS. strtolower($className) . ".class.php";
		//echo $path;
		if (file_exists($path)) 
		{
			require_once($path);
		}
		else
		{
			echo "File path not found.";
		}
	}) ;



 ?>