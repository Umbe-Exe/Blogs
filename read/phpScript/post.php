<?php
session_start();

$replyto = $_POST["replyto"];
$text = $_POST["text"];

if (!isset($_SESSION["id"])) {
    echo "cant";
    die();
}
if (!is_numeric($replyto) || $_SESSION["csrf"] != $_POST["csrf"]) die();

$mysqli = new mysqli("localhost", "root", "root", "youdream");

if ($replyto == 0) {
    $stmt = $mysqli->prepare("INSERT INTO comment (user_id, blog_id, text) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $_SESSION["id"], $_SESSION["story"], $text);
    $stmt->execute();

    echo $stmt->insert_id;
} else {
    $stmt = $mysqli->prepare("INSERT INTO comment (user_id, blog_id, text, is_top) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("iis", $_SESSION["id"], $_SESSION["story"], $text);
    $stmt->execute();

    $mysqli->query("UPDATE comment SET nreplies = nreplies+1 WHERE id = " . $replyto);

    $mysqli->query("INSERT INTO comment_has_comment (parent, child) VALUES (" . $replyto . ", " . $stmt->insert_id . ")");

    echo $stmt->insert_id;
}
