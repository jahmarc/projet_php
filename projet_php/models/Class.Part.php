<?php
class Part{
	private $idPart;
	private $players = array() ;
	private $result = 0;
	private $annonces = 0;
	private $stock = 0;
	private $state = -1;
	private $designation = '';
	private $createdBy = 0;
	private $createdOnAt;
	private $modifBy = 0;
	private $modifOnAt;
	
	public function __construct($idPart=null, $players, $result, $annonces){
		$this->setIdPart($idPart);
		$this->setPlayers($players);
		$this->setResult($result);
		$this->setAnnonces($annonces);
	}
	/**
	 * newPart : création d'une nouvelle partie
	 * @return idPart de la partie créée (ok) sinon -1 en cas d'erreur
	 */
	public static function newPart($idUser, $designation){
		
		// insert
		$query = "INSERT INTO part(designation, createdBy, modifBy)	VALUES(?, ?, ?);";
		$attributes = array($designation, $idUser, $idUser);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return -1;
		
		// last insert id
		$id = MySqlConn::getInstance()->last_Insert_Id();
		if($id < 1) return -1;
		return $id;
		
	}

	
	
	/**
	 * Getter and setter
	 */
	
	public function getIdPart(){
		return $this->idPart;
	}
	
	public function setIdPart($idPart){
		$this->idPart = $idPart;
	}
	
	public function getPlayers(){
		return $this->players;
	}
	
	public function setPlayers($players){
		$this->players = $players;
	}
	
	public function getResult(){
		return $this->result;
	}
	
	public function setResult($result){
		$this->result = $result;
	}
	
	public function getAnnonces(){
		return $this->annonces;
	}
	
	public function setAnnonces($annonces){
		$this->annonces = $annonces;
	}
}