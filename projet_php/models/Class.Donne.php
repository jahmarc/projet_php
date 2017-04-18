<?php
class Donne{
	private $idDonne;
	private $result;
	private $annonce;
	private $asset;
	private $chibre;
	
	public function __construct($idDonne=null, $result, $annonce, $asset, $chibre){
		$this->setIdDonne($idDonne);
		$this->setResult($result);
		$this->setAnnonce($annonce);
		$this->setAsset($asset);
		$this->setChibre($chibre);
	}
	
	public function getIdDonne(){
		return $this->idDonne;
	}
	
	public function setIdDonne($idDonne){
		$this->idDonne = $idDonne;
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
	
	public function getAsset(){
		return $this->asset;
	}
	
	public function setAsset($asset){
		$this->asset = $asset;
	}
	
	public function getChibre(){
		return $this->chibre;
	}
	
	public function setChibre($chibre){
		$this->chibre = $chibre;
	}
}