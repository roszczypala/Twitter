<?php
class Message {
    
    public static function getMessageById(mysqli $conn, $id) {
        $sql="SELECT * FROM Messages WHERE id = '$id'";
        
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return false;
        }
    }
    
    private $id;
    private $authorId;
    private $receiverId;
    private $title;
    private $text;
    private $status;
    private $date;
            
    function __construct() {
        $this->id = -1;
        $this->authorId = 0;
        $this->receiverId = 0;
        $this->title = "";
        $this->text = "";
        $this->status = 0;
        $d=new DateTime('NOW');
        $this->date= $d->format('Y-m-d H:i:s');
    }
        
    public function getId() {
        return $this->id;
    }
    
    public function setAuthorId($authorId) {
        $this->authorId = $authorId;
    }
    
    public function getAuthorId() {
        return $this->authorId;
    }
    
    public function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }
    
    public function getReceiverId() {
        return $this->receiverId;
    }
    
    function getTitle() {
        return $this->title;
    }
    function setTitle($title) {
        $this->title = $title;
    }
    
    function setText($text) {
        $this->text = $text;
    }
    
    function getText() {
        return $this->text;
    }
    
    function statusRead () {
        $this->status = 1;
    }
    
    function getStatus() {
        return $this->status;
    }
    
    function setStatus($status) {
        $this->status = $status;
    }
    function getDate() {
        return $this->date;
    }
    static function setAsRead(mysqli $conn, $mid, $aid){
        
        $sql = "UPDATE Messages SET status = '1' WHERE id={$mid} AND author_id={$aid}";
        $conn->query($sql);
    }

        
    function saveMessageToDB(mysqli $conn) {
        $sql = "INSERT INTO Messages (author_id, receiver_id, title, text, status, date) VALUES ('{$this->authorId}', '{$this->receiverId}', '{$this->title}', '{$this->text}', '{$this->status}','{$this->date}')";
        if($conn->query($sql)) {
            $this->id = $conn->insert_id;
            return TRUE;
        }
        else {
            return false;
        }
    }
    
    function loadFromDB(mysqli $conn, $id) {
        
        $sql = "SELECT * FROM Messages WHERE id=$id";
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $rowMessage = $result->fetch_assoc();
            $this->id = $rowMessage['id'];
            $this->authorId = $rowMessage['author_id'];
            $this->receiverId = $rowMessage['receiver_id'];
            $this->title = $rowMessage['title'];
            $this->text = $rowMessage['text'];
            $this->status = $rowMessage['status'];
            $this->date = $rowMessage['date'];
            
        }
        else {
            return null;
        }
    }
    
}


