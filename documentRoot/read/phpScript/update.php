<?php
session_start();

if (!is_numeric($_POST["yours"]) || $_SESSION["csrf"] != $_POST["csrf"]) die();

$mysqli = new mysqli("localhost", "root", "root", "youdream");

$user = $mysqli->query("SELECT user_id FROM comment WHERE id = " . $_POST["yours"])->fetch_array()[0];

if ($user != $_SESSION["id"]) die();

$mysqli->query("UPDATE comment SET text = '" . $_POST["text"] . "' WHERE id = " . $_POST["yours"]);
