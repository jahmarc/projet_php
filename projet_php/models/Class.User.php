<?php
class User{
	private $id;
	private $firstname;
	private $lastname;
	private $username;
	private $password;
	
	public function __construct($id=null, $firstname, $lastname, $username, $password){
		$this->setId($id);
		$this->setFirstname($firstname);
		$this->setLastname($lastname);
		$this->setUsername($username);
		$this->setPassword($password);
	}	
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getFirstname(){
		return $this->firstname;
	}
	
	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}
	
	public function getLastname(){
		return $this->lastname;
	}
	
	public function setLastname($lastname){
		$this->lastname = $lastname;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	public function save(){
		$pwd = sha1($this->password);
		$query = "INSERT INTO user(firstname, lastname, username, password)	VALUES(?, ?, ?, ?);";
		$attributes = array($this->firstname, $this->lastname, $this->username, $pwd);	
		
		return  MySqlConn::getInstance()->execute($query, $attributes);
	}
	
	public static function connect($uname, $pwd){
		$pwd = sha1($pwd); //simple encryption. Use sha512 with Salt for better password encryption
		$query = "SELECT * FROM user WHERE username=? AND password=?";
		$attributes = array($uname, $pwd);				
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
		
		$user = $result['result'][0];
		return new User($user['id'], $user['firstname'], $user['lastname'],
				$user['username'], $user['password']);
	}
	
}