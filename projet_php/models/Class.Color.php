<?php
class Color{
	private $ndxColor;
	private $description;
	private $picture;
	
	const COEURS = 1;
	const CARREAUX = 2;
	const TREFFLES = 3;
	const PIQUES = 4;
	
	public function __construct($ndxColor, $description, $picture){
		$this->setNdxColor($ndxColor);
		$this->setDescription($description);
		$this->setPicture($picture);
	}
	
	public static function get4Colors(){
		$src = 'sources/colors/';
		// array (1 => ... : Index commençant à 1 avec array()
		return array (1 => new Color(self::COEURS, 'Coeurs', $src.'1_coeurs.png')
				, new Color(self::CARREAUX,'Carreaux', $src.'2_carreaux.png')
				, new Color(self::TREFFLES, 'Treffles', $src.'3_treffles.png')
				, new Color(self::PIQUES, 'Piques', $src.'4_piques.png')
		);
	}
	public function toString(){
		return '['.$this->getNdxColor().'] '.$this->getDescription();
	}
	
	/**
	 * Getter and setter
	 */
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
}