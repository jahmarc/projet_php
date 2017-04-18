<?php
class Hand{
	private $idHand;
	private $cards;
	
	public function __construct($idHand=null, $cards){
		$this->setIdHand($idHand);
		$this->setCards($cards);
	}
	
	public function getIdHand(){
		return $this->idHand;
	}
	
	public function setIdHand($idHand){
		$this->idHand = $idHand;
	}
	
	public function getCards(){
		return $this->cards;
	}
	
	public function setCards($cards){
		$this->cards = $cards;
	}
}