<?php
class Pli{
	private $idPli;
	private $idDonne;
	private $nrPli = 0;
	private $firstPlayer = 0;
	private $winner = 0;
	private $nrCards = array(1 => 0, 0, 0, 0);
	private $result = 0;
	
	public function __construct($idPli=null, $idDonne, $nrPli, $firstPlayer, $winner, $nrCards, $result){
		$this->setIdPli($idPli);
		$this->setIdDonne($idDonne);
		$this->setNrPli($nrPli);
		$this->setFirstPlayer($firstPlayer);
		$this->setWinner($winner);
		$this->setNrCards($nrCards);
		$this->setResult($result);
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
					, winner
					, pointsResult
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
						, $res_pli['winner']						
						, array(1 => $res_pli['pointsResult'])
						);
			}
			return $plis;
	}
	
	
	/**
	 * getLastNrPli : recherche  du dernier numéro de pli
	 * @return le nrPli de la dernière pli créée (ok) sinon 0
	 */
	public static function getLastNrPli($idDonne){
		// select max
		$query = "SELECT MAX(nrPli) as lastNrPli FROM pli WHERE IDDonne = ? GROUP BY IDDonne;";
		$attributes = array($idDonne);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return 0;
			
			// MAX(nrPli) as lastNrPli
			return $result['result'][0];
			
	}
	
	
	/**
	 * newPli : création d'une nouvelle pli de la donne
	 * @return idPli de la pli créée (ok) sinon -1 en cas d'erreur
	 */
	public static function newPli($idDonne, $firstPlayer){
		$nrPli = 1 + Pli::getLastNrPli($idDonne);
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
	 * save : save (update) de l'objet en cours
	 * @return boolean true/false
	 */
	public function save(){
		// UPDATE (jamais modifier ni idPli, ni idDonne, ni NrPli, ni firstPlayer)
		$query = "UPDATE pli SET
					  pointsResult = ?
					, nrCard_1 = ?
					, nrCard_2 = ?
					, nrCard_3 = ?
					, nrCard_4 = ?
					, winner = ?
					 WHERE IDPli = ?;";
		$attributes = array(
				$this->getResult()
				, $this->getNrCards()[1]
				, $this->getNrCards()[2]
				, $this->getNrCards()[3]
				, $this->getNrCards()[4]
				, $this->winner()
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
	 * getNextPlayer : renvoi le prochain joueur jusqu'à ce que toutes les cartes aient été jouées
	 * si c'est le premier joueur a laissé sa carte c'est le firstplayer qui comment
	 * sinon c'est le prochain
	 */
	public static function getNextPlayer(){
		
	}
	
	
	
	
	/**
	 * getFirstPlayer : renvoi le premier joueur du pli
	 * la première fois le premier joueur est celui qui a choisi l'atoût
	 * le premier joueur est celui qui a gagné le pli précédent
	 */
	public static function getFirstPlayer(){
		if($idPli=1){
			//Je ne sais pas si c'est comme cela qu'on appelle la méthode
			$firstPlayer = Hand::firstPlayerTest($hand, $nrPlayer);
		}
		else{
			$firstPlayer = getWinner();
		}
	}
	
	
	/**
	 * countResult : renvoi le résultat de chaque équipe pour le pli joué
	 */
	
	
	/**
	 * getWinner : renvoi le gagnant du pli qui vient d'être joué
	 */
	
	
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
	
	public function getWinner(){
		return $this->winner;
	}
	
	public function setWinner($winner){
		$this->winner = $winner;
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
}