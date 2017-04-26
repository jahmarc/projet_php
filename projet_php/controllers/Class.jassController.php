<?php
class jassController extends Controller{
	/**
	 * Method called by the form of the page login.php
	 */
	
	function testGC(){
		
		// --- Début test Giuseppe
		$this->vars['msg'] = "OK c'est bien";
		
		//		$this->redirect('jass', 'testGC');
		//	$this->redirect('jass', 'testGC');
		//		jassController::echoPartsPending();
		//		jassController::echoColorsCards();
		/*
		 $packOfCards = range(1,36);
		 shuffle($packOfCards);
		 $cards = Card::get36Cards();
		 foreach ($packOfCards as $value){
		 echo $cards[$value]->toString()."<br>";
		 }
		 */
		$idPart = Part::newPart(1, "Partie ".time());
		if($idPart<1) exit();
		$currentPart1 = Part::getPartByIdPart($idPart);
		
		$currentPart2 = Part::getPartByIdPart($idPart);
		$currentPart2->addUserInPart(2);
		
		$currentPart3 = Part::getPartByIdPart($idPart);
		$currentPart3->addUserInPart(3);
		
		$currentPart4 = Part::getPartByIdPart($idPart);
		$currentPart4->addUserInPart(4);
		$donnes = Donne::getDonnesPart($idPart);
		foreach ($donnes as $donne){
			$hands = Hand::getHandsDonne($donne->getIdDonne());
			foreach ($hands as $hand){
				echo "<br> Joueur ".$hand->getNrPlayer()." : -> " ;
				for ($i = 1; $i <= 9; $i++) {
					echo $hand->getNrCards()[$i]."   ";
					
				}
			}
		}
		exit();
		
		
		// --- Fin test Giuseppe
		
		
	}
	
	public function echoColorsCards(){
		$colors = Color::get4Colors();
		foreach ($colors as $key => $value){
			echo $key.' : '.$value->toString()."<br>";
		}
		$cards = Card::get36Cards();
		foreach ($cards as $key => $value){
			echo $key.$value->toString()."<br>";
		}
	}
	function echoPartsPending(){
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		$strPparts = Part::getPartsPendingToStart($idUser);
		foreach ($strPparts as $value){
			echo $value[0].' - '.$value[1].' - '.$value[2].' - '.$value[3]."<br>";
		}
		
	}
	function newPart(){
		
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		echo $idUser."<br>";
		$idPart = 0;
		$idPart = Part::newPart($idUser,"Ma partie GC");
		if ($idPart>0){
			echo "Nouvelle partie creee nr ".$idPart."<br>";
		}
		$players = Player::getPlayersPart($idPart);
		if (isset($players)){
			foreach ($players as $key => $value){
				echo $value->getIdPart().', idUser='.$value->getIdUser().', nrPlayer='.$value->getNrPlayer()."<br>";
				
			}
		}
		$part = Part::getPartByIdPart($idPart);
		
		echo "Part::getPartByIdPart() =  ".$part->getIdPart().', designation='.$part->getDesignation().', count(Players)='.count($part->getPlayers())."<br>";
		
		exit;
		
	}
	
}