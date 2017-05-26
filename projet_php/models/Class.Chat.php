<?php
class Chat{
	private $idChat;
	private $idPart;
	private $idUser;
	private $createdOnAt;
	private $textChat;
	private $username;
	
	public function __construct($idChat=null, $idPart, $idUser, $createdOnAt, $textChat, $username){
		$this->setIdChat($idChat);
		$this->setIdPart($idPart);
		$this->setIdUser($idUser);
		$this->setCreatedOnAt($createdOnAt);
		$this->setTextChat($textChat);
		$this->setUsername($username);
	}
	/**
	 * newChat : cr�ation d'une nouvelle chat
	 * @return id de la chat cr��e (ok) sinon -1 en cas d'erreur
	 */
	public static function newChat($IDPart, $idUser, $textChat){
		
		// insert
		$query = "INSERT INTO chat(IDPart, IdUser, txtChat) VALUES(?, ?, ?);";
		$attributes = array($IDPart, $idUser, $textChat);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error') return -1;
		
		// last insert id
		$idChat= MySqlConn::getInstance()->last_Insert_Id();
		if($idChat< 1) return -1;
		
		return $idChat;
	}
	
	
	/**
	 * getChatsPart : recherche les chats de la partie
	 * @return un tableau de chats de la partie
	 */
	public static function getChatsPart($idPart){
		
		// tableau de chats � retourner
		$chats = array();
		// query select
		$query = "SELECT c.IDChat, c.IDPart, c.IdUser, c.createdOnAt, c.txtChat, u.username
				FROM chat c, user u
				WHERE IDPart = ?
                AND c.IdUser = u.id
				ORDER BY createdOnAt,idChat ;";
		
		$attributes = array($idPart);
		$result = MySqlConn::getInstance()->execute($query, $attributes);
		if($result['status']=='error' || empty($result['result']))
			return false;
			//
			foreach ($result['result'] as $res_chat){
				
				$chats[] = new Chat($res_chat['IDChat'], $res_chat['IDPart'], $res_chat['IdUser'], $res_chat['createdOnAt'], $res_chat['txtChat'], $res_chat['username']);
	
			}
			return $chats;
	}
	
	/**
	 * Getter and setter
	 */
	public function getUsername(){
		return $this->username;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}
	
	public function getIdChat(){
		return $this->idChat;
	}
	
	public function setIdChat($idChat){
		$this->idChat = $idChat;
	}
	
	public function getIdPart(){
		return $this->idPart;
	}
	
	public function setIdPart($idPart){
		$this->idPart = $idPart;
	}
	
	public function getIdUser(){
		return $this->idUser;
	}
	
	public function setIdUser($idUser){
		$this->idUser = $idUser;
	}
	
	public function getCreatedOnAt(){
		return $this->createdOnAt;
	}
	
	public function setCreatedOnAt($createdOnAt){
		$this->createdOnAt= $createdOnAt;
	}
	
	public function getTxtChat(){
		return $this->textChat;
	}
	
	public function setTextChat($textChat){
		$this->textChat= $textChat;
	}
}