<?php session_start();

if (!isset($_SESSION["id"])) die();

$mysqli = new mysqli("localhost", "root", "root", "youdream");
$stmt = $mysqli->prepare("
    UPDATE user 
    SET username = ?
    WHERE id = ?");
$stmt->bind_param("ss", $_POST["name"], $_SESSION["id"]);
$stmt->execute();

if (mysqli_affected_rows($mysqli) == 0) echo "exist";
