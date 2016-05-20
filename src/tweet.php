<?php

class Tweet {
    private $id;
    private $user_id;
    private $text;
    
    	public function __construct() {
		$this->id = -1;
		$this->user_id = 0;
		$this->text = '';
	}
        
        public function getId(){
            return $this->id;
        }
        
        public function getUserId(){
            return $this->user_id;
        }
        
        public function getText(){
            return $this->text;
        }
        
        public function setUserId($user_id){
            $this->user_id = is_numeric($user_id)? $user_id >0 :$this->user_id;
        }
        
        public function setText($text){
            $this->text = is_string($text)? trim($text) : $this->text;
        }
        
        public function loadFromDB(mysqli $conn,$id){
            $sql = "SELECT * FROM User WHERE id = $id";
            $result = $conn->query($sql);
            if($result->num_rows == 1){
               $rowUser = $result->fetch_assoc();
               $this->id = $rowUser['id'];
               $this->email = $rowUser['email'];
               $this->password = $rowUser['password'];
               $this->fullName =$rowUser['fullName'];
               $this->active = $rowUser['active'];
            }
            return null;
        }
        
}

