<?php
class gameController extends Controller{
	private $idUser = null;	// int
	private $part = null;	// new Part()
	private $currentDonne = null;	// new Donne()
	private $currentPli = null;	// new Pli()
	private $currentAsset = 0;
	//Joueur en cours (en attente de jouer)
	private $currentPlayer = 0;
	// dernière modification
	private $lastModification;
	
	private $currentPointsPart = 0;
	// Qui a choisi l'atoût
	
	
	//le n° de joueur de l'user
	private $myNrPlayer = 0;
	//le n° de joueur de gauche relatif à l'user
	private $left = 0;
	//le n° de joueur en front relatif à l'user
	private $front = 0;
	//le n° de joueur de droit relatif à l'user
	private $right = 0;
	
	// les cartes du joueur de l'user (int[])
	private $myCards = null;//array (1 => 0); // Index commencant a 1 avec array()
	
	/**
	 * Test si user et partie valides
	 */
	private function gameIsValid(){
		// contrôle si user actif sinon return false
		if (!$this->getActiveUser()) return false;
		// si pas de idPart en cours return false
		if(empty($_SESSION['idPart'])) return false;
		return true;
	}
	/**
	 * Method called by the form of the page :
	 *  listoftables.php	(liste des parti en attente)
	 *  mygames.php		(depuis mes parties... si pas terminée, en cours)
	 *  newparty.php	(lors de la création d'une nouvelle partie)
	 */
	function game(){
		if (!$this->gameIsValid()) {
			$this->redirect ( 'login', 'login' );
			exit ();
		}
		
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
		
		//		$currentPart = $this->getCurrentPart();
		$this->vars['msg'] = 'Current game';
		$this->vars['designation'] =$this->getCurrentPart()->getDesignation();
		$this->vars['atout'] = $this->getCurrentAsset();
		
		if($this->currentDonne==null){
			$this->vars['chibre']=0;
		}
		else{
		$this->vars['chibre'] = $this->getCurrentDonne()->getChibre();
		}
		$this->vars['currentPlayer'] = $this->getCurrentPlayer();
		$this->vars['myCards'] = $this->getMyCards();
		$this->vars['chat'] = $this->GetChat($idPart);
		
		//annonces et stock
		$this->vars['annonce']='';
		$this->vars['stock']='';
		
		// cherche les joueurs pour la vue
		$this->setPlayersForView();
		// cherche les cartes sur la table pour la vue
		$this->setCardsInTableForView();
		// cherche les cartes sur la table pour la vue
		$this->setPointsForView();
		
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
			$this->GetChat($idPart);
			//affiche et check les annonces
			$this->checkannonces();
			if ($this->currentAsset == 0){
				// choisir l'atout
				
				if ($this->currentDonne->getChibre() == true){
					// il a chibre
					
				}
			}
		}
		

		
		// enregistrer la derniere modification
		$this->lastModification = $this->part->getModifOnAt();
	}
	/**
	 * refresh le game pour continuer après l'action utilisateur
	 */
	private function refreshGame_AfterInput(){
		$user = $_SESSION['user'];
		$_idPart= $_SESSION['idPart'];
		$_idUser = $user->getId();
		
		// on est obligé à lire à chaque fois?
		// sinon il marche pas?? les objets sont null ??
		$this->RefreshPart($_idPart, $_idUser);
		// si ce n'est le joueurs en cours à jouer
		if($this->getCurrentPlayer() != $this->getMyNrPlayer()){
			$this->redirect("game","game");
		}
	}
	/**
	 * enregistrer la carte joué par le joueur
	 */
	public function setCard_InPli(){
		// refresh le game
		$this->refreshGame_AfterInput();
		
		$nrCard= 0;
		foreach ( $_GET as $key => $value ) {
			$nrCard = $key;
		}
		
		// contrôle si erreur
		if (!$this->isValidCardForThisPli($nrCard)){
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
		
		// GC: relir la pli et la setter dans l'objet $this
		$this->setCurrentPli();
		
		// gestion de la fin de la pli
		$this->manageEndPli();
		
		// reafficher le game
		$this->redirect("game","game");
	}
	
	/**
	 * enregistrer la couleur d'atout choisie par le joueur
	 */
	public function setColorAsset_InDonne(){
		$this->refreshGame_AfterInput();
		
		$nrColor= 0;
		foreach ( $_GET as $key => $value ) {
			$nrColor = $key;
		}
		
		// contrôle si erreur
		if ($nrColor < 1 || $nrColor > 4){
			$this->redirect("game","game");
			exit;
		}
		
		// lire la pli en cours
		$this->getCurrentDonne()->setAsset($nrColor);
		$this->getCurrentDonne()->save();
		
		// TODO METTRE LES ANNONNCES ICI
		// reafficher le game
		$this->redirect("game","game");
	}
	/**
	 * enregistrer le state CHIBRE de la couleur d'atout
	 */
	public function setChibreAsset_InDonne(){
		// refresh le game
		$this->refreshGame_AfterInput();
		
		$this->getCurrentDonne()->setChibre(true);
		$this->getCurrentDonne()->save();
		
		// reafficher le game
		$this->redirect("game","game");
	}
	
	
	/**
	 * get les points pour la vue
	 * $this->vars['pointsGame'] et  pointsDonne, pointsLastPli
	 */
	private function setPointsForView(){
		// met à vide les points
		$this->vars['pointsGame'] = array(1 => 0,0);
		$this->vars['pointsDonne'] = array(1 => 0,0);
		$this->vars['pointsLastPli'] = array(1 => 0,0);
		
		$donne = $this->getCurrentDonne();
		if ($donne == null) return;
		
		$this->vars['pointsGame'] = $this->getCurrentPart()->getTotalPoints();
		$this->vars['pointsDonne'] = $this->getCurrentDonne()->getTotalPoints();
		
		$plis = Pli::getPlisDonne($this->getCurrentDonne()->getIdDonne());
		if(empty($plis)) return;
		$count = count($plis);
		if($count<2) return;
		// pli précedente
		$playerWinner = $plis[$count-1]->getWinner();
		if(empty($playerWinner)) return;
		$points = $plis[$count-1]->getResult();
		$arrPoints = array(1 => 0,0);
		$team = Player::getNrTeamByNrPlayer($playerWinner);
		$arrPoints[] = $points;
		// set lea points de la dernier pli pour la view
		$this->vars['pointsLastPli'] = $arrPoints;
		
	}
	
	/**
	 * calcul et set les joueurs pour la vue
	 * $this->vars['myPlayer'] et  playerRight, playerFront, playerLeft
	 */
	
	private function setPlayersForView(){
		// met à vide les joueurs
		$this->vars['myPlayer'] = null;
		$this->vars['playerRight'] = null;
		$this->vars['playerFront'] = null;
		$this->vars['playerLeft'] = null;
		
		$players = $this->part->getPlayers();
		foreach ($players as $player) {
			switch ($player->getNrPlayer()){
				case $this->myNrPlayer:
					$this->vars['myPlayer'] = $player;
					break;
				case $this->right :
					$this->vars['playerRight'] = $player;
					break;
				case $this->front :
					$this->vars['playerFront'] = $player;
					break;
				case $this->left :
					$this->vars['playerLeft'] = $player;
					break;
			}
		}
		
	}
	/**
	 * calcul et set les cartes déjà joués aur la table pour la vue
	 * $this->vars['cardMyPlayer'] et  cardRight, cardFront, cardLeft
	 */
	
	private function setCardsInTableForView(){
		// met à vide les cartes
		$this->vars['cardMyPlayer'] = 0;
		$this->vars['cardRight'] = 0;
		$this->vars['cardFront'] = 0;
		$this->vars['cardLeft'] = 0;
		
		// set lea cartes sur la table
		if(!empty($this->currentPli)){
			$cardsInTable = $this->currentPli->getNrCards();
			
			$this->vars['cardMyPlayer'] = $cardsInTable[$this->myNrPlayer];
			$this->vars['cardRight'] = $cardsInTable[$this->right];
			$this->vars['cardFront'] = $cardsInTable[$this->front];
			$this->vars['cardLeft'] = $cardsInTable[$this->left];
			
		}
		
	}
	
	/**
	 * set le nr des joueurs right, front, left relativement à mon joueur
	 */
	private function setNrPlayersRelatedToMe(){
		
		$this->right = $this->myNrPlayer + 1;
		if($this->right > 4) $this->right -= 4;
		
		$this->front = $this->myNrPlayer + 2;
		if($this->front > 4) $this->front -= 4;
		
		$this->left = $this->myNrPlayer + 3;
		if($this->left > 4) $this->left -= 4;
		
	}

	/**
	 * test si la carte peut être posé sur la table
	 */
	private function isValidCardForThisPli($nrCard){
		// si n° carte invalide
		if($nrCard<1 || $nrCard>36)	return false;
		// test si premier à jouer
		
		// test la couleur, si atout ok
		$atout = $this->getCurrentAsset();
		$cardsOfGame = Card::get36Cards();
		
		$myCard = $cardsOfGame[$nrCard];
		if($myCard->getNdxColor() == $atout) return true;
		// lire la pli
		$pli = $this->getCurrentPli();
		$firstPlayer = $pli->getFirstPlayer();
		// je suis le premier à jouer, ok
		if ($firstPlayer==$this->myNrPlayer) return true;
		// contrôler la 1ère carte
		$nrFirstCard = $pli->getNrCards()[$firstPlayer];
		// premier à jouer?? ok
		if ($nrFirstCard== 0) return true;
		$firstCard = $cardsOfGame[$nrFirstCard];
		// si c'est la même couleur que la première carte ok
		if($firstCard->getNdxColor() == $myCard->getNdxColor()){
			return true;
		}else{
			// tester si dans les mains j'ai la même couleur que la 1ère
			$myCardsInHand = $this->getMyCards();
			foreach ($myCardsInHand as $myCard_InHand){
				if ($cardsOfGame[$myCard_InHand]->getNdxColor() == $firstCard->getNdxColor()) return false;
			}
		}
		return true;
	}
	/**
	 * Gestion de fin du pli
	 */
	private function manageEndPli(){
		if ($this->isTheEndOfPli() == false){
			return;
		}
		$idDonne = $this->getCurrentDonne()->getIdDonne();
		// gestion des points
		if($this->calculatePointsAndWinner() == false){
			echo " Erreur lors de Pli->save() dans manageEndPli";
			exit;
		}
		// Gestion de la nouvelle pli
		// le gagnant de la dernière pli est le premier joueur de la pli suivant
		$firstPlayer = $this->getCurrentPli()->getWinner();
		// si c'est la 9ème pli c'est une nouvelle donne
		if ($this->getCurrentPli()->getNrPli() == 9){
			$this->manageEndDonne();
			return;
		}else{
			Pli::newPli($idDonne, $firstPlayer);
		}
			
	}
	/**
	 * calculatePointsAndWinner : set le $result et le $winner pour le pli joué
	 */
	public function calculatePointsAndWinner(){
		$cardsOfGame = Card::get36Cards();
		$atout = $this->getCurrentAsset();
		$nrCards = $this->getCurrentPli()->getNrCards();
		$player_First =  $this->getCurrentPli()->getFirstPlayer();
		$color_First = $cardsOfGame[($nrCards[$player_First])]->getNdxColor();
		
		$tmpWinner = 0;
		$tmpPoints = 0;
		$tmpValue = 0;
		$tmpValueMAX = 0;
		for ($i = 0; $i < 4; $i++) {
			//  n° joueur à tester (relatif au premier joueur de la pli: firstPlayer)
			$tmpPlayer = $player_First + $i; 
			if($tmpPlayer > 4) $tmpPlayer -= 4;
			// n° de carte du joueur à tester
			$tmpNrCard = $nrCards[$tmpPlayer];
			// carte du joueur à tester
			$tmpCard = $cardsOfGame[$tmpNrCard];
			// valeur de la carte du joueur à tester
			$tmpValue = $tmpCard->getValueForEndPli($atout,$color_First);
			// si la carte est plus forte
			if ($tmpValue > $tmpValueMAX){
				$tmpValueMAX = $tmpValue;
				$tmpWinner = $tmpPlayer;
			}
			$tmpPoints += $tmpCard->getPointsForEndPli($atout);
		}
		if ($this->getCurrentPli()->getNrPli() == 9){
			// si 9ème et dernier pli alors ajouter « cinq de der »
			$tmpPoints += 5;
		}
		// check si valeurs plausibles
		if ($tmpWinner<1 || $tmpWinner>4 || $tmpPoints==0) return false;
		// set les points dans le pli
		$this->getCurrentPli()->setResult($tmpPoints);
		// set le winner dans le pli
		$this->getCurrentPli()->setWinner($tmpWinner);

		// sauvegarde le pli et return si erreur 
		if(!$this->getCurrentPli()->save()) return false;

		// sauvegarde les points dans la donne
		$this->getCurrentDonne()->calculateAndSavePointsOfPlis();
		
		return true;
	}
	
	
	/**
	 * test si c'est la fin de la pli (4 cartes sur la table)
	 */
	
	private function isTheEndOfPli(){
		// lire la pli en cours
		$idPli= $this->getCurrentPli()->getIdPli();
		$pli = Pli::getPliByIdPli($idPli);
		
		// relire le tableau des cartes jouées
		for ($i = 1; $i <= 4; $i++) {
			if (empty($pli->getNrCards()[$i]))
				return false;
		}
		
		return true;
	}
	/**
	 * GC : gestion de la fin de la donne, lors de la 9ème pli
	 */
	private function manageEndDonne(){
		// ctrl si n'est pas 9ème pli: ne rien faire (mieux controler à nouveau)
		if ($this->getCurrentPli()->getNrPli() != 9) return;
		
		$idDonne = $this->getCurrentDonne()->getIdDonne();
		// GC gestion de la partie (update les points)
		// ctrl si fin partie, si 1000 points alors fin de la partie
 		// sauvegarde les points dans la part
		$this->getCurrentPart()->calculateAndSavePointsOfDonnes();
		if ($this->manageEndPart()){
			
			return;
		}else{
			// le gagnant de la dernière pli est le premier joueur de la pli suivant
			$idPart = $this->getCurrentPart()->getIdPart();
			Donne::newDonne($idPart, 0);
		}
	
	}
	/**
	 * GC : A FAIRE (TODO)
	 */
	private function manageEndPart(){
		// ??
		// si 1000 points alors fin de la partie
		// set state = 99
		// calcul et set les 2 winners dans players
		$totalPoiints = $this->getCurrentPart()->getTotalPoints();
		if($totalPoiints[1]<1000 && $totalPoiints[2]<1000) return false;
		// on a depassé les 1000 points: game over
		
		return false;
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
		// set le dernier pli du tableau
		$this->currentPli = $plis[$lastNDX];
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
		// calcul le numéro des joueurs de droit, gauche et en front
		$this->setNrPlayersRelatedToMe();
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
		if($this->getCurrentAsset() == 0){
			// atout pas encore choisi
			if($this->getCurrentDonne()->getChibre()){
				$nr += 2;
				if($nr > 4) $nr -= 4;
			}
			$this->currentPlayer = $nr;
			return ;
		}else{
			// atout déjà choisi
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
		return $this->myCards;
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
		// trier les cartes restantes dans l'ordre
		if(!empty($my_Cards_current)){
			sort($my_Cards_current);
			$this->myCards = $my_Cards_current;
		}
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
	public function GetChat($idPart) {
		return Chat::getChatsPart($idPart);
	}
	
	/**
	 * Va checker les annonces des joueurs et ramène un tableau des 4 annonces de chaque joueur
	 */
	public function checkannonces(){
		$_idDonne = $this->getCurrentDonne()->getIdDonne();
		$_nrPlayer = $this->getMyNrPlayer();
		$_asset = $this->getCurrentAsset();
		// Je vais chercher les 4 mains
		$hands = Hand::getHandsDonne($_idDonne);
		
		$cpt=0;
		$annonce = array(4);
		$stock = array(4);
		// pour chaque main, je vais chercher l'id de l'annonce obtenue
		foreach ( $hands as $hand ) {
			$annonce[$cpt]=Hand::checkAnnonces($hand);
			$stock[$cpt]=Hand::stockTest($hand, $_asset);
			//echo "</br>";
			$cpt++;
		}
		
		//Je vais parcourir les 4 id d'annonce  et je regarde qui a gagné
		$nrPlayer1=0;
		$nrPlayer2=0;
		$max = 0;
		for($i=0; $i<4; $i++){
			//echo $annonce[$i];
			//echo "</br>";
			if($annonce[$i]>$max)
			{
				$max = $annonce[$i];
				$nrPlayer1 = $i+1;
			}
			
			if($stock[$i]==true)
			{
				$nrPlayer2 = $i+1;
			}
		}
		
		//stockage de ce qui va être affiché + augmentation des scores pour les annonces
		if($nrPlayer1!=0){
			$team=Player::getNrTeamByNrPlayer($nrPlayer1);
			$a=Annonce::createAnnonces();
			$b=$a[$annonce[$nrPlayer1-1]];
			$pointannonce=$b->getPoints();
			$desc=$b->getDescription();
			$donne=$this->getCurrentDonne();
			$donne->setPointsAnnnonce($team, $pointannonce);
			$donne->save();
			//variable pour la vue
			$this->vars['annonce'] = 'La team num. '.$team.' a remporte ses annonces apres avoir crie '.$desc;
			//echo $this->vars['annonce'];
		}
		
		else{
			//variable pour la vue
			$this->vars['annonce'] = 'Aucune annonce a ete trouvee ! Dommage !';
		}
		
		//stockage de ce qui va être affiché + augmentation des scores pour le stock
		if($nrPlayer2!=0){
			$team2=Player::getNrTeamByNrPlayer($nrPlayer1);
			$pointstock=20;
			$donne=$this->getCurrentDonne();
			$donne->setPointsAnnnonce($team2, $pointstock);
			$donne->save();
			//variable pour la vue
			$this->vars['stock'] = 'La team num. '.$team.' a remporte le stock, 20 point de plus pour vous!';
		}
		
		else{
			//variable pour la vue
			$this->vars['stock'] = 'Aucun stock trouve ! Dommage !';
		}
		
		//if($this->flag=true)
		//{
		//echo 'OK';
		//}
		//else {
		//	echo '!!!!!!';
		//}
		//echo "</br>";
		
		
	}
	
	public function NewMessage(){
		//Get data posted by the form
		$message = $_POST['message'];
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		$idPart = $_SESSION['idPart'];
		//Check if data valid
		
		if(empty($message)){
			$_SESSION['msg'] = '<span class="error">A required field is empty!</span>';
			$_SESSION['persistence'] = array($message);
		}
		
		else{
			$idChat = Chat::newChat($idPart, $idUser, $message );
			if ($idChat < 1) {
				$_SESSION ['msg'] = '<span class="error">Unkown error!</span>';
				$_SESSION ['persistence'] = array (
						$message
				);
			} else {
				$_SESSION ['msg'] = '<span class="success">New message saved!</span>';
				unset ( $_SESSION ['persistence'] );
			}
			
			
		}
		$this->redirect('game', 'game');
	}
}