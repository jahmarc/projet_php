<?php
class Hand{
	private $idHand;
	private $idDonne;
	// numéro du joueur (1-4)
	private $nrPlayer;
	// tableau de 9 integer (1-9) : chaque int est l'index du jeu de carte <Card::get36Cards()>
	private $nrCards = array(null,0,0,0,0,0,0,0,0,0);
	
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
	public static function newHands($idDonne, $tbl4Hands){
		// si pas de idDonne ne rien faire
		if($idDonne < 1) return false;
		
		// si $tbl4Hands n'est pas un tableau ne rien faire
		if (!isset($tbl4Hands)) return false;
		
		// si pas un tableau de 4 ne rien faire
		if (count($tbl4Hands) != 4) return false;
		
		// si pas 36 éléments ne rien faire
		if (count($tbl4Hands, COUNT_RECURSIVE) != 36) return false;
		
		// boucle
		for ($i = 1; $i < 5; $i++) {
			$nrCards = $tbl4Hands[$i];
			$hand = new Hand($idDonne, $i, $nrCards);
			$hand->save();
			
		}
		
		return true;
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