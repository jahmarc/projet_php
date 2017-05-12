<?php
class Game{

	private $part = null;
	private $idUser = null;
	private $currentDonne = null;
	private $currentPli = null;
	private $currentAsset = 0;
	private $currentPlayer = 0;
	private $currentPlayerCards = array(1 => 0,0,0,0,0,0,0,0,0); // Index commencant a 1 avec array()
	private $lastModification;
	private $currentPointsPart = 0;
	//Qui a choisi l'ato�t
	//Get du nrPlayer
	
	public function __construct($idPart,$idUser){
		// m�me dans le constructeur lancer la m�me proc�dure RefreshPart
		$this->lastModification = -1;
		$this->RefreshPart($idPart, $idUser);
	}
	
	
	/**
	 * Renvoi la donne en cours
	 */
	public function  getCurrentDonne(){
		return $this->currentDonne;
	}
	
	/**
	 * Calcul et set la donne en cours
	 */
	private function  setCurrentDonne(){
		$donnes = Donne::getDonnesPart($part->getIdPart());
		$lastNDX = count($donnes);
		// return la derniere donne du tableau
		$this->currentDonne = $donnes[$lastNDX];
	}
	
	
	/**
	 * Renvoi le pli en cours
	 */
	public function  getCurrentPli(){
		return $this->currentPli;
	}
	
	/**
	 * Calcul et set la pli en cours
	 */
	private function setCurrentPli(){
		$idDonne = $this->currentDonne->getIdDonne();
		$plis = Pli::getPlisDonne($idDonne);
		$lastNDX = count($plis);
		// return le dernier pli du tableau
		$this->currentPli = $plis[$lastNDX];
	}
	
	
	/**
	 * Renvoi l'ato�t en cours
	 */
	public function getCurrentAsset(){
		return $this->currentAsset;
	}
	/**
	 * Calcul et set l'ato�t en cours
	 */
	private function setCurrentAsset(){
		$this->currentAsset = $this->currentDonne->getAsset();
	}
	
	
	/**
	 * Renvoi le joueur qui doit jouer
	 */
	public function getCurrentPlayer(){
		return $this->currentPlayer;
	}
	/**
	 * Calcul et set le joueur en cours
	 */
	private function setCurrentPlayer(){
		$_idPart = $this->part->getIdPart;
		$_idUser = $this->$idUser;
		// cherche le player selon idPartie et idUser
		$player = Player::getPlayerByIDPartIDUser($_idPart,$_idUser);
		// le num�ro du joueur entre 1 et 4		
		$this->currentPlayer = $player.getNrPlayer;
	}
	
	
	/**
	 * Renvoi les cartes qu'il vous reste � jouer
	 * public function  getMyCards(){
	 */
	public function  getCurrentPlayerCards(){
		return $this->$currentPlayerCards;
	}
	/**
	 * Calcul et set  les cartes qu'il vous reste � jouer
	 */
	public function  setCurrentPlayerCards(){
		$_idDonne = $this->getCurrentDonne()->getIdDonne();
		$_nrPlayer = $this->currentPlayer;
		// mes cartes initiales
		$myCards = Hand::getHandPlayer($_idDonne, $_nrPlayer);
		// les plis avec les cartes d�j� jou�es
		$plis = Pli::getPlisDonne($_idDonne);
		// boucler les plis pour effacer les carte d�j� jou�es
		//CONTINUER		
		$this->$currentPlayerCards = $myCards;
	}
	
	
	/**
	 * Renvoi les points de la partie en cours
	 */
	public function  GetPointsPart(){
		return $this->$currentPointsPart();
	}
	/**
	 * Set  les points de la partie
	 */
	public function setPointsPart(){
		$_idPart = $this->part->getIdPart;
		
	}
	
	
	
	/**
	 * Renvoi les points de la donne en cours
	 */
	public function  GetPointsDonne(){
	
	}
	
	
	/**
	 * Renvoi les conversations de la partie en cours
	 */
	public function  GetChat(){
	
	}
	
	
	/**
	 * Met � jour toutes les donn�es n�cessaires � la partie
	 * 
	 */
	public function  RefreshPart($idPart, $idUser){
		
		// lire la partie
		$partTemp = Part::getPartByIdPart($idPart);
		// si la partie en cours n'est pas null
		if ($partTemp != null){
			// si il n'y pas a une modification pour la m�me partie du m�me utilisateur alors ne rien faire
			if ($partTemp->getModifOnAt() == $this->ModifyOnAt && $this->idUser = $idUser)
				exit;
		}
		
		// lire et calculer tous les membres de la classe
		$this->idUser = $idUser;
		$this->part = $partTemp;
		$this->setCurrentDonne();
		$this->setCurrentPli();
		$this->setCurrentAsset();
		$this->setCurrentPlayer();
		
		
		
		// enregistrer la derniere modification
		$this->ModifyOnAt = $this->part->getModifOnAt();
	}
	
}