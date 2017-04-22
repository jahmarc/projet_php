<?php
class jassController extends Controller{
	/**
	 * Method called by the form of the page login.php
	 */
	function testGC(){
		
		// --- D�but test Giuseppe
		$this->vars['msg'] = "OK c'est bien";
		// --- Fin test Giuseppe
		
		
	}
	function echoColorsCards(){
		$colors = Color::get4Colors();
		foreach ($colors as $key => $value){
			echo $value->toString()."<br>";
		}
		$cards = Card::get36Cards();
		foreach ($cards as $key => $value){
			echo $value->toString()."<br>";
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