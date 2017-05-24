<?php
class gameController extends Controller{
	private $part = null;
	private $idUser = null;
	private $currentDonne = null;
	private $currentPli = null;
	private $currentAsset = 0;
	//Joueur en cours (en attente de jouer)
	private $currentPlayer = 0;
	// dernière modification
	private $lastModification;
	
	private $currentPointsPart = 0;
	// Qui a choisi l'atoût
	
	//le joueur de l'user
	private $myNrPlayer = 0;
	// les cartes du joueur de l'user
	private $myCards = array (1 => 0); // Index commencant a 1 avec array()
	
	/**
	 * Method called by the form of the page :
	 *  listoftables.php	(liste des parti en attente)
	 *  mygames.php		(depuis mes parties... si pas terminée, en cours)
	 *  newparty.php	(lors de la création d'une nouvelle partie)
	 */
	function game(){
		$user = $_SESSION['user'];
		$idPart = $_SESSION['idPart'];
		
		$idUser = $user->getId();
		
		//-----------------------------------------------------------------
		// RefreshPart : interroge les models pour collecter toutes les données nécessaires à la partie
		//-----------------------------------------------------------------
		$this->RefreshPart($idPart,$idUser);
		
		//-----------------------------------------------------------------
		// PBO: Before Output: pour passer des donnés à la vue:
		//-----------------------------------------------------------------
		
		$currentPart = $this->getCurrentPart();
		$this->vars['msg'] = 'Current game';
		$this->vars['designation'] ='Current game : '.$currentPart->getDesignation();
		$this->vars['atout'] = $this->currentAsset;
		$this->vars['currentPlayer'] = $this->currentPlayer;
		$this->vars['myCards'] = $this->myCards;
		
		// cherche les joueurs
		$this->setPlayersForView();
	}
	
	/**
	 * Met à jour toutes les données nécessaires à la partie
	 */
	public function RefreshPart($idPart, $idUser) {
		
		// lire la partie
		$partTemp = Part::getPartByIdPart ( $idPart );
		// si la partie en cours n'est pas null
		// 		if ($partTemp != null) {
		// 			// si il n'y pas a une modification pour la même partie du même utilisateur alors ne rien faire
		// 			if ($partTemp->getModifOnAt () == $this->lastModification && $this->idUser = $idUser)
		// 				exit ();
		// 		}
		// lire et calculer tous les membres de la classe
		$this->idUser = $idUser;
		$this->part = $partTemp;
		$this->part = Part::getPartByIdPart ( $idPart );
		$this->setMyNrPlayer();
		$state = $this->part->getState();
		if($state < 4){
			// partie en attente de joueurs
			
		}elseif($state == 99){
			// partie terminee
			
		}else{
			// partie en cours
			$this->setCurrentDonne();
			$this->setMyCards();
			$this->setCurrentPli();
			$this->setCurrentAsset();
			$this->setCurrentPlayer();
			
			if ($this->currentAsset == 0){
				// choisir l'atout
				
				if ($this->currentDonne->getChibre()== true){
					// il a chibre
					
				}
			}
		}
		
		// enregistrer la derniere modification
		$this->lastModification = $this->part->getModifOnAt();
	}
	/**
	 * calcul et set les joueurs pour la vue
	 * $this->vars['myPlayer'] et  playerRight, playerFront, playerLeft
	 */
	
	public function setPlayersForView(){
		// met à vide
		$this->vars['myPlayer'] = "";
		$this->vars['playerRight'] = "";
		$this->vars['playerFront'] = "";
		$this->vars['playerLeft'] = "";
		// calcul l'index relatif à my player
		$right = $this->myNrPlayer + 1;
		if($right > 4) $right -= 4;
		
		$front = $this->myNrPlayer + 2;
		if($front > 4) $front -= 4;
		
		$left = $this->myNrPlayer + 3;
		if($left > 4) $left -= 4;
		
		$players = $this->part->getPlayers();
		foreach ($players as $player) {
			switch ($player->getNrPlayer()){
				case $this->myNrPlayer:
					$this->vars['myPlayer'] = $player;
					break;
				case $right :
					$this->vars['playerRight'] = $player;
					break;
				case $front :
					$this->vars['playerFront'] = $player;
					break;
				case $left :
					$this->vars['playerLeft'] = $player;
					break;
			}
		}
		
	}
	
	/**
	 * enregistrer la carte joué par le joueur
	 */
	public function setCard_InPli(){
		$user = $_SESSION['user'];
		$_idPart= $_SESSION['idPart'];
		$_idUser = $user->getId();
		
		// on est obligé à lire à chaque fois?
		// sinon il marche pas?? les objets sont null ??
		$this->RefreshPart($_idPart, $_idUser);
		// si ce n'est le joueurs en cours à jouer
		if($this->getCurrentPlayer() != $this->getMyNrPlayer()){
			$this->redirect("game","game");
			exit;
		}
		
		$nrCard= 0;
		foreach ( $_GET as $key => $value ) {
			$nrCard = $key;
		}
		
		// contrôle si erreur
		if($nrCard<1 || $nrCard>36){
			$this->redirect("game","game");
			exit;
		}
		
		// lire la pli en cours
		$idPli= $this->getCurrentPli()->getIdPli();
		$pli = Pli::getPliByIdPli($idPli);
		
		// lire le numéro du joueur qui a jeté la carte
		$nrPlayer = $this->getMyNrPlayer();
		
		// relire le tableau des cartes jouées
		for ($i = 1; $i <= 4; $i++) {
			$myarr[$i] = $pli->getNrCards()[$i];
		}
		$pli->setNrCards($myarr);
		
		$pli->setCardInArray($nrPlayer, $nrCard);
		$pli->save();
		$this->redirect("game","game");
	}
	/**
	 * Renvoi le n° d'equipe selon le joueur $nrPlayer
	 * return 1 pour player 1 ou 3
	 * return 2 pour player 2 ou 4
	 */
	public function getNrTeamByNrPlayer($nrPlayer) {
		return (($nrPlayer-1) % 2) + 1;
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
		$donnes = Donne::getDonnesPart ( $this->part->getIdPart() );
		$lastNDX = count ( $donnes ) ;
		$donne = $donnes[$lastNDX];
		
		// return la derniere donne du tableau
		$this->currentDonne = $donnes[$lastNDX];
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
		$this->currentAsset = $this->currentDonne->getAsset();
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
		$_idPart = $this->part->getIdPart();
		$_idUser = $this->idUser;
		// cherche le player selon idPartie et idUser
		$player = Player::getPlayerByIDPartIDUser( $_idPart, $_idUser );
		// le numéro du joueur entre 1 et 4
		$this->myNrPlayer = $player->getNrPlayer();
	}
	
	/**
	 * Renvoi le joueur en cours
	 */
	public function getCurrentPlayer() {
		return $this->currentPlayer;
	}
	/**
	 * Calcul et set le joueur en cours
	 */
	private function setCurrentPlayer() {
		// chercher le joueur en cours (qui doit jouer)
		// selon Pli.firstPlayer
		// selon les cartes joué dans la pli
		$pli = $this->getCurrentPli();
		// les carte jouées dans la pli
		$cards = $pli->getNrCards();
		
		//le numéro du 1er joueur de la pli
		$nr = $pli->getFirstPlayer();
		
		for ($i = 1; $i <= 4; $i++) {
			if ($cards[$nr] == 0){
				// s'il n'a pas joué, c'est à lui
				$this->currentPlayer = $nr;
				return ;
			}else{
				// sinon on teste le prochain player
				$nr++; if($nr > 4) $nr = 1;
			}
		}
		// tous les 4 joueurs ont joué?
		// la pli est terminée
		$this->currentPlayer = 0;
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
		$_idDonne = $this->getCurrentDonne()->getIdDonne();
		$_nrPlayer = $this->myNrPlayer;
		// mes cartes initiales de la donne en cours
		$my_Cards = Hand::getHandPlayer( $_idDonne, $_nrPlayer )->getNrCards();
		// boucler les cartes pour effacer les carte déjà jouées
		foreach ( $my_Cards as $key => $nrCard) {
			// recehrche $nrCard dans les plis
			if ($this->cardAlreadyPlayed($nrCard)){
				//				echo $nrCard.'; key = '.$key.'; value = '.$value.'; ';
				$my_Cards[$key] = 0;
			}
		}
		// reconstruire un tableau
		foreach ( $my_Cards as $key => $value ) {
			if($value>0)
				$my_Cards_current[] = $my_Cards[$key];
		}
		
		$this->myCards = $my_Cards_current;
	}
	/**
	 * Renvoi true si la carte en params a été déjà jouée
	 */
	private function cardAlreadyPlayed($cardSearch){
		$_idDonne = $this->getCurrentDonne()->getIdDonne();
		// les plis avec les cartes déjà jouées
		$plis = Pli::getPlisDonne( $_idDonne );
		// pour chaque pli, recupère le tableau des cartes jouée
		foreach ( $plis as $pli ) {
			$arrayCard = $pli->getNrCards();
			foreach ( $arrayCard as $cardPlayed) {
				//			echo '<br/> cardPlayed = '.$cardPlayed.'; cardSearch = '.$cardSearch.'; ';
				if ($cardPlayed == $cardSearch)
					return true;
			}
		}
		
		return false;
	}
	/**
	 * SP
	 * Renvoi les points de la partie en cours
	 */
	public function GetPointsPart() {
		return $this->$currentPointsPart();
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
		$_idDonne = $this->currentDonne->getIdDonne();
		$this->$currentPointsDonne = $this->currentDonne->getCountResult($_idDonne);
	}
	
	/**
	 * Renvoi les conversations de la partie en cours
	 */
	public function GetChat() {
	}
	
	
}