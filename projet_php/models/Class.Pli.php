<?php
class Pli{
	private $idPli;
	private $firstGamer;
	private $cards;
	private $result;
	private $annonce;
	private $stock;
	
	public function __construct($idPli=null, $firstGamer, $cards, $result, $annonce, $stock){
		$this->setIdPli($idPli);
		$this->setFirstGamer($firstGamer);
		$this->setCards($cards);
		$this->setResult($result);
		$this->setAnnonce($annonce);
		$this->setStock($stock);
	}
	
	public function getIdPli(){
		return $this->idPli;
	}
	
	public function setIdPli($idPli){
		$this->idPli = $idPli;
	}
	
	public function getFirstGamer(){
		return $this->firstGamer;
	}
	
	public function setFirstGamer($firstGamer){
		$this->firstGamer = $firstGamer;
	}
	
	public function getCards(){
		return $this->cards;
	}
	
	public function setCards($cards){
		$this->cards = $cards;
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
	
	public function getStock(){
		return $this->stock;
	}
	
	public function setStock($stock){
		$this->stock = $stock;
	}
}