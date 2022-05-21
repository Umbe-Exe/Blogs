<?php
session_start();

if (!(isset($_SESSION["id"]) && isset($_SESSION["story"]))) {
    echo "cant";
    die();
}

$mysqli = new mysqli("localhost", "root", "root", "youdream");

$like =  $mysqli->query("SELECT EXISTS(SELECT * FROM liked 
WHERE user_id = " . $_SESSION["id"] . " AND blog_id = " . $_SESSION["story"] . ")")->fetch_array()[0];
$dislike =  $mysqli->query("SELECT EXISTS(SELECT * FROM disliked 
WHERE user_id = " . $_SESSION["id"] . " AND blog_id = " . $_SESSION["story"] . ")")->fetch_array()[0];

if ($dislike) {
    $mysqli->query("DELETE FROM disliked 
    WHERE user_id = " . $_SESSION["id"] . " AND blog_id = " . $_SESSION["story"]);

    $mysqli->query("UPDATE blog SET dislikes = dislikes-1 WHERE id = " . $_SESSION["story"]);
} else {
    $mysqli->query("INSERT INTO disliked (user_id, blog_id) 
    VALUES (" . $_SESSION["id"] . ", " . $_SESSION["story"] . ")");

    if ($like) {
        $mysqli->query("DELETE FROM liked 
        WHERE user_id = " . $_SESSION["id"] . " AND blog_id = " . $_SESSION["story"]);

        $mysqli->query("UPDATE blog SET dislikes = dislikes+1, likes = likes-1 WHERE id = " . $_SESSION["story"]);
    } else $mysqli->query("UPDATE blog SET dislikes = dislikes+1 WHERE id = " . $_SESSION["story"]);

    echo "disliked";
}
