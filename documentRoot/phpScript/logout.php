<?php
session_start();

setcookie("longsession", "", 0, "/");

$mysqli = new mysqli("localhost", "root", "root", "youdream");
$mysqli->query("DELETE FROM session WHERE user_id = " . $_SESSION["id"]);

session_unset();

header("Location: ../");
