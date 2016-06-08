<!DOCTYPE html>
<?php
session_start();   
require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/Message.php';
require_once './src/connection.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="POST">
            Title:
            <br>
            <input type="text" name="title"><br>
            Message:
            <br>
            <textarea name="message"></textarea><br>
            <input type="submit" value="Send">
        </form>
        <?php
            $authorId = $_SESSION['loggedUserId'];
            
//            var_dump($authorId);
            
            if(isset($_GET['recieverId'])) {
                $receiverId = $_GET['recieverId'];
            }

//            var_dump($receiverId);
        
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                if(!empty($_POST['message']) && !empty($_POST['title'])) {
                    $title = $_POST['title'];
                    $text = $_POST['message']; 
                    
                    $newMessage = new Message();
                    $newMessage->setAuthorId($authorId);
                    $newMessage->setReceiverId($receiverId);
                    $newMessage->setTitle($title);
                    $newMessage->setText($text);
                    $newMessage->setStatus(0);
                    $newMessage->saveMessageToDB($conn);
                    echo("Message sent");
                    header("Location: messages_page.php");
                }else{
                    echo("You can't send empty message");
                }
            }
        ?>
    </body>
</html>
