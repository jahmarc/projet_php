<?php
class Hand{
	private $idHand;
	private $idDonne;
	// num�ro du joueur (1-4)
	private $nrPlayer;
	// tableau de 9 integer (1-9) : chaque int est l'index du jeu de carte <Card::get36Cards()>
	private $nrCards = array(1 => 0,0,0,0,0,0,0,0,0); // Index commencant a 1 avec array()
	
	public function __construct($idHand=null, $idDonne, $nrPlayer, $nrCards){
		$this->setIdHand($idHand);
		$this->setIdDonne($idDonne);
		$this->setNrPlayer($nrPlayer);
		$this->setNrCards($nrCards);
	}
	/**
	 * newHands : cr�ation de 4 hands (mains) li�es � la donne <$idDonne>
	 * $tbl4Hands est une matrice de 4 x 9 integer (cartes random)
	 * Pr�pare 4 objets � enregistrer avec <$this->save()>
	 * @return boolean true/false
	 */
	public static function newHands($idDonne){
		// si pas de idDonne ne rien faire
		if($idDonne < 1) return false;
		
		// recherche le tableau des hands d�j� existants
		$hands = Hand::getHandsDonne($idDonne);
		// si le tableau existe il y a une erreur
		if(!empty($hands)) return false;
		
		
		// tableau de valeurs ordonn�s de 1 � 36
		$packOfCards = range(1,36);
		// m�lange le tableau de fa�on RANDOM
		shuffle($packOfCards);
		
		// pr�pare $tbl4Hands : un tableau de 4 tableaux de 9 cartes
		// $key valeurs compris entre 0 � 35
		foreach ($packOfCards as $key => $value){
			$tbl4Hands[($key % 4) + 1][($key % 9) + 1] =  $value;
		}
		
		// boucle le tableau pour enregistrer les 4 mains (hands)
		for ($i = 1; $i <= 4; $i++) {
			$nrCards = $tbl4Hands[$i];
			$hand = new Hand(null, $idDonne, $i, $nrCards);
			$hand->save();
		}
		
		return true;
	}
	/**
	 * getNrPlayerWith7Diamonds : renvoi le 1er joueur de la première pli
	 * @return un le nr du joueur avec le 7 de carreaux dans les mains
	 */
	public static function getNrPlayerWith7Diamonds($idDonne){
		$hands = Hand::getHandsDonne($idDonne);
		foreach ( $hands as $hand ) {
			$arrayCard = $hand->getNrCards();
			foreach ( $arrayCard as $nrCard) {
				//			echo '<br/> cardPlayed = '.$cardPlayed.'; cardSearch = '.$cardSearch.'; ';
				if ($nrCard == Card::SEPT_CARREAUX)
					return $hand->getNrPlayer();
			}
		}
		
		return 1;
		
	}
	/**
	 * getDonnesPart : renvoi toutes les donnes de la partie
	 * @return un tableau de Donne de la partie
	 */
	public static function getHandsDonne($idDonne){
		// tableau de hands � retourner
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
				 ORDER BY nrPlayer ;";
		$attributes = array($idDonne);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			
			//	 boucler le r�sultat et ajouter dans le tableau de hands
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
	 * getHandPlayer : renvoi toutes les cartes d'un joueur
	 * @return un tableau de cartes
	 */
	public static function getHandPlayer($idDonne, $nrPlayer){
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
				 AND nrPlayer = ?;";
		
		$attributes = array($idDonne, $nrPlayer);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			
			//	 boucler le r�sultat et ajouter dans le tableau de hands
			foreach ($result['result'] as $res_hand){
				$hand= new Hand($res_hand['IDHand']
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
			return $hand;
	}
	
	/**
	 * checkAnnonces : Contr�le la main d'un joueur afin de v�rifier quels sont les annonces qu'il poss�de
	 * @return l'id de l'annonce correspondante
	 */
	public static function checkAnnonces($hand){
		// variable � retourner � la fin
		$annonce=0;
		
		//Cr�ation d'un tableau de bool afin de garder les r�sultats en m�moires
		
		//On va cherche la main du joueur � tester
		$cards = $hand->getNrCards();
		
		//TEST 1 : 4 valets
		$isTrue = Hand::fourValetTest($cards);
		if($isTrue == true){
			$annonce = 6;
			return $annonce;
		}
		
		//TEST 2 : 4 neufs
		$isTrue = Hand::fourNineTest($cards);
		if($isTrue == true){
			$annonce = 5;
			return $annonce;
		}
		
		//TEST 3 : 5 cartes cons�qutives
		$isTrue = Hand::fiveCardsTest($cards);
		if($isTrue == true){
			$annonce = 4;
			return $annonce;
		}
		
		//TEST 4 : 4 cartes identiques
		$isTrue = Hand::fourIdenticalCardsTest($cards);
		if($isTrue == true){
			$annonce = 3;
			return $annonce;
		}
		
		//TEST 5 : 4 cartes cons�qutives
		$isTrue = Hand::fourCardsTest($cards);
		if($isTrue == true){
			$annonce = 2;
			return $annonce;
		}
		
		//TEST 6 : 3 cartes cons�qutives
		$isTrue = Hand::threeCardsTest($cards);
		if($isTrue == true){
			$annonce = 1;
			return $annonce;
		}
		
		//echo "</br>";
		
		//echo $annonce;
		
		
		
		
		return $annonce;
	}
	
	/**
	 * threeCardsTest : Contr�le la main d'un joueur afin de v�rifier s'il a trois cartes cons�qutives
	 * @return vrai ou faux
	 */
	public static function threeCardsTest($card){
		// variable � retourner � la fin
		$result = false;
		$var1;
		$var2;
		
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $card[$i];
			for($j=1; $j<=9; $j++)
			{
				$id2 = $card[$j];
				$var1 = min($id1,$id2);
				$var2 = max($id1,$id2);
				if($var2-$var1 == 1)
				{
					for($k=1; $k<=9; $k++){
						$id3 = $card[$k];
						if($id3>$var2){
							if($id3-$var2==1)
							{
								$result=true;
							}
						}
						else{
							if($var1-$id3==1)
							{
								$result=true;
							}
						}
					}
				}
			}
		}
		return $result;
	}
	
	/**
	 * fourCardsTest : Contr�le la main d'un joueur afin de v�rifier s'il a quatre cartes cons�qutives
	 * @return vrai ou faux
	 */
	public static function fourCardsTest($card){
		// variable � retourner � la fin
		$result = false;
		$var1;
		$var2;
		
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $card[$i];
			for($j=1; $j<=9; $j++)
			{
				$id2 = $card[$j];
				$var1 = min($id1,$id2);
				$var2 = max($id1,$id2);
				if($var2-$var1 == 1)
				{
					for($k=1; $k<=9; $k++){
						$id3 = $card[$k];
						if($id3>$var2){
							if($id3-$var2==1)
							{
								$var2 = $id3;
								for($l=1; $l<=9; $l++){
									$id4 = $card[$l];
									if($id4>$var2){
										if($id4-$var2==1){
											$result=true;
										}
									}
									else{
										if($var1-$id4==1){
											$result=true;
										}
									}
								}
							}
						}
						else{
							if($var1-$id3==1)
							{
								$var1 = $id3;
								for($l=1; $l<=9; $l++){
									$id4 = $card[$l];
									if($id4>$var2){
										if($id4-$var2==1){
											$result=true;
										}
									}
									else{
										if($var1-$id4==1){
											$result=true;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}
	
	
	/**
	 * fiveCardsTest : Contr�le la main d'un joueur afin de v�rifier s'il a cinq cartes cons�qutives
	 * @return vrai ou faux
	 */
	public static function fiveCardsTest($card){
		// variable � retourner � la fin
		$result = false;
		$var1;
		$var2;
		
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $card[$i];
			for($j=1; $j<=9; $j++)
			{
				$id2 = $card[$j];
				$var1 = min($id1,$id2);
				$var2 = max($id1,$id2);
				if($var2-$var1 == 1)
				{
					for($k=1; $k<=9; $k++){
						$id3 = $card[$k];
						if($id3>$var2){
							if($id3-$var2==1)
							{
								$var2 = $id3;
								for($l=1; $l<=9; $l++){
									$id4 = $card[$l];
									if($id4>$var2){
										if($id4-$var2==1){
											$var2 = $id4;
											for($m=1; $m<=9; $m++){
												$id5 = $card[$m];
												if($id5>$var2){
													if($id5-$var2==1)
													{
														$result=true;
													}
												}
												else{
													if($var1-$id5==1){
														$result=true;
													}
												}
											}
										}
									}
									else{
										if($var1-$id4==1){
											$var1 = $id4;
											for($m=1; $m<=9; $m++){
												$id5 = $card[$m];
												if($id5>$var2){
													if($id5-$var2==1){
														$result=true;
													}
												}
												else{
													if($var1-$id5==1){
														$result=true;
													}
												}
											}
										}
									}
								}
							}
							else{
								if($var1-$id3==1)
								{
									$var1 = $id3;
									for($l=1; $l<=9; $l++){
										$id4 = $card[$l];
										if($id4>$var2){
											if($id4-$var2==1){
												$result=true;
											}
										}
										else{
											if($var1-$id4==1){
												$result=true;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}
	
	
	/**
	 * fourIdenticalCardsTest : Contr�le la main d'un joueur afin de v�rifier s'il a quatre cartes identiques
	 * @return vrai ou faux
	 */
	public static function fourIdenticalCardsTest($card){
		// variable � retourner � la fin
		$result = false;
		
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $card[$i];
			if($id1<=5 && $id1>=9)
			{
				for($j=$i+1; $j<=9; $j++)
				{
					$id2 = $card[$j];
					if($id2-$id1 == 9)
					{
						for($k=j+1; $k<=9; $k++){
							$id3 = $card[$k];
							if($id3-$id2==9)
							{
								for($l=$k+1; $l<=9; $l++){
									$id4 = $card[$l];
									if($id4-$id3==9){
										$result=true;
									}
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}
	
	
	/**
	 * fourNineTest : Contr�le la main d'un joueur afin de v�rifier s'il a quatre cartes identiques
	 * @return vrai ou faux
	 */
	public static function fourNineTest($card){
		// variable � retourner � la fin
		$result = false;
		
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $card[$i];
			if($id1==4)
			{
				for($j=$i+1; $j<=9; $j++)
				{
					$id2 = $card[$j];
					if($id2==13)
					{
						for($k=$j+1; $k<=9; $k++){
							$id3 = $card[$k];
							if($id3==22)
							{
								for($l=$k+1; $l<=9; $l++){
									$id4 = $card[$l];
									if($id4==31){
										$result=true;
									}
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}
	
	
	/**
	 * fourNineTest : Contr�le la main d'un joueur afin de v�rifier s'il a quatre cartes identiques
	 * @return vrai ou faux
	 */
	public static function fourValetTest($cards){
		// variable � retourner � la fin
		$result = false;
		
		for($i=1; $i<9; $i++)
		{
			
			echo $cards[$i] + '-';
			
		}
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $cards[$i];
			if($id1==6)
			{
				for($j=$i+1; $j<=9; $j++)
				{
					$id2 = $cards[$j];
					if($id2==15)
					{
						for($k=j+1; $k<=9; $k++){
							$id3 = $cards[$k];
							if($id3==24)
							{
								for($l=$k+1; $l<=9; $l++){
									$id4 = $cards[$l];
									if($id4==33){
										$result=true;
									}
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}
	
	
	/**
	 * stockTest : Contr�le la main d'un joueur afin de v�rifier s'il a quatre cartes identiques
	 * @return vrai ou faux
	 */
	public static function stockTest($card, $asset){
		// variable � retourner � la fin
		$result = false;
		
		switch($asset)
		{
			case 1:
				for ($i=1; $i<=9; $i++)
				{
					$id1 = $card[$i];
					if($id1==7)
					{
						for($j=$i+1; $j<=9; $j++)
						{
							$id2 = $card[$j];
							if($id2==8)
							{
								$result=true;
							}
						}
					}
				}
				break;
			case 2:
				for ($i=1; $i<=9; $i++)
				{
					$id1 = $card[$i];
					if($id1==16)
					{
						for($j=$i+1; $j<=9; $j++)
						{
							$id2 = $card[$j];
							if($id2==17)
							{
								$result=true;
							}
						}
					}
				}
				break;
			case 3:
				for ($i=1; $i<=9; $i++)
				{
					$id1 = $card[$i];
					if($id1==25)
					{
						for($j=$i+1; $j<=9; $j++)
						{
							$id2 = $card[$j];
							if($id2==26)
							{
								$result=true;
							}
						}
					}
				}
				break;
			case 4:
				for ($i=1; $i<=9; $i++)
				{
					$id1 = $card[$i];
					if($id1==34)
					{
						for($j=$i+1; $j<=9; $j++)
						{
							$id2 = $card[$j];
							if($id2==35)
							{
								$result=true;
							}
						}
					}
				}
				break;
		}
		
		return $result;
	}
	
	
	/**
	 * firstPlayerTest : Contrôle la main d'un joueur afin de contrôler s'il possède le 7 de carreau
	 * @return $nrPlayer
	 */
	public static function firstPlayerTest($card, $nrPlayer){
		// variable � retourner � la fin
		$result=0;
		
		for ($i=1; $i<=9; $i++)
		{
			$id1 = $card[$i];
			if($id1==11)
			{
				$result = $nrPlayer;
			}
		}
		
		return $result;
		
	}
	
	
	/**
	 * save : cr�ation d'une nouvelle hand de la donne en cours
	 * PRIV� car il faut utiliser newHands() pour cr�er 4 � la fois
	 * Sauve l'objet <Hand> en cours
	 * @return idHand de la hand cr��e (ok) sinon -1 en cas d'erreur
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