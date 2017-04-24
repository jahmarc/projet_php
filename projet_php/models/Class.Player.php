<?php
class Player{
	private $idPart;
	private $idUser;
	private $nrPlayer;
	private $winner;
	
	public function __construct($idPart=null, $idUser, $nrPlayer, $winner){
		$this->setIdPart($idPart);
		$this->setIdUser($idUser);
		$this->setNrPlayer($nrPlayer);
		$this->setWinner($winner);
	}
	
	/**
	 * getPlayerByIDPartIDUser : recherche d'un player d'une partie de l'user
	 * @return objet player de la partie de l'user
	 */
	public static function getPlayerByIDPartIDUser($idPart,$idUser){
		// recherche tableau de players
		$players = getPlayersPart($idPart);
		if (!is_array($players)) return false;
		// boucler le tableu pour chercher et retourner l'user demandé
		foreach ($players as $key => $p){
			if($p->getIdUser()==$idUser)
				return $p;
		}
		
		return false;
	}
	
	/**
	 * getPlayerByIDPartIDUser : recherche d'un player d'une partie de l'user
	 * @return objet player de la partie de l'user
	 */
	public static function getPlayerByIDPartNrPlayer($idPart,$nrPlayer){
		// recherche tableau de players
		$players = getPlayersPart($idPart);
		if (!is_array($players)) return false;
		// boucler le tableu pour chercher et retourner l'user demandé
		foreach ($players as $key => $p){
			if($p->getNrPlayer()==$nrPlayer)
				return $p;
		}
		
		return false;
	}
	
	/**
	 * newPlayer : ajout d'un nouveau player à la partie, n° du joueur (1-4)
	 * @return boolean true/false
	 */
	public static function newPlayer($idPart, $idUser, $nrPlayer){
		// insert
		$query = "INSERT INTO player(IDPart, IdUser, nrPlayer, winner)	VALUES(?, ?, ?, ?);";
		$attributes = array($idPart, $idUser, $nrPlayer, 0);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		
		if($result['status']=='error') return false;
		
		return true;
		
	}
	/**
	 * getPlayersPart : recherche les players de la partie
	 * @return un tableau de players de la partie
	 */
	public static function getPlayersPart($idPart){
		// tableau de players à retourner
		$players = array();
		// query select
		$query = "SELECT IDPart, IdUser, nrPlayer, winner FROM player WHERE IDPart=? ORDER BY nrPlayer;";
		$attributes = array($idPart);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			//
			foreach ($result['result'] as $key => $res_player){
				$ndx = $res_player['nrPlayer'];
				$players[$ndx] = new Player($res_player['IDPart'], $res_player['IdUser'], $ndx, $res_player['winner']);
			}
			
			return $players;
			
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
	public function getIdUser(){
		return $this->idUser;
	}
	
	public function setIdUser($idUser){
		$this->idUser= $idUser;
	}
	
	public function getNrPlayer(){
		return $this->nrPlayer;
	}
	
	public function setNrPlayer($nrPlayer){
		$this->nrPlayer= $nrPlayer;
	}
	
	public function getWinner(){
		return $this->winner;
	}
	
	public function setWinner($winner){
		$this->winner = $winner;
	}
	
}