<?php
class Color{
	private $ndxColor;
	private $description;
	private $picture;
	
	const COEURS = 0;
	const CARREAUX = 1;
	const TREFFLES = 2;
	const PIQUES = 3;
	
	public function __construct($ndxColor, $description, $picture){
		$this->setNdxColor($ndxColor);
		$this->setDescription($description);
		$this->setPicture($picture);
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
	public function getPicture(){
		return $this->picture;
	}
	
	public function setPicture($picture){
		$this->picture = $picture;
	}
	public static function get4Colors(){
		$src = 'images/cards/colors/';
		return array (new Color(self::COEURS, 'Coeurs', $src.'0_coeurs.png')
				, new Color(self::CARREAUX,'Carreaux', $src.'1_carreaux.png')
				, new Color(self::TREFFLES, 'Treffles', $src.'2_treffles.png')
				, new Color(self::PIQUES, 'Piques', $src.'3_piques.png')
		);
	}
	public function toString(){
		return $this->getNdxColor().' '.$this->getDescription().' '.$this->getPicture();
	}
}