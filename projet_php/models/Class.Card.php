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
	
	public static function get36Cards(){
		$src = 'images/cards/';
		/*
		 * 1, 'Coeurs' ,'Hearts'
		 * 2,' Carreaux', Diamonds
		 * 3, 'Treffles', Clubs
		 * 4, 'Piques'	Spades
		 */
		
		//function __construct($ndxCard, $picture, $ndxColor, $description, $value, $valueAsset, $points, $pointsAsset, $shortDescription)
		// array (1 => ... : Index commençant à 1 avec array()
		return array (1 => new Card(1, $src.'6H.png', Color::COEURS, "Six de coeurs", 6, 16, 0, 0, '6H')
				, new Card(2, $src.'7H.png', Color::COEURS, 'Sept de coeurs', 7, 17, 0, 0, '7H')
				, new Card(3, $src.'8H.png', Color::COEURS, 'Huit de coeurs', 8, 18, 0, 0, '8H')
				, new Card(4, $src.'9H.png', Color::COEURS, 'Neuf de coeurs', 9, 25, 0, 14, '9H')
				, new Card(5, $src.'10H.png', Color::COEURS, 'Dix de coeurs', 10, 20, 10, 10, '10H')
				, new Card(6, $src.'JH.png', Color::COEURS, 'Valet de coeurs', 11, 26, 2, 20, 'JH')
				, new Card(7, $src.'QH.png', Color::COEURS, 'Reine de coeurs', 12, 22, 3, 3, 'QH')
				, new Card(8, $src.'KH.png', Color::COEURS, 'Roi de coeurs', 13,23, 4, 4, 'KH')
				, new Card(9, $src.'AH.png', Color::COEURS, 'As de coeurs', 14, 24, 11, 11, 'AH')
				
				, new Card(10, $src.'6D.png', Color::CARREAUX, 'Six de carreaux', 6, 16, 0, 0, '6D')
				, new Card(11, $src.'7D.png', Color::CARREAUX, 'Sept de carreaux', 7, 17, 0, 0, '7D')
				, new Card(12, $src.'8D.png', Color::CARREAUX, 'Huit de carreaux', 8, 18, 0, 0, '8D')
				, new Card(13, $src.'9D.png', Color::CARREAUX, 'Neuf de carreaux', 9, 25, 0, 14, '9D')
				, new Card(14, $src.'10D.png', Color::CARREAUX, 'Dix de carreaux', 10, 20, 10, 10, '10D')
				, new Card(15, $src.'JD.png', Color::CARREAUX, 'Valet de carreaux', 11, 26, 2, 20, 'JD')
				, new Card(16, $src.'QD.png', Color::CARREAUX, 'Reine de carreaux', 12, 22, 3, 3, 'QD')
				, new Card(17, $src.'KD.png', Color::CARREAUX, 'Roi de carreaux', 13,23, 4, 4, 'KD')
				, new Card(18, $src.'AD.png', Color::CARREAUX, 'As de carreaux', 14, 24, 11, 11, 'AD')
				
				, new Card(19, $src.'6C.png', Color::TREFFLES, 'Six de treffles', 6, 16, 0, 0, '6C')
				, new Card(20, $src.'7C.png', Color::TREFFLES, 'Sept de treffles', 7, 17, 0, 0, '7C')
				, new Card(21, $src.'8C.png', Color::TREFFLES, 'Huit de treffles', 8, 18, 0, 0, '8C')
				, new Card(22, $src.'9C.png', Color::TREFFLES, 'Neuf de treffles', 9, 25, 0, 14, '9C')
				, new Card(23, $src.'10C.png', Color::TREFFLES, 'Dix de treffles', 10, 20, 10, 10, '10C')
				, new Card(24, $src.'JC.png', Color::TREFFLES, 'Valet de treffles', 11, 26, 2, 20, 'JC')
				, new Card(25, $src.'QC.png', Color::TREFFLES, 'Reine de treffles', 12, 22, 3, 3, 'QC')
				, new Card(26, $src.'KC.png', Color::TREFFLES, 'Roi de treffles', 13,23, 4, 4, 'KC')
				, new Card(27, $src.'AC.png', Color::TREFFLES, 'As de treffles', 14, 24, 11, 11, 'AC')
				
				, new Card(28, $src.'6S.png', Color::PIQUES, 'Six de piques', 6, 16, 0, 0, '6S')
				, new Card(29, $src.'7S.png', Color::PIQUES, 'Sept de piques', 7, 17, 0, 0, '7S')
				, new Card(30, $src.'8S.png', Color::PIQUES, 'Huit de piques', 8, 18, 0, 0, '8S')
				, new Card(31, $src.'9S.png', Color::PIQUES, 'Neuf de piques', 9, 25, 0, 14, '9S')
				, new Card(32, $src.'10S.png', Color::PIQUES, 'Dix de piques', 10, 20, 10, 10, '10S')
				, new Card(33, $src.'JS.png', Color::PIQUES, 'Valet de piques', 11, 26, 2, 20, 'JS')
				, new Card(34, $src.'QS.png', Color::PIQUES, 'Reine de piques', 12, 22, 3, 3, 'QS')
				, new Card(35, $src.'KS.png', Color::PIQUES, 'Roi de piques', 13,23, 4, 4, 'KS')
				, new Card(36, $src.'AS.png', Color::PIQUES, 'As de piques', 14, 24, 11, 11, 'AS')
				
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