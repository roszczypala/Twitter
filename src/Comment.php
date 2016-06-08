<?php
class Comment {
    
    private $id;
    private $tweetId;
    private $userId;
    private $creationDate;
    private $text;
    
    function __construct() {
        $this->id = -1;
        $this->tweetId = 0;
        $this->userId = 0;
        $this->creationDate = "";
        $this->text = "";
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }
    
    public function getTweetId() {
        return $this->tweetId;
    }
    
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function setText($text) {
        $this->text = $text;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function loadFromDB(mysqli $conn, $id) {
        $sql = "SELECT * FROM Comment WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($rowComment = $result->fetch_assoc()) {
                $this->id = $rowComment['id'];
                $this->tweetId = $rowComment['tweet_id'];
                $this->userId = $rowComment['user_id'];
                $this->creationDate = $rowComment['creation_date'];
                $this->text = $rowComment['text'];
            }
        }
    }
    
    function saveCommentToDB(mysqli $conn) {
        $sql = "INSERT INTO Comment (tweet_id, user_id, creation_date, text) VALUES ('{$this->tweetId}', '{$this->userId}', '{$this->creationDate}', '{$this->text}')";
        if($conn->query($sql)) {
            $this->id = $conn->insert_id;
            return TRUE;
        }
        else {
            return false;
        }
    }
}
