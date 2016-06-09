<?php

class Tweet {

    public static function loadAllComments(mysqli $conn, $tweetId) {
        $sql = "SELECT Comment.text, Comment.creation_date, User.fullName, User.id FROM Comment JOIN User ON Comment.user_id = User.id
                WHERE tweet_id = $tweetId ORDER BY Comment.creation_date";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $commentsArray = [];
            while ($row = $result->fetch_assoc()) {
                $commentsArray[] = [$row['fullName'], $row['text'], $row['creation_date'], $row['id']];
            }
            return $commentsArray;
        }
    }

    private $id;
    private $userId;
    private $text;

    function __construct() {
        $this->id = -1;
        $this->userId = 0;
        $this->text = "";
    }

    function getID() {
        return $this->id;
    }

    function setUserID($userId) {
        $this->userId = is_numeric($userId) ? $userId : $this->userId;
    }

    function getUserID() {
        return $this->userId;
    }

    function setText($text) {
        $this->text = is_string($text) ? $text : $this->text;
    }

    function getText() {
        return $this->text;
    }

    function loadFromDB(mysqli $conn, $id) {

        $sql = "SELECT * FROM Tweet WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $rowTweet = $result->fetch_assoc();
            $this->id = $rowTweet['id'];
            $this->userId = $rowTweet['user_id'];
            $this->text = $rowTweet['text'];
        } else {
            return null;
        }
    }

    function saveTweetToDB(mysqli $conn) {
        $sql = "INSERT INTO Tweet (user_id, text) VALUES ('{$this->userId}', '{$this->text}')";
        if ($conn->query($sql)) {
            $this->id = $conn->insert_id;
            return TRUE;
        } else {
            return false;
        }
    }

    function update(mysqli $conn) {

        $sql = "UPDATE Tweet SET user_id = '{$this->userId}' text = '{$this->text}')";

        if ($conn->query($sql)) {
            return TRUE;
        } else {
            return false;
        }
    }

    function show(mysqli $conn, $id) {
        $sql = "SELECT * FROM Tweet WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }

    public function getTweetAuthor(mysqli $conn, $userId) {
        $sql = "SELECT User.fullName FROM User WHERE id='$userId'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }

}
