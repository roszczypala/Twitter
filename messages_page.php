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
        
        <?php
        $loggedUser = new User();
        $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
        $loggedUserName = $loggedUser->getUserById($conn);
        echo "<fieldset><h2>Logged user: {$loggedUserName['fullName']}</h2>";
        echo "<a href='logout.php'>Logout</a></fieldset><br>";
        echo "<h2>Messages send:</h2>";

        $userMessagesSent = $loggedUser->loadAllMessagesSent($conn); 
            echo "<ul>";
            for($i = 0; $i < count($userMessagesSent); $i++) {         
                    echo "<li>Message to:
                    <a href='user_page.php?id={$userMessagesSent[$i][1]}'>{$userMessagesSent[$i][2]}</a>
                    <br> Title: <a href='message_page.php?message_id={$userMessagesSent[$i][0]}&receiver_id={$userMessagesSent[$i][1]}'>{$userMessagesSent[$i][3]}</a>"
                    . "<br>".substr($userMessagesSent[$i][4], 0, 30).(strlen($userMessagesSent[$i][4])>30 ? '...':'')."</li>";  
                    
            }
            echo "</ul>" ;           
            
        echo "<h2>Messages recived:</h2>";   
        
        $userMessagesReceived =$loggedUser->loadAllMessagesReceived($conn); 
            echo "<ul>";
            for($i = 0; $i < count($userMessagesReceived); $i++) {         
                    echo "<li style='".($userMessagesReceived[$i][5]=='1'? '':'font-weight:bold;')."'>Message from:
                    <a href='user_page.php?id={$userMessagesReceived[$i][1]}'>{$userMessagesReceived[$i][2]}</a>
                    <br> Title: <a href='message_page.php?message_id={$userMessagesReceived[$i][0]}&author_id={$userMessagesReceived[$i][1]}'>{$userMessagesReceived[$i][3]}</a>"
                    . "<br>".substr($userMessagesReceived[$i][4], 0, 30).(strlen($userMessagesReceived[$i][4])>30 ? '...':'')."</li></li>";  
            }
            echo "</ul>" ;
            
        echo "<a href='index.php'>Main page </a>";    
        ?>
    </body>
</html>

