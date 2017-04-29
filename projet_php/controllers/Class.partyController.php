<?php
class partyController extends Controller{
	/**
	 * Method called by the form of the page newParty.php and listOfparty
	 */

	function newParty(){
		$this->vars['msg'] = "Nouvelle partie";
		
		
	}
	
	function listOfTables(){
		$this->vars['msg'] = "Liste des Tables";
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		$partx = array();
		$partx = new Part("test");

		$partx->getPartsPendingToStart($idUser);
		
		echo $partx->getDesignation();
	}
	

	
	function showTables(){
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		$a = $this->getPartsPendingToStart($idUser);
	}
	
		function register(){
			//Get data posted by the form
			$designation = $_POST['designation'];
			$user = $_SESSION['user'];
			$idUser = $user->getId();
			//Check if data valid/**
			
			if(empty($designation)){
				$_SESSION['msg'] = '<span class="error">A required field is empty!</span>';
				$_SESSION['persistence'] = array($designation);
			}
			
			else{

				$part = new Part($designation);
				$result = $part->newPart($idUser,$designation);
				if($result['status']=='error'){
					$_SESSION['msg'] = '<span class="error">'.$result['result'].'</span>';
					$_SESSION['persistence'] = array($idPart, $players, $result, $annonces, $stock, $state, $designation, $createdBy, $createdOnAt, $modifBy, $modifOnAt);
				}
				else{
					$_SESSION['msg'] = '<span class="success">New part created!</span>';
					unset($_SESSION['persistence']);
				}
			}
		
			$this->redirect('newParty', 'listOfTables');
		}
	
}