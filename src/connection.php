<?php

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "twitter";

$conn = new mysqli($servername, $username, $password, $baseName);

if ($conn->connect_error) {
    die("Połączenie nieudane. Błąd: " . $conn->connect_error);
} else {
    $conn->set_charset("utf8");
    date_default_timezone_set("Europe/Warsaw");
}

