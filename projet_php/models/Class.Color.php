<?php
class Color{
	private $ndxColor;
	private $description;
	
	public function __construct($ndxColor=null, $description){
		$this->setNdxColor($ndxColor);
		$this->setDescription($description);
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
}