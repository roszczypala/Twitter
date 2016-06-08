<?php
session_start();   
require_once './src/User.php';
require_once './src/Tweet.php';
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

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userFromGet = new User();
            $userFromGet->loadFromDB($conn, ($_GET['id']));
            $userFromGetInfo=$userFromGet->getUserById($conn);
            $userFromGetId= $_GET['id'];

            echo "<fieldset><h2>{$userFromGetInfo['fullName']}`s page</h2></fieldset><br>";
            echo "<h2>{$userFromGetInfo['fullName']}'s tweets:</h2><br>";

            $allTweets = $userFromGet->loadAllTweets($conn);
            echo "<ul>";
            for($i = 0; $i < count($allTweets); $i++) {         
                echo "<li>{$allTweets[$i][1]}<br><a href='tweet_page.php?id={$allTweets[$i][0]}'>Show this tweet</a></li>";
                $tweetComments = Tweet::loadAllComments($conn, $allTweets[$i][0]);
                echo"<br>Number of comments:<br>";
                echo(count($tweetComments));
                echo "<br>";
                
            }  
            echo  "<a href='create_message.php?recieverId={$userFromGetId}'>Send message</a><br>";
        }    
        ?>
        <br><a href='index.php'>Main page</a>
    </body>
</html>