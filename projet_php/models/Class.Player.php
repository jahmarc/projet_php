<?php
class Player{
	private $idPart;
	private $idUser;
	private $nrPlayer;
	private $winner;
	
	public function __construct($idPart=null, $idUser, $nrPlayer, $winner){
		$this->setIdPart($idPart);
		$this->setIdUser($idUser);
		$this->setNrPlayer($nrPlayer);
		$this->setWinner($winner);
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
		$this->idUser= $idUser;
	}
	
	public function getNrPlayer(){
		return $this->$nrPlayer;
	}
	
	public function setNrPlayer($nrPlayer){
		$this->$nrPlayer= $nrPlayer;
	}
	
	public function getWinner(){
		return $this->winner;
	}
	
	public function setWinner($winner){
		$this->winner = $winner;
	}
	
}