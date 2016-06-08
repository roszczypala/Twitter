<?php
session_start();   
require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/Message.php';
require_once './src/connection.php';

if(!isset($_SESSION['loggedUserId'])) {
    header("Location: login.php");    
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>        
    <?php
        $loggedUser = new User();
        $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
        $loggedUserName = $loggedUser->getUserById($conn);
        echo "<fieldset><h2>Logged user: {$loggedUserName['fullName']}</h2>";
        echo "<a href='logout.php'>Logout</a></fieldset><br>";
        
        echo "<h2>Message:</h2>";
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $message = Message::getMessageById($conn, $_GET['message_id']);
        echo "<h2>Title: {$message['title']}</h2><p>{$message['text']}</p>";

        if(isset($_GET['author_id'])) {
            $author=new User();
            $authorId=$author->getUserById($conn);     
            Message::setAsRead($conn, $_GET['message_id'],$_GET['author_id']);
            echo "<h2>Author: {$authorId['fullName']}</h2>";
        }

        if(isset($_GET['receiver_id'])) {
            $recipient = new User();
            $recipientId= $recipient->getUserById($conn);
            echo "<h2>Recipient: {$recipientId['fullName']}</h2>";
        }
    }
    ?>
        <a href='messages_page.php'>All messages page...</a>
    </body>
</html>
