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
		
		$link = URL_DIR.'party/partyRegister' ;
		
		echo '<form action="'.$link.'" method="get">';
			
		echo '<table align="center" style="width:50%; border-bottom-style=double; border-width:0px;">';
		
		foreach ($strPparts as $value){
			echo '<tr><td>'.$value[1].'</td><td></td></tr>
					<tr><td style="font-size:10px;">'.$value[2].'</td><td><input class="OK" type="submit" value="inscription" name="'.$value[0].'"></td></tr>
						<tr><td colspan="2" style="background-color:#018de1; height:0.5px;"></td></tr>	';
		}
	
		echo '</table></form>';
	}
	

	
	
	public function partyRegister(){
				
		foreach($_GET as $key=>$value){
			echo $key;
		}

		
		$user = $_SESSION['user'];
		$idUser = $user->getId();
		
		

		$currentPart2 = Part::getPartByIdPart($key);
		$currentPart2->Part::addUserInPart($idUser);
		
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
		
			//$this->redirect('newParty', 'listOfTables');
		}
	
	
	}