<?php
class Pli{
	private $idPli;
	private $idDonne;
	private $nrPli = 0;
	private $firstPlayer = 0;
	private $winner = 0;
	private $nrCards = array(1 => 0, 0, 0, 0);
	private $result = 0;
	
	public function __construct($idPli=null, $idDonne, $nrPli, $nrCards, $firstPlayer, $winner, $result){
		$this->setIdPli($idPli);
		$this->setIdDonne($idDonne);
		$this->setNrPli($nrPli);
		$this->setNrCards($nrCards);
		$this->setFirstPlayer($firstPlayer);
		$this->setWinner($winner);
		$this->setResult($result);
	}
	
	/**
	 * getPlibyIdPli : recherche le pli selon son id
	 * @return le pli demand� par son Id
	 */
	public static function getPliByIdPli($idPli){
		// pli � retourner
		$pli = null;
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
					WHERE IDPli=?;";
		$attributes = array($idPli);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			//
			foreach ($result['result'] as $key => $res_pli){
				$ndx = $res_pli['nrPli'];
				$pli = new Pli($res_pli['IDPli']
						, $res_pli['IDDonne']
						, $res_pli['nrPli']
						, array(1 => $res_pli['nrCard_1'], $res_pli['nrCard_2'], $res_pli['nrCard_3'], $res_pli['nrCard_4'])
						, $res_pli['firstPlayer']
						, $res_pli['winner']
						, $res_pli['pointsResult']
						);
				
			}
			return $pli;
	}
	
	
	/**
	 * getPlisDonne : recherche les plis de la donne
	 * @return un tableau de plis de la donne
	 */
	public static function getPlisDonne($idDonne){
		// tableau de plis � retourner
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
						, $res_pli['pointsResult']
						);
			}
			return $plis;
	}
	
	
	/**
	 * getLastNrPli : recherche  du dernier num�ro de pli
	 * @return le nrPli de la derni�re pli cr��e (ok) sinon 0
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
	 * newPli : cr�ation d'une nouvelle pli de la donne
	 * @return idPli de la pli cr��e (ok) sinon -1 en cas d'erreur
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
				, $this->getWinner()
				, $this->getIdPli()
		);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return false;
		
		return true;
	}
	
	
	/**
	 * setCardInArray : ajoute l'index de la carte (value) dans l'array <$nrCards> � l'index <$nr>
	 */
	public function setCardInArray($nr, $value){
		// si l'index est compris entre 1 et 4
		// si la carte est comprise entre 1 et 36
		if(($nr >= 1 && $nr <= 4) && (($value >= 1 && $value <= 36))){
			$this->nrCards[$nr] = $value;
		}
		
	}
	
	
	/**
	 * getNextPlayer : renvoi le prochain joueur jusqu'� ce que toutes les cartes aient �t� jou�es
	 * si c'est le premier joueur a laiss� sa carte c'est le firstplayer qui comment
	 * sinon c'est le prochain
	 */
	public static function getNextPlayer(){
		
	}
	
	
	
	
	/**
	 * getFirstPlayer : renvoi le premier joueur du pli
	 * la premi�re fois le premier joueur est celui qui a choisi l'ato�t
	 * le premier joueur est celui qui a gagn� le pli pr�c�dent
	 */
	public static function getFirstPlayer_calc(){
		if($nrPli=1){
			//Je ne sais pas si c'est comme cela qu'on appelle la m�thode
			$firstPlayer = Hand::firstPlayerTest($hand, $nrPlayer);
		}
		else{
			$firstPlayer = getWinner();
		}
	}
	
	
	/**
	 * countResult : renvoi le r�sultat de chaque �quipe pour le pli jou�
	 */
	public static function countResult(){
		$cards = $this->nrCards;
		$idcard1 = nrCards[1];
		$idcard2 = nrCards[2];
		$idcard3 = nrCards[3];
		$idcard4 = nrCards[4];
		
	}
	
	
	/**
	 * getWinner : renvoi le gagnant du pli qui vient d'�tre jou�
	 */
	public static function getWinner_calc(){
		$cards = $this->nrCards;
		$idcard1 = nrCards[1];
		$idcard2 = nrCards[2];
		$idcard3 = nrCards[3];
		$idcard4 = nrCards[4];
		$winner = 0;
		
		
		//je vais chercher mes 4 valeurs
		$valeur1 = Card::getValeur($idCard1);
		$valeur2 = Card::getValeur($idcard2);
		$valeur3 = Card::getValeur($idcard3);
		$valeur4 = Card::getValeur($idcard4);
		
		
		//Je compare la 1�re et 2�me
		if ($valeur1 > $valeur2){
			$winner = 1;
			//1�re et 3�me
			if($valeur1 > $valeur3){
				$winner = 1;
				//1�re et 4�me
				if($valeur1 > $valeur4){
					$winner = 1;
				}
				else{
					$winner = 4;
				}
			}
			else{
				$winner = 3;
				//3�me et 4�me
				if($valeur3 > $valeur4){
					$winner = 3;
				}
				else{
					$winner = 4;
				}
			}
		}
		else{
			$winner = 2;
			//2�me et 3�me
			if($valeur2 > $valeur3){
				$winner = 2;
				//2�me et 4�me
				if($valeur2 > $valeur4){
					$winner = 2;
				}
				else{
					$winner = 4;
				}
			}
			else{
				$winner = 3;
				//3�me et 4�me
				if($valeur3 > $valeur4){
					$winner = 3;
				}
				else{
					$winner = 4;
				}
			}
		}
		
		// je retourne le num�ro de joueur qui a gagn�
		return $winner;
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
	
	public function getWinner(){
		return $this->winner;
	}
	
	public function setWinner($winner){
		$this->winner = $winner;
	}
	
	public function getNrCards(){
		// si <$nrCards> n'est pas un tableau
		if (!isset($this->nrCards)) {
			$this->nrCards = array(1 => 0, 0, 0, 0);
		}
		// s'il y a des null set � 0
		for ($i = 1; $i <= 4; $i++) {
			if (empty($this->nrCards[$i]))
				$this->nrCards[$i] = 0;
		}
		
		return $this->nrCards;
	}
	
	public function setNrCards($nrCards){
		// si <$nrCards> n'est pas un tableau
		if (!isset($nrCards)) {
			$nrCards = array(1 => 0, 0, 0, 0);
		}
		$this->nrCards = $nrCards;
	}
	
	public function getResult(){
		return $this->result;
	}
	
	public function setResult($result){
		$this->result = $result;
	}
}