<?php
class Part{
	private $idPart;
	private $gamer;
	private $result;
	private $annonce;
	
	public function __construct($idPart=null, $gamer, $result, $annonce){
		$this->setIdPart($idPart);
		$this->setGamer($gamer);
		$this->setResult($result);
		$this->setAnnonce($annonce);
	}
	
	public function getIdPart(){
		return $this->idPart;
	}
	
	public function setIdPart($idPart){
		$this->idPart = $idPart;
	}
	
	public function getGamer(){
		return $this->gamer;
	}
	
	public function setGamer($gamer){
		$this->gamer = $gamer;
	}
	
	public function getResult(){
		return $this->result;
	}
	
	public function setResult($result){
		$this->result = $result;
	}
	
	public function getAnnonce(){
		return $this->annonce;
	}
	
	public function setAnnonce($annonce){
		$this->annonce = $annonce;
	}
}