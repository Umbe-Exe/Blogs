<?php
session_start();

if (
    !isset($_SESSION["id"]) ||
    $_SESSION["csrf"] != $_POST["csrf"] ||
    $_SESSION["writer"] != $_SESSION["id"]
) die();

$mysqli = new mysqli("localhost", "root", "root", "youdream");

$mysqli->query("DELETE FROM blog WHERE id = " . $_SESSION["story"]); //it will cascade to the comments aswell, as to database configuration

$dir = "/storage/emulated/0/READY/" .  $_SESSION["story"];
array_map('unlink', glob($dir."/*.*"));
rmdir($dir);

