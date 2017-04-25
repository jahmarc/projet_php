<?php
class Hand{
	private $idHand;
	private $idDonne;
	// numéro du joueur (1-4)
	private $nrPlayer;
	// tableau de 9 integer (1-9) : chaque int est l'index du jeu de carte <Card::get36Cards()>
	private $nrCards = array(1 => 0,0,0,0,0,0,0,0,0); // Index commençant à 1 avec array()
	
	public function __construct($idHand=null, $idDonne, $nrPlayer, $nrCards){
		$this->setIdHand($idHand);
		$this->setIdDonne($idDonne);
		$this->setNrPlayer($nrPlayer);
		$this->setNrCards($nrCards);
	}
	/**
	 * newHands : création de 4 hands (mains) liées à la donne <$idDonne>
	 * $tbl4Hands est une matrice de 4 x 9 integer (cartes random)
	 * Prépare 4 objets à enregistrer avec <$this->save()>
	 * @return boolean true/false
	 */
	public static function newHands($idDonne){
		// si pas de idDonne ne rien faire
		if($idDonne < 1) return false;
		
		// recherche le tableau des hands déjà existants
		$hands = Hand::getHandsDonne($idDonne);
		// si le tableau existe il y a une erreur 
		if (isset($hands)) return false;
		
		// tableau de valeurs ordonnés de 1 à 36
		$packOfCards = range(1,36);
		// mélange le tableau de façon RANDOM
		shuffle($packOfCards);
		
		// prépare $tbl4Hands : un tableau de 4 tableaux de 9 cartes
		// $key valeurs compris entre 0 à 35
		foreach ($packOfCards as $key => $value){
			$tbl4Hands[($key / 8) + 1][($key % 8) + 1] =  $value;
		}
		
		// boucle le tableau pour enregistrer les 4 mains (hands)
		for ($i = 1; $i <= 4; $i++) {
			$nrCards = $tbl4Hands[$i];
			$hand = new Hand($idDonne, $i, $nrCards);
			$hand->save();
		}
		
		return true;
	}
	
	/**
	 * getDonnesPart : renvoi toutes les donnes de la partie
	 * @return un tableau de Donne de la partie
	 */
	public static function getHandsDonne($idDonne){
		// tableau de hands à retourner
		$hands = array();
		// query select
		$query = "SELECT IDHand
					, IDDonne
					, nrPlayer
					, nrCard_1
					, nrCard_2
					, nrCard_3
					, nrCard_4
					, nrCard_5
					, nrCard_6
					, nrCard_7
					, nrCard_8
					, nrCard_9
				 FROM hand
				 WHERE IDDonne = ?
				 ORDER BY nrPlayer;";
		$attributes = array($idDonne);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			
		//	 boucler le résultat et ajouter dans le tableau de hands
		foreach ($result['result'] as $res_hand){
			$nrPlayer = $res_hand['nrPlayer'];
			$hands[$nrPlayer] = new Hand($res_hand['IDHand']
					, $res_hand['IDDonne']
					, $nrPlayer
					, array(1 => $res_hand['nrCard_1']
							,$res_hand['nrCard_2']
							,$res_hand['nrCard_3']
							,$res_hand['nrCard_4']
							,$res_hand['nrCard_5']
							,$res_hand['nrCard_6']
							,$res_hand['nrCard_7']
							,$res_hand['nrCard_8']
							,$res_hand['nrCard_9'])
					);
		}
		return $hands;
	}
	
	
	/**
	 * save : création d'une nouvelle hand de la donne en cours
	 * PRIVÈ car il faut utiliser newHands() pour créer 4 à la fois
	 * Sauve l'objet <Hand> en cours
	 * @return idHand de la hand créée (ok) sinon -1 en cas d'erreur
	 */
	private function save(){
		// insert
		$query = "INSERT INTO hand (
					  IDDonne
					, nrPlayer
					, nrCard_1
					, nrCard_2
					, nrCard_3
					, nrCard_4
					, nrCard_5
					, nrCard_6
					, nrCard_7
					, nrCard_8
					, nrCard_9
					)
					VALUES
					(?,?,?,?,?,?,?,?,?,?,?);";
		
		
		$attributes = array($this->getIdDonne()
				, $this->getNrPlayer()
				, $this->getNrCards()[1]
				, $this->getNrCards()[2]
				, $this->getNrCards()[3]
				, $this->getNrCards()[4]
				, $this->getNrCards()[5]
				, $this->getNrCards()[6]
				, $this->getNrCards()[7]
				, $this->getNrCards()[8]
				, $this->getNrCards()[9]
		);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return -1;
		
		// last insert id
		$id = MySqlConn::getInstance()->last_Insert_Id();
		if($id < 1) return -1;
		return $id;
		
	}
	/**
	 * Getter and setter
	 */
	public function getIdHand(){
		return $this->idHand;
	}
	public function setIdHand($idHand){
		$this->idHand = $idHand;
	}
	
	public function getIdDonne(){
		return $this->idDonne;
	}
	public function setIdDonne($idDonne){
		$this->idDonne = $idDonne;
	}
	
	public function getNrPlayer(){
		return $this->nrPlayer;
	}
	public function setNrPlayer($nrPlayer){
		$this->nrPlayer = $nrPlayer;
	}
	
	public function getNrCards(){
		return $this->nrCards;
	}
	public function setNrCards($nrCards){
		$this->nrCards = $nrCards;
	}
}