<?php
class Chat{
	private $idChat;
	private $idPart;
	private $idUser;
	private $date;
	private $hour;
	private $text;
	
	public function __construct($idChat=null, $idPart, $idUser, $date, $hour, $text){
		$this->setIdChat($idChat);
		$this->setIdPart($idPart);
		$this->setIdUser($idUser);
		$this->setDate($date);
		$this->setHour($hour);
		$this->setText($text);
	}
	
	public function getIdChat(){
		return $this->idChat;
	}
	
	public function setIdChat($idChat){
		$this->idChat = $idChat;
	}
	
	public function getIdPart(){
		return $this->idPart;
	}
	
	public function setIdPart($idPart){
		$this->idPart = $idPart;
	}
	
	public function getIdUser(){
		return $this->idUser;
	}
	
	public function setIdUser($idUser){
		$this->idUser = $idUser;
	}
	
	public function getDate(){
		return $this->date;
	}
	
	public function setDate($date){
		$this->date = $date;
	}
	
	public function getHour(){
		return $this->hour;
	}
	
	public function setHour($hour){
		$this->hour = $hour;
	}
	
	public function getText(){
		return $this->text;
	}
	
	public function setText($text){
		$this->text = $text;
	}
}