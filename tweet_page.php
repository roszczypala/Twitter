<!DOCTYPE html>
<?php
session_start();
require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/Comment.php';
require_once './src/connection.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_GET['id'])) {
            $tweetId = $_GET['id'];
            $tweet = new Tweet();
            $tweetShow = $tweet->show($conn, $tweetId);
            $tweetUserId = $tweetShow['user_id'];
            $tweetAuthor = $tweet->getTweetAuthor($conn, $tweetUserId);

            $loggedUser = new User();
            $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
            $loggedUserName = $loggedUser->getUserById($conn);
            $loggedUserId = $loggedUserName['id'];

            echo "<fieldset><h2>Logged user: {$loggedUserName['fullName']}</h2>";
            echo "<a href='logout.php'>Logout</a></fieldset><br>";
            echo "<h3>{$tweetAuthor['fullName']}'s tweets:</h3>";
            echo "<div>{$tweetShow['text']}</div>";

            $tweetComments = $tweet->loadAllComments($conn, $tweetId);
            echo "<h4>Comments:</h4>";
            echo "<dl>";
            for ($i = 0; $i < count($tweetComments); $i++) {
                echo "<dt><a href='user_page.php?id={$tweetComments[$i][3]}'> {$tweetComments[$i][0]}</a> <br> {$tweetComments[$i][2]}</dt>";
                echo "<dd>{$tweetComments[$i][1]}</dd>";
            }
            echo "</dl>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['comment'])) {
                $newComment = new Comment();
                $newComment->setTweetId($_GET['id']);
                $newComment->setUserId($_SESSION['loggedUserId']);
                $newComment->setCreationDate(date('Y-m-d G:i'));
                $newComment->setText($_POST['comment']);
                $newComment->saveCommentToDB($conn);
                echo "Comment added";
            } else {
                echo "Empty comment, please write sth to add a comment";
            }
        }
        ?>
        <form method="POST">
            <textarea maxlength="100" name="comment"></textarea>
            <br>
            <input type="submit" value="Comment">
        </form>

        <?php
        echo "<a href='index.php'>Main page</a><br>";
        echo "<a href='user_page.php?id={$tweetUserId}'>User's page</a>";
        ?>
    </body>
</html>

