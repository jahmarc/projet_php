<?php
class Donne{
	private $idDonne;
	private $idPart;
	private $result = array(null,0,0);
	private $annonce = array(null,0,0);
	private $stock = array(null,0,0);
	private $asset = 0;
	private $chibre = false;
	
	public function __construct($idDonne=null, $idPart, $result, $annonce, $stock, $asset, $chibre){
		$this->setIdDonne($idDonne);
		$this->setIdPart($idPart);
		$this->setResult($result);
		$this->setAnnonce($annonce);
		$this->setStock($stock);
		$this->setAsset($asset);
		$this->setChibre($chibre);
	}
	/**
	 * newDonne : création d'une nouvelle donne de la partie
	 * @return idDonne de la donne créée (ok) sinon -1 en cas d'erreur
	 */
	public static function newDonne($idPart){
		
		// insert
		$query = "INSERT INTO donne(IDPart)	VALUES(?);";
		$attributes = array($idPart);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return -1;
		
		// last insert id
		$id = MySqlConn::getInstance()->last_Insert_Id();
		if($id < 1) return -1;
		return $id;
		
	}
	/**
	 * save : sauve (update) de l'objet en cours
	 * @return boolean true/false
	 */
	 public function save(){
		// UPDATE (jamais modifier ni idDonne, ni IdPart)
		$query = "UPDATE donne SET  
					  pointsResult_1 = ?
					, pointsResult_2 = ?
					, annonces_1 = ?
					, annonces_2 = ?
					, stock_1 = ?
					, stock_2 = ?
					, asset = ?
					, chibre = ? 
					 WHERE IDDonne = ?;";
		$attributes = array(
				  $this->getResult()[1]
				, $this->getResult()[2]
				, $this->getAnnonce()[1]
				, $this->getAnnonce()[2]
				, $this->getStock()[1]
				, $this->getStock()[2]
				, $this->getAsset()
				, $this->getChibre()
				, $this->getIdDonne()
		);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return false;
		
		return true;
	}
	
	/**
	 * getDonnesPart : renvoi toutes les donnes de la partie
	 * @return un tableau de Donne de la partie
	 */
	public static function getDonnesPart($idPart){
		// tableau de players à retourner
		$donnes = array();
		// query select
		$query = "SELECT IDDonne 
					, IDPart 
					, pointsResult_1
					, pointsResult_2 
					, annonces_1
					, annonces_2 
					, stock_1 
					, stock_2 
					, asset 
					, chibre 
				 FROM donne 
				 WHERE IDPart = ? 
				 ORDER BY IDDonne;";
		$attributes = array($idPart);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;

		//	 boucler le résultat et ajouter dans le tableau de donne
		foreach ($result['result'] as $key => $res_donne){
			$donnes[$key+1] = new Donne($res_donne['IDDonne']
					, $res_donne['IDPart']
					, array(null, $res_donne['pointsResult_1'], $res_donne['pointsResult_2'])
					, array(null, $res_donne['annonces_1'], $res_donne['annonces_2'])
					, array(null, $res_donne['stock_1'], $res_donne['stock_2'])
					, $res_donne['asset']
					, $res_donne['chibre']);
		}
		return $donnes;
	}
	
	
	/**
	 * Getter and setter
	 */
	
	public function getIdDonne(){
		return $this->idDonne;
	}
	
	public function setIdDonne($idDonne){
		$this->idDonne = $idDonne;
	}
	
	public function getIdPart(){
		return $this->idPart;
	}
	
	public function setIdPart($idPart){
		$this->idPart = $idPart;
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
		$this->stock= $stock;
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
	
	public function setPointsResult($ndx, $points){
		$this->result[$ndx]= $points;
	}
	public function setPointsAnnnonce($ndx, $points){
		$this->annonce[$ndx]= $points;
	}
	public function setPointsStock($ndx, $points){
		$this->stock[$ndx]= $points;
	}
}