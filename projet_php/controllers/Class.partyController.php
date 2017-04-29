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

		//$strPparts = Part::getPartsPendingToStart($idUser);
		
		$this->echoPartsPending();
		
		echo "<br><br><br><br><br>";
		
	
	}
	
	
	public function echoPartsPending(){
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		$strPparts = Part::getPartsPendingToStart($idUser);
		foreach ($strPparts as $value){
			echo $value[0].' - '.$value[1].' - '.$value[2].' - '.$value[3]."<br>";
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