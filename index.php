<!DOCTYPE html>
<?php
session_start();
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
        require_once './src/User.php';
        require_once './src/Tweet.php';
        require_once './src/connection.php';
        
        $loggedUser = new User();
        $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
        $loggedUserName = $loggedUser->getUserById($conn);
        $loggedUserId= $loggedUserName['id'];
        
        echo "<fieldset><h2>Logged user: {$loggedUserName['fullName']}</h2>";
        echo "<a href='logout.php'>Logout</a></fieldset><br>";
        echo "<br><form method='post'>
                <label>New tweet:</label><br>
                <textarea name='tweet' maxlength='140'></textarea>
                <br>
                <input type='submit' value='Send'>
            </form>";
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            if(!empty($_POST['tweet'])) {
                $text = $_POST['tweet'];
                $userId = $_SESSION['loggedUserId'];
                $newTweet = new Tweet();
                $newTweet->setUserID($userId);
                $newTweet->setText($text);
                $newTweet->saveTweetToDB($conn);  
            }
            else {
                echo("Nie możesz dodać pustego tweeta");
            }
        }
        
        $allTweets = $loggedUser->loadAllTweets($conn);
        echo "<ul>";
        for($i = 0; $i < count($allTweets); $i++) {         
            echo "<li>{$allTweets[$i][1]}<br><a href='tweet_page.php?id={$allTweets[$i][0]}'>Show this tweet</a></li>";  
        }
        echo "</ul><br>";
        echo "<a href='edit_user.php?id={$loggedUserId}'>Edit your personal informations</a><br>";
        echo "<a href='messages_page.php'>Your messages</a>";
        ?>
    </body>
</html>