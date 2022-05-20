<?php
session_start();

if (!(isset($_SESSION["id"]) && isset($_SESSION["story"]))) {
    echo "cant";
    die();
}

$mysqli = new mysqli("localhost", "root", "root", "youdream");

$following =  $mysqli->query("SELECT EXISTS(SELECT * FROM subscription 
WHERE subscriptor_id = " . $_SESSION["id"] . " AND user_id = " . $_SESSION["writer"] . ")")->fetch_array()[0];

if ($following) {
    $mysqli->query("DELETE FROM subscription 
    WHERE subscriptor_id = " . $_SESSION["id"] . " AND user_id = " . $_SESSION["writer"]);

    echo "ok";
}
