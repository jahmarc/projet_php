<?php
class Part{
	private $idPart;
	private $players = array() ;
	private $result = array(1 => 0,0);	// Index commençant à 1 avec array()
	private $annonces = array(1 => 0,0);	// Index commençant à 1 avec array()
	private $stock = array(1 => 0,0);	// Index commençant à 1 avec array()
	private $state = 0;
	private $designation = '';
	private $createdBy = 0;
	private $createdOnAt;
	private $modifBy = 0;
	private $modifOnAt;
	
	
	public function __construct($idPart, $players, $result, $annonces, $stock, $state, $designation
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
	 * getPartsPendingToStart : recherche la liste des parties existantes
	 * - en attente de joueurs (moins de 4) pour débuter la partie
	 * - l'utilisateur en cours ne doit pas être déjà inscrit (currentUser = 0)
	 * @return un array() avec une structure: int IdPart, string designation, int countPlayers, string libelléState
	 */
	public static function getPartsPendingToStart($idUser){
		// query select
		 		$query = "SELECT part.IDPart
		 				, part.designation
		 				, COUNT(player.IdUser) As countPlayers
		 				, SUM(IF(player.IdUser = ?,1,0)) As currentUser
		 				, part.state
		 				FROM part, player
		 				WHERE part.IDPart = player.IDPart AND part.state < 4
		 				GROUP BY player.IDPart, part.designation  HAVING currentUser = 0;";
		
		//$query = "SELECT part.IDPart, part.designation, part.state
		//		FROM part, player WHERE part.IDPart = player.IDPart AND part.state < 4 GROUP BY player.IDPart, part.designation;";
		
		
		
		
		
		$attributes = array($idUser);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			
			//
			$parts = array();
			foreach ($result['result'] as $key => $res_part){
				//$parts[$key] = array($res_part['IDPart'], $res_part['designation'], $res_part['countPlayers'], Part::getStaticLabelState($res_part['state']));
				
				/**Helena*/
				$parts[$key] = array($res_part['IDPart'], $res_part['designation'], Part::getStaticLabelState($res_part['state']));
				
				
			}
			
			return $parts;
	}
	
	/**
	 * getPartsOfUser : recherche la liste des parties de l'user
	 * - en attente de joueurs (moins de 4) pour débuter la partie
	 * - l'utilisateur en cours ne doit pas être déjà inscrit (currentUser = 0)
	 * @return un array() avec une structure: int IdPart, string designation, int state, string libelléState, string modifBy, string modifOnAt, Boolean winner
	 */
	public static function getPartsOfUser($idUser){
		// query select
		$query = "SELECT part.IDPart
				, part.designation
				, part.state
				, part.modifBy
				, part.modifOnAt
				, player.winner
				FROM part, player
				WHERE part.IDPart = player.IDPart AND player.IdUser = ?
				ORDER BY part.modifOnAt;";
		$attributes = array($idUser);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			
			//
			$parts = array();
			foreach ($result['result'] as $key => $res_part){
				$parts[$key] = array($res_part['IDPart']
						, $res_part['designation']
						, $res_part['state']
						, Part::getStaticLabelState($res_part['state'])
						, $res_part['modifBy']
						, $res_part['modifOnAt']
						, $res_part['winner']
				);
			}
			
			return $parts;
	}
	
	/**
	 * HELENA
	 *
	 * ADD USER IN PART
	 */
	public static function addUserToPart($idPart){
		
		
	}
	
	
	
	
	
	/**
	 * addUserInPart : ajouter un User à la partie (et un nouveau player)
	 * @return boolean true/false
	 */
	public function addUserInPart($idUser){
		// calcul nombre de joueur
		$nbPlayers = Part::getCountPlayersAfterRefresh();
		// max 4 joueurs
		if($nbPlayers == 4) return false;
		foreach ($this->players as $player) {
			// Si user déjà dans la partie ne pas l'ajouter
			if ($player->getIdUser() == $idUser) return false;
		}
		// ajouter le nouve player
		$nb = $nbPlayers + 1;
		if(Player::newPlayer($this->idPart, $idUser, $nb) == false) return false;
		$this->checkUpdateState($idUser);
		
		return true;
	}
	/**
	 * PRIVE checkUpdateState : contrôle l'état de la partie et éventuellement le change
	 * @return boolean true/false
	 */
	private function checkUpdateState($idUser){
		// Si partie terminée: ne rien faire
		if($this->state == 99) return
		$nbPlayers = 0;
		// calcul nombre de joueur
		$nbPlayers = $this->getCountPlayersAfterRefresh();
		
		// si nombre de joueur n'a pas changé ne rien faire
		if($nbPlayers == $this->state) return ;
		
		// modifie l'état de l'objet partie en cours
		$this->setState($nbPlayers);
		
		// save objet en cours
		$this->save($idUser);
		
		// si 4 joueurs on demarre la partie
		if($nbPlayers == 4){
			/* créer une donne:
			 * newDonne() doit :
			 * 1. créer 4 hands
			 * 2. créer 1 pli à vide
			 * ---newPli doit
			 * ------setter le premier
			 * ------si première pli : (7 carreaux)
			 * ------sinon dernier joueur de la pli precedente
			 */
			
			$donne = Donne::newDonne($this->getIdPart());
		};
		
	}
	
	
	
	
	
	/**
	 * save : sauve (update) de l'objet en cours
	 * @return boolean true/false
	 */
	private function save($idUser){
		// UPDATE (jamais modifier IdPart, createBy, createOnAt)
		$query = "UPDATE part SET
					  designation = ?
					, pointsResult_1 = ?
					, pointsResult_2 = ?
					, annonces_1 = ?
					, annonces_2 = ?
					, stock_1 = ?
					, stock_2 = ?
					, state = ?
					, modifBy = ?
					, modifOnAt = now()
					 WHERE IDPart = ?;";
		$attributes = array(
				$this->getDesignation()
				, $this->getResult()[1]
				, $this->getResult()[2]
				, $this->getAnnonces()[1]
				, $this->getAnnonces()[2]
				, $this->getStock()[1]
				, $this->getStock()[2]
				, $this->getState()
				, $idUser
				, $this->getIdPart()
		);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return false;
		
		return true;
	}
	/**
	 * getCountPlayersAfterRefresh : Nombre de joueur de la partie
	 * @return le nombre de joueur de la partie en cours après avoir cherché dans la BDD
	 */
	public function getCountPlayersAfterRefresh(){
		// with refresh players
		$this->setPlayers(Player::getPlayersPart($this->idPart));
		return count($this->players);
	}
	/**
	 * getCountPlayers : Nombre de joueur de la partie
	 * @return le nombre de joueur de la partie en cours sans aller cherche dans la BDD
	 */
	public function getCountPlayers(){
		// without refresh players
		return count($this->players);
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
					 WHERE IDPart = ? ;";
		$attributes = array($idPart);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result'])){
			return false;
		}
		// recherche le tableau de players
		$players = Player::getPlayersPart($idPart);
		
		$res_part = $result['result'][0];
		
		$part = new Part($res_part['IDPart']
				, $players
				, array(1 => $res_part['pointsResult_1'], $res_part['pointsResult_2'])
				, array(1 => $res_part['annonces_1'], $res_part['annonces_2'])
				, array(1 => $res_part['stock_1'], $res_part['stock_2'])
				, $res_part['state']
				, $res_part['designation']
				, $res_part['createdBy']
				, $res_part['createdOnAt']
				, $res_part['modifBy']
				, $res_part['modifOnAt']);
		
		return $part;
	}
	
	/**
	 * getLabelState <STATIC>: recherche le libellé de l'état de la partie passée ne paramètre
	 * @return une string  libellé
	 */
	public static function getStaticLabelState($state){
		switch ($state){
			case 1; return "Waiting 3 players for starting";
			case 2; return "Waiting 2 players for starting";
			case 3; return "Waiting 1 player for starting";
			case 4; return "Part in progress";
			case 99; return "Part terminated";
		}
		
		return "Unknown state : ".$state;
	}
	/**
	 * getLabelState <objet en cours>: recherche le libellé de l'état de la partie objet en cours
	 * @return une string  libellé
	 */
	public function getLabelState(){
		return getStaticLabelState($this->state);
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
		$this->createdOnAt= $createdOnAt;
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
		$this->modifOnAt = $modifOnAt;
	}
	
	
	
}