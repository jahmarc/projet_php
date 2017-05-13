<?php
class Game {
	private $part = null;
	private $idUser = null;
	private $currentDonne = null;
	private $currentPli = null;
	private $currentAsset = 0;
	//Joueur en cours (en attente de jouer)
	private $currentPlayer = 0;
	private $myCards = array (
			1 => 0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0 
	); // Index commencant a 1 avec array()
	private $lastModification;
	private $currentPointsPart = 0;
	// Qui a choisi l'atoût
	
	//le joueur de l'user
	private $myNrPlayer = 0;
	public function __construct($idPart, $idUser) {
		// même dans le constructeur lancer la même procédure RefreshPart
		$this->lastModification = - 1;
		$this->RefreshPart ( $idPart, $idUser );
	}
	
	/**
	 * Met à jour toutes les données nécessaires à la partie
	 */
	public function RefreshPart($idPart, $idUser) {
	
		// lire la partie
		$partTemp = Part::getPartByIdPart ( $idPart );
		// si la partie en cours n'est pas null
		if ($partTemp != null) {
			// si il n'y pas a une modification pour la même partie du même utilisateur alors ne rien faire
			if ($partTemp->getModifOnAt () == $this->lastModification && $this->idUser = $idUser)
				exit ();
		}
	
		// lire et calculer tous les membres de la classe
		$this->idUser = $idUser;
		$this->part = $partTemp;
		$this->setCurrentDonne ();
		$this->setCurrentPli ();
		$this->setCurrentAsset ();
		$this->setCurrentPlayer ();
	
		// enregistrer la derniere modification
		$this->lastModification = $this->part->getModifOnAt ();
	}
	
	/**
	 * Renvoi la donne en cours
	 */
	public function getCurrentDonne() {
		return $this->currentDonne;
	}
	
	/**
	 * Renvoi de la partie en cours
	 */
	public function getCurrentPart(){
		return $this->part;
	}
	
	/**
	 * Calcul et set la donne en cours
	 */
	private function setCurrentDonne() {
		$donnes = Donne::getDonnesPart ( $part->getIdPart () );
		$lastNDX = count ( $donnes );
		// return la derniere donne du tableau
		$this->currentDonne = $donnes [$lastNDX];
	}
	
	/**
	 * Renvoi le pli en cours
	 */
	public function getCurrentPli() {
		return $this->currentPli;
	}
	
	/**
	 * Calcul et set la pli en cours
	 */
	private function setCurrentPli() {
		$idDonne = $this->currentDonne->getIdDonne();
		$plis = Pli::getPlisDonne ( $idDonne );
		$lastNDX = count ( $plis );
		// return le dernier pli du tableau
		$this->currentPli = $plis [$lastNDX];
	}
	
	/**
	 * Renvoi l'atoût en cours
	 */
	public function getCurrentAsset() {
		return $this->currentAsset;
	}
	/**
	 * Calcul et set l'atoût en cours
	 */
	private function setCurrentAsset() {
		$this->currentAsset = $this->currentDonne->getAsset ();
	}
	
	/**
	 * Renvoi le joueur du user
	 */
	public function getMyNrPlayer() {
		return $this->myNrPlayer;
	}
	/**
	 * Calcul et set le joueur du user
	 */
	private function setMyNrPlayer() {
		$_idPart = $this->part->getIdPart;
		$_idUser = $this->$idUser;
		// cherche le player selon idPartie et idUser
		$player = Player::getPlayerByIDPartIDUser( $_idPart, $_idUser );
		// le numéro du joueur entre 1 et 4
		$this->myNrPlayer = $player.getNrPlayer;
	}
	
	/**
	 * Renvoi le joueur en cours
	 */
	public function getCurrentPlayer() {
		return $this->currentPlayer;
	}
	/**
	 * SP
	 * Calcul et set le joueur en cours 
	 */
	public function setCurrentPlayer() {
		$_idPart = $this->part->getIdPart;
		$_idUser = $this->$idUser;
		// cherche le player selon idPartie et idUser
		$player = Player::getPlayerByIDPartNrPlayer( $_idPart, $_idUser );
		// le numéro du joueur entre 1 et 4
		$this->currentPlayer = $player.getNrPlayer;
	}
	
	/**
	 * Renvoi les cartes qu'il vous reste à jouer
	 * public function getMyCards(){
	 */
	public function getMyCards() {
		return $this->$MyCards;
	}
	/**
	 * Calcul et set les cartes qu'il vous reste à jouer
	 */
	public function setMyCards() {
		$_idDonne = $this->getCurrentDonne ()->getIdDonne ();
		$_nrPlayer = $this->myPlayer;
		// mes cartes initiales
		$myCards = Hand::getHandPlayer ( $_idDonne, $_nrPlayer );
		// les plis avec les cartes déjà jouées
		$plis = Pli::getPlisDonne ( $_idDonne );
		// boucler les plis pour effacer les carte déjà jouées
		// CONTINUER
		
		$this->myCards = $myCards;
	}
	
	/**
	 * SP
	 * Renvoi les points de la partie en cours
	 */
	public function GetPointsPart() {
		return $this->$currentPointsPart ();
	}
	/**
	 * SP
	 * Set les points de la partie
	 */
	public function setPointsPart() {
		$_idPart = $this->part->getIdPart;
		$this->$currentPointsPart = $this->part->getCountResult($_idPart);	
	}
	
	/**
	 * SP
	 * Renvoi les points de la donne en cours
	 */
	public function GetPointsDonne() {
		return $this->$currentPointsDonne();
	}
	/**
	 * SP
	 * Set les points de la donne
	 */
	public function SetPointsDonne(){
		$_idDonne = $this->currentDonne->getIdDonne;
		$this->$currentPointsDonne = $this->currentDonne->getCountResult($_idDonne);
	}
	
	/**
	 * Renvoi les conversations de la partie en cours
	 */
	public function GetChat() {
	}
}