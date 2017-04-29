<?php
class partyController extends Controller{
	/**
	 * Method called by the form of the page newParty.php and listOfparty
	 */
	
	
	
	

	function newParty(){
		$this->vars['msg'] = "Nouvelle partie";
		
		
	}
	
	function listOfTables(){
		$this->vars['msg'] = "List of parties in progress";
		$user = $_SESSION['user'];
		$idUser = $user->getId();
				
	
	}
	

	public function echoPartsPending(){
		$url = URL_DIR."party/newParty";
		
		
		
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		$strPparts = Part::getPartsPendingToStart($idUser);
		echo '<table align="center" style="border-bottom-style="double">';
		
		foreach ($strPparts as $value){
			echo '<tr><td><a href="'.$url.'">'.$value[1].'<a/></td><td>'.$value[2].'</td></tr>';
		}
	
		echo '</table>';
	}
	

	
	
	public function partyRegister(){
		
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		
		
		Part::addUserInPart($idUser);
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