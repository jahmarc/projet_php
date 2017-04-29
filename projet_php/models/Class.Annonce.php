<?php
class Annonce{
	private $idAnnonce;
	private $description;
	private $points;
	
	public function __construct($idAnnonce, $description, $points){
		$this->setIdAnnonce($idAnnonce);
		$this->setDescription($description);
		$this->setPoints($points);
	}
	
	public function toString(){
		return $this->getIdAnnonce().' '.$this->getDescription().' '.$this->getPoints();
	}
	
	public static function createAnnonces(){
		
		
		//function __construct($idAnnonce, $description, $points)
		// array (1 => ... : Index commençant à 1 avec array()
		return array (1 => new Annonce(1, 'Trois cartes !', 20)
				, new Annonce(2, 'Cinquante !', 50)
				, new Annonce(3, 'Cent ! - Quatre cartes identiques !', 100)
				, new Annonce(4, 'Cent ! - Cinq cartes consécutives !', 100)
				, new Annonce(5, 'Cent cinquante !', 150)
				, new Annonce(6, 'Deux cents !', 200)
				, new Annonce(7, 'Stöck !', 20)
				
		);
	}
	
	/**
	 * Getter and setter
	 */
	public function getIdAnnonce(){
		return $this->idAnnonce;
	}
	
	public function setIdAnnonce($idAnnonce){
		$this->idAnnonce = $idAnnonce;
	}
	
	
	public function getDescription(){
		return $this->description;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getPoints(){
		return $this->points;
	}
	
	public function setPoints($points){
		$this->points = $points;
	}
	
}