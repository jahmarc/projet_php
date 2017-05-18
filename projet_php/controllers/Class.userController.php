<?php

class userController extends Controller {
	
	
	function settings(){
		$this->vars ['msg'] = 'Edit your profile';
		$this->getUserr();
	}
	
	
	public function getUserr(){
		$user = $_SESSION ['user'];
		$this->vars ['user'] = $user;
		
	}
	
}