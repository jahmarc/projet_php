<?php
class Card{
	private $idCard;
	private $picture;
	private $ndxColor;
	private $description;
	private $value;
	private $valueAsset;
	private $points;
	private $pointsAsset;
	
	public function __construct($idCard=null, $picture, $ndxColor, $description, $value, $valueAsset, $points, $pointsAsset){
		$this->setIdCard($idCard);
		$this->setPicture($picture);
		$this->setNdxColor($ndxColor);
		$this->setdescription($description);
		$this->setValue($value);
		$this->setValueAsset($valueAsset);
		$this->setPoints($points);
		$this->setPointsAsset($pointsAsset);
	}
	
	public function getIdCard(){
		return $this->idCard;
	}
	
	public function setIdCard($idCard){
		$this->idCard = $idCard;
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
}