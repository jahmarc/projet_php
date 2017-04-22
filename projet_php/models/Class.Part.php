<?php
class Part{
	private $idPart;
	private $players = array() ;
	private $result = array(null,0,0);
	private $annonces = array(null,0,0);
	private $stock = array(null,0,0);
	private $state = -1;
	private $designation = '';
	private $createdBy = 0;
	private $createdOnAt;
	private $modifBy = 0;
	private $modifOnAt;
	
	public function __construct($idPart=null, $players, $result, $annonces, $stock, $state, $designation
			, $createdBy, $createdOnAt, $modifBy, $modifOnAt){
				$this->setIdPart($idPart);
				$this->setPlayers($players);
				$this->setResult($result);
				$this->setAnnonces($annonces);
				$this->setStock($stock);
				$this->setState($state);
				$this->setDesignation($designation);
				$this->setCreatedBy($createdBy);
				$this->setCreatedOnAt($createdOnAt);
				$this->setModifby($modifBy);
				$this->setModifOnAt($modifOnAt);
	}
	/**
	 * joinPartUser : ajouter un User à la partie (et un nouveau player)
	 * @return boolean true/false
	 */
	public function joinUserInPart($idUser){
		// a tester
		// refresh players
		$this->players = Player::getPlayersPart($this->idPart);
		$nbPlayers = count($this->players);
		// max 4 joueurs
		if($nbPlayers == 4) return false;
		foreach ($this->players as $player) {
			// Si user déjà dans la partie ne pas l'ajouter
			if ($player->getIdUser() == $idUser) return false;
		}
		
		$nb = $nbPlayers + 1;
		if(Player::newPlayer($this->idPart, $idUser, $nb)==false) return false;
		
		// refresh players
		$this->players = Player::getPlayersPart($this->idPart);		
	}
	/**
	 * newPart : création d'une nouvelle partie (et un nouveau player)
	 * @return idPart de la partie créée (ok) sinon -1 en cas d'erreur
	 */
	public static function newPart($idUser, $designation){
		
		// insert
		$query = "INSERT INTO part(designation, createdBy, modifBy, state)	VALUES(?, ?, ?, ?);";
		$attributes = array($designation, $idUser, $idUser, 1);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return -1;
		
		// last insert id
		$idPart= MySqlConn::getInstance()->last_Insert_Id();
		if($idPart< 1) return -1;
		
		// ajouter l'user comme 1er player
		if(Player::newPlayer($idPart, $idUser, 1) == false) return -1;
		
		return $idPart;
		
	}
	
	/**
	 * getPartByIdPart : recherche et remplissage d'une Partie (et Players liés)
	 * @return un objet Part avec id passé en param
	 */
	public static function getPartByIdPart($idPart){
		// query select
		$query = "SELECT IDPart
					 , designation
					 , pointsResult_1
					 , pointsResult_2
					 , annonces_1
					 , annonces_2
					 , stock_1
					 , stock_2
					 , state
					 , createdBy
					 , createdOnAt
					 , modifBy
					 , modifOnAt
					 FROM part
					 WHERE IDPart = ?;";
		$attributes = array($idPart);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			
			// recherche le tableau de players
			$players = Player::getPlayersPart($idPart);
			
			$res_part = $result['result'][0];
			$part = new Part($res_part['IDPart']
					, $players
					, array(null, $res_part['pointsResult_1'], $res_part['pointsResult_2'])
					, array(null, $res_part['annonces_1'], $res_part['annonces_2'])
					, array(null, $res_part['stock_1'], $res_part['stock_2'])
					, $res_part['state']
					, $res_part['designation']
					, $res_part['createdBy']
					, $res_part['createdOnAt']
					, $res_part['modifBy']
					, $res_part['modifOnAt']);
			
			return $part;
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
	
	public function getStock(){
		return $this->stock;
	}
	public function setStock($stock){
		$this->stock= $stock;
	}
	
	public function getState(){
		return $this->state;
	}
	public function setState($state){
		$this->state= $state;
	}
	
	public function getDesignation(){
		return $this->designation;
	}
	public function setDesignation($designation){
		$this->designation= $designation;
	}
	
	public function getCreatedBy(){
		return $this->createdBy;
	}
	public function setCreatedBy($createdBy){
		$this->createdBy= $createdBy;
	}
	
	public function getCreatedOnAt(){
		return $this->createdOnAt;
	}
	public function setCreatedOnAt($createdOnAt){
		$this->state= $createdOnAt;
	}
	
	public function getModifBy(){
		return $this->modifBy;
	}
	public function setModifBy($modifBy){
		$this->modifBy= $modifBy;
	}
	
	public function getModifOnAt(){
		return $this->modifOnAt;
	}
	public function setModifOnAt($modifOnAt){
		$this->modifOnAt= $modifOnAt;
	}
	
	
	
}