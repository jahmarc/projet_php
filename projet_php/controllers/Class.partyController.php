<?php
class partyController extends Controller{
	/**
	 * Method called by the form of the page newparty.php and listOfparty
	 */

	function newParty(){
		$this->vars['msg'] = "Nouvelle partie";
	}
	function listOfTables(){
		$user = $_SESSION ['user'];
		$idUser = $user->getId ();
		$strPparts = Part::getPartsPendingToStart ( $idUser );
		$this->vars ['msg'] = "List of parties in progress";
		$this->vars ['strPparts'] = $strPparts;
	}
	
	
	function mygames()
	{
		
		$this->vars ['msg'] = "My Games Statistics";
		
	}
	
	

	public function partyRegister() {
		$idPart = 0;
		foreach ( $_GET as $key => $value ) {
			$idPart = $key;
		}
		
		$user = $_SESSION ['user'];
		$idUser = $user->getId();

		
		if ($idPart > 0) {
			// charge la partie
			$currentPart = Part::getPartByIdPart( $idPart );
			// ajoute l'user
			if($currentPart->addUserInPart( $idUser ) == false){
				// impossible d'ajouter l'user
				// retourner dans la page des parties in progress
				$this->redirect ( 'party', 'listoftables' );
			}else{
				// user ajout� � la partie
				// aller dans la partie (m�me si en attente)
				$currentPart = Part::getPartByIdPart( $idPart );
				echo 'idUser : ' . $idUser. ' ; idPart : ' . $idPart. ' ; currentPart->getCountPlayers : ' . $currentPart->getCountPlayers();
			}
		}
			
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
		//Check if data valid
		
		if(empty($designation)){
			$_SESSION['msg'] = '<span class="error">A required field is empty!</span>';
			$_SESSION['persistence'] = array($designation);
		}
		
		else{
			$idPart = Part::newPart ( $idUser, $designation );
			if ($idPart < 1) {
				$_SESSION ['msg'] = '<span class="error">Unkown error!</span>';
				$_SESSION ['persistence'] = array (
						$designation
				);
			} else {
				$_SESSION ['msg'] = '<span class="success">New part created!</span>';
				unset ( $_SESSION ['persistence'] );
			}
		}
		$this->redirect('party', 'listoftables');
	}}