<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//Init global Constants
define('SITE_NAME', substr(dirname($_SERVER['SCRIPT_NAME']),1)); //--> php_mvc
define('ROOT_DIR', dirname(getcwd()) . '/' . SITE_NAME.'/'); //physical path on disk
define('URL_DIR', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']
		. '/' . SITE_NAME.'/');
/*
print(SITE_NAME); print('<br>');
print(ROOT_DIR); print('<br>');
print(URL_DIR); print('<br>');
exit;
*/

//Load required classes automatically
spl_autoload_register(function ($class) {
	$folders = array('controllers', 'models', 'dal');
	
	foreach($folders as $folder){
		if(file_exists(ROOT_DIR."$folder/Class.$class.php")){
			require(ROOT_DIR."$folder/Class.$class.php");
			return;
		}
	}	
});


session_start();

//Route to the correct method and view
$path = parse_url(
		(isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' .
		$_SERVER['HTTP_HOST'] .
		$_SERVER['REQUEST_URI']
	);
$parts = explode("/", substr($path['path'], 1));

//Get the controller and the view or method
$controller = strtolower((@$parts[1]) ? $parts[1] : "login");
$method = strtolower((@$parts[2]) ? $parts[2] : "login");

/*
 var_dump($parts); print('<br>');
 var_dump($controller); print('<br>');
 var_dump($method); print('<br>');
 exit;
*/

//Check if controller and method exist
if(!file_exists(ROOT_DIR."controllers/Class.{$controller}Controller.php")) {			
	$controller = "error";
	$method = "http404";
}
elseif (!method_exists("{$controller}Controller", "{$method}")){
	$controller = "error";
	$method = "http404";
}

//Instantiate controller class
$class = $controller . "Controller";
$controller_instance = new $class($controller, $method);

/*
 var_dump($controller_instance); print('<br>');
 exit;
*/

//Call controller method first then display the view
$controller_instance->$method();
$controller_instance->display();
