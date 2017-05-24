<?php

class userController extends Controller {
	
	
	function settings(){
		$this->vars ['msg'] = 'Edit your profile';
		
		$user = $_SESSION ['user'];
		
		
		$this->getUserr();
	}
	
	
	public function getUserr(){
		$user = $_SESSION ['user'];
		$this->vars ['user'] = $user;
		
	}
	
	/**
	 * Method called by the form of the page settings.php
	 */
	public function edit(){
		// Get data posted by the form
		$user = $_SESSION ['user'];
		
		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$uname = $_POST['username'];
		$pword = $_POST['password'];
		$cword = $_POST['confirmpassword'];
		
		// Check if data valid
		
		if($pword == $cword){
			$_SESSION ['persistence'] = array (
					$fname,
					$lname,
					$uname,
					$pword,
					$cword			
			);
			
			$user->update($fname,$lname,$uname,$pword);
			
			$this->redirect ( 'login', 'welcome' );
				
		}
		
		
		
		
	}
	
}