<?php
class Pli{
	private $idPli;
	private $idDonne;
	private $nrPli = 0;
	private $firstPlayer = 0;
	private $nrCards = array(1 => 0, 0, 0, 0);
	private $result = array(1 => 0, 0);
	private $annonce= array(1 => 0, 0);
	private $stock = array(1 => 0, 0);
	
	public function __construct($idPli=null, $idDonne, $nrPli, $firstPlayer, $nrCards, $result, $annonce, $stock){
		$this->setIdPli($idPli);
		$this->setIdDonne($idDonne);
		$this->setNrPli($nrPli);
		$this->setFirstPlayer($firstPlayer);
		$this->setNrCards($nrCards);
		$this->setResult($result);
		$this->setAnnonce($annonce);
		$this->setStock($stock);
	}
	
	/**
	 * getPlisDonne : recherche les plis de la donne
	 * @return un tableau de plis de la donne
	 */
	public static function getPlisDonne($idDonne){
		// tableau de plis à retourner
		$plis = array();
		// query select
		$query = "SELECT IDPli
					, IDDonne
					, nrPli
					, nrCard_1
					, nrCard_2
					, nrCard_3
					, nrCard_4 
					, firstPlayer 
					, pointsResult_1
					, pointsResult_2
					, annonces_1
					, annonces_2
					, stock_1
					, stock_2
					FROM pli 
					WHERE IDDonne=? 
					ORDER BY nrPli;";
		$attributes = array($idDonne);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			//
			foreach ($result['result'] as $key => $res_pli){
				$ndx = $res_pli['nrPli'];
				$plis[$ndx] = new Pli($res_pli['IDPli']
						, $res_pli['IDDonne']
						, $res_pli['nrPli']
						, array(1 => $res_pli['nrCard_1'], $res_pli['nrCard_2'], $res_pli['nrCard_3'], $res_pli['nrCard_4'])
						, $res_pli['firstPlayer']
						, array(1 => $res_pli['pointsResult_1'], $res_pli['pointsResult_2'])
						, array(1 => $res_pli['annonces_1'], $res_pli['annonces_2'])
						, array(1 => $res_pli['stock_1'], $res_pli['stock_2'])
						);
			}
			
			return $plis;
			
	}
	
	/**
	 * newPli : création d'une nouvelle pli de la donne
	 * @return idPli de la pli créée (ok) sinon -1 en cas d'erreur
	 */
	public static function newPli($idDonne, $nrPli, $firstPlayer){
		
		// insert
		$query = "INSERT INTO pli(IDDonne, nrPli, firstPlayer)	VALUES(?, ?, ?);";
		$attributes = array($idDonne, $nrPli, $firstPlayer);
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
		// UPDATE (jamais modifier ni idPli, ni idDonne, ni NrPli, ni firstPlayer)
		$query = "UPDATE pli SET
					  pointsResult_1 = ?
					, pointsResult_2 = ?
					, annonces_1 = ?
					, annonces_2 = ?
					, stock_1 = ?
					, stock_2 = ?
					, nrCard_1 = ?
					, nrCard_2 = ?
					, nrCard_3 = ?
					, nrCard_4 = ?
					 WHERE IDPli = ?;";
		$attributes = array(
				$this->getResult()[1]
				, $this->getResult()[2]
				, $this->getAnnonce()[1]
				, $this->getAnnonce()[2]
				, $this->getStock()[1]
				, $this->getStock()[2]
				, $this->getNrCards()[1]
				, $this->getNrCards()[2]
				, $this->getNrCards()[3]
				, $this->getNrCards()[4]
				, $this->getIdPli()
		);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return false;
		
		return true;
	}
	
	
	/**
	 * setCardInArray : ajoute l'index de la carte (value) dans l'array <$nrCards> à l'index <$nr>
	 */
	public function setCardInArray($nr, $value){
		// si l'index est compris entre 1 et 4
		// si la carte est comprise entre 1 et 36
		if(($nr >= 1 && $nr <= 4) && (($value>= 1 && $value<= 36))){
			$this->nrCards[$nr] = $value;
		}
	}
	/**
	 * Getter and setter
	 */
	public function getIdPli(){
		return $this->idPli;
	}
	public function setIdPli($idPli){
		$this->idPli = $idPli;
	}

	public function getIdDonne(){
		return $this->idDonne;
	}
	public function setIdDonne($idDonne){
		$this->idDonne = $idDonne;
	}
	
	public function getNrPli(){
		return $this->nrPli;
	}
	public function setNrPli($nrPli){
		$this->nrPli = $nrPli;
	}
	
	public function getFirstPlayer(){
		return $this->firstPlayer;
	}
	public function setFirstPlayer($firstPlayer){
		$this->firstPlayer = $firstPlayer;
	}
	
	public function getNrCards(){
		return $this->nrCards;
	}
	
	public function setNrCards($nrCards){
		// si <$nrCards> n'est pas un tableau
		if (!isset($nrCards)) {
			$nrCards = array(1 => 0, 0, 0, 0);
		}
		$this->nrCards= $nrCards;
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
		$this->stock = $stock;
	}
}