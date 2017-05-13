<?php
class gameController extends Controller{
	/**
	 * Method called by the form of the page login.php
	 */
	function game(){
		$this->vars['msg'] = 'Current game';
		$user = $_SESSION['user'];
		$idPart = $_SESSION['idPart'];
		
		$idUser = $user->getId();
		
		$currentGame = new Game($idPart,$idUser);
		
		$currentPart = $currentGame->getCurrentPart();
		
		$this->var['designation'] ='Current game : '.$currentPart->getDesignation();

	}
	

}