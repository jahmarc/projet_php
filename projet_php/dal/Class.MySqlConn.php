<?php
/**
 * Connection class to mySQL Server
 * @author S. Martin
 * @link http://www.hevs.ch
 */
class MySqlConn {
	const HOST = "127.0.0.1";
	const PORT = "3306";
	const DATABASE = "php_mvc";
	const USER = "root";
	const PWD = "";
	
	private static $instance;
	private $_conn;
	
	/**
	 * prevent from direct creation of object
	 */
	private function __construct()
	{
		try{
			$this->_conn = new PDO('mysql:host='.self::HOST.
								  ';port='.self::PORT.
								  ';dbname='.self::DATABASE, 
									self::USER, self::PWD,array(
           							PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}
		catch (PDOException $e) {
			die ('Connection failed: ' . $e->getMessage());
		}			
	}
	
	/**
	 * singleton method
	 * @return resource
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance)|| self::$instance == null)
		{
			$c = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}
			
	public function execute($query, $attributes){		
		// L’utilisation de déclarations empêche les injections SQL
		$stmt = $this->_conn->prepare($query);
		$stmt->execute($attributes);
		// Check if execution failed
		$code = $stmt->errorCode();		
		if($code!='00000'){
			if($code == '23000'){
				return array('status'=>'error', 'result'=>'sql_query_doublon');
			}					
			return array('status'=>'error', 'result'=>'sql_query_failed');
		}
		// Get result if so
		$result = $stmt->fetchAll();		
		return array('status'=>'success', 'result'=>$result);
	}
}