<?php
class Card{
	private $ndxCard;
	private $picture;
	private $ndxColor;
	private $description;
	private $value;
	private $valueAsset;
	private $points;
	private $pointsAsset;
	private $shortDescription;
	
	public function __construct($ndxCard, $picture, $ndxColor, $description, $value, $valueAsset, $points, $pointsAsset, $shortDescription){
		$this->setNdxCard($ndxCard);
		$this->setPicture($picture);
		$this->setNdxColor($ndxColor);
		$this->setDescription($description);
		$this->setValue($value);
		$this->setValueAsset($valueAsset);
		$this->setPoints($points);
		$this->setPointsAsset($pointsAsset);
		$this->setShortDescription($shortDescription);
	}
	
	public function toString(){
		return $this->getNdxCard().' '.$this->getShortDescription().' '.$this->getDescription().' '.$this->getPicture();
	}
	
	public static function getValeur($idCard){
		return Card::getValeur($idCard);
	}
	
	
	public static function get36Cards(){
		$src = 'css/sources/cartes/';
		/*
		 * 1, 'Coeurs' ,'Hearts'
		 * 2,' Carreaux', Diamonds
		 * 3, 'Treffles', Clubs
		 * 4, 'Piques'	Spades
		 */
		
		//function __construct($ndxCard, $picture, $ndxColor, $description, $value, $valueAsset, $points, $pointsAsset, $shortDescription)
		// array (1 => ... : Index commençant à 1 avec array()
		return array (1 => new Card(1, $src.'H6.png', Color::COEURS, "Six de coeurs", 6, 16, 0, 0, '6H')
				, new Card(2, $src.'H7.png', Color::COEURS, 'Sept de coeurs', 7, 17, 0, 0, '7H')
				, new Card(3, $src.'H8.png', Color::COEURS, 'Huit de coeurs', 8, 18, 0, 0, '8H')
				, new Card(4, $src.'H9.png', Color::COEURS, 'Neuf de coeurs', 9, 25, 0, 14, '9H')
				, new Card(5, $src.'H10.png', Color::COEURS, 'Dix de coeurs', 10, 20, 10, 10, '10H')
				, new Card(6, $src.'H11.png', Color::COEURS, 'Valet de coeurs', 11, 26, 2, 20, 'JH')
				, new Card(7, $src.'H12.png', Color::COEURS, 'Reine de coeurs', 12, 22, 3, 3, 'QH')
				, new Card(8, $src.'H13.png', Color::COEURS, 'Roi de coeurs', 13,23, 4, 4, 'KH')
				, new Card(9, $src.'H1.png', Color::COEURS, 'As de coeurs', 14, 24, 11, 11, 'AH')
				
				, new Card(10, $src.'C6.png', Color::CARREAUX, 'Six de carreaux', 6, 16, 0, 0, '6D')
				, new Card(11, $src.'C7.png', Color::CARREAUX, 'Sept de carreaux', 7, 17, 0, 0, '7D')
				, new Card(12, $src.'C8.png', Color::CARREAUX, 'Huit de carreaux', 8, 18, 0, 0, '8D')
				, new Card(13, $src.'C9.png', Color::CARREAUX, 'Neuf de carreaux', 9, 25, 0, 14, '9D')
				, new Card(14, $src.'C10.png', Color::CARREAUX, 'Dix de carreaux', 10, 20, 10, 10, '10D')
				, new Card(15, $src.'C11.png', Color::CARREAUX, 'Valet de carreaux', 11, 26, 2, 20, 'JD')
				, new Card(16, $src.'C12.png', Color::CARREAUX, 'Reine de carreaux', 12, 22, 3, 3, 'QD')
				, new Card(17, $src.'C13.png', Color::CARREAUX, 'Roi de carreaux', 13,23, 4, 4, 'KD')
				, new Card(18, $src.'C1.png', Color::CARREAUX, 'As de carreaux', 14, 24, 11, 11, 'AD')
				
				, new Card(19, $src.'T6.png', Color::TREFFLES, 'Six de treffles', 6, 16, 0, 0, '6C')
				, new Card(20, $src.'T7.png', Color::TREFFLES, 'Sept de treffles', 7, 17, 0, 0, '7C')
				, new Card(21, $src.'T8.png', Color::TREFFLES, 'Huit de treffles', 8, 18, 0, 0, '8C')
				, new Card(22, $src.'T9.png', Color::TREFFLES, 'Neuf de treffles', 9, 25, 0, 14, '9C')
				, new Card(23, $src.'T10.png', Color::TREFFLES, 'Dix de treffles', 10, 20, 10, 10, '10C')
				, new Card(24, $src.'T11.png', Color::TREFFLES, 'Valet de treffles', 11, 26, 2, 20, 'JC')
				, new Card(25, $src.'T12.png', Color::TREFFLES, 'Reine de treffles', 12, 22, 3, 3, 'QC')
				, new Card(26, $src.'T13.png', Color::TREFFLES, 'Roi de treffles', 13,23, 4, 4, 'KC')
				, new Card(27, $src.'T1.png', Color::TREFFLES, 'As de treffles', 14, 24, 11, 11, 'AC')
				
				, new Card(28, $src.'P6.png', Color::PIQUES, 'Six de piques', 6, 16, 0, 0, '6S')
				, new Card(29, $src.'P7.png', Color::PIQUES, 'Sept de piques', 7, 17, 0, 0, '7S')
				, new Card(30, $src.'P8.png', Color::PIQUES, 'Huit de piques', 8, 18, 0, 0, '8S')
				, new Card(31, $src.'P9.png', Color::PIQUES, 'Neuf de piques', 9, 25, 0, 14, '9S')
				, new Card(32, $src.'P10.png', Color::PIQUES, 'Dix de piques', 10, 20, 10, 10, '10S')
				, new Card(33, $src.'P11.png', Color::PIQUES, 'Valet de piques', 11, 26, 2, 20, 'JS')
				, new Card(34, $src.'P12.png', Color::PIQUES, 'Reine de piques', 12, 22, 3, 3, 'QS')
				, new Card(35, $src.'P13.png', Color::PIQUES, 'Roi de piques', 13,23, 4, 4, 'KS')
				, new Card(36, $src.'P1.png', Color::PIQUES, 'As de piques', 14, 24, 11, 11, 'AS')
				
		);
	}
	
	/**
	 * Getter and setter
	 */
	public function getNdxCard(){
		return $this->ndxCard;
	}
	
	public function setNdxCard($ndxCard){
		$this->ndxCard = $ndxCard;
	}
	
	public function getPicture(){
		return $this->picture;
	}
	
	public function setPicture($picture){
		$this->picture = $picture;
	}
	
	public function getNdxColor(){
		return $this->ndxColor;
	}
	
	public function setNdxColor($ndxColor){
		$this->ndxColor = $ndxColor;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function getValueAsset(){
		return $this->valueAsset;
	}
	
	public function setValueAsset($valueAsset){
		$this->valueAsset = $valueAsset;
	}
	
	public function getPoints(){
		return $this->points;
	}
	
	public function setPoints($points){
		$this->points = $points;
	}
	
	public function getPointsAsset(){
		return $this->pointsAsset;
	}
	
	public function setPointsAsset($pointsAsset){
		$this->pointsAsset = $pointsAsset;
	}
	public function getShortDescription(){
		return $this->shortDescription;
	}
	
	public function setShortDescription($shortDescription){
		$this->shortDescription= $shortDescription;
	}
}