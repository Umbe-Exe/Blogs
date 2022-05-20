<?php
if (isset($_SESSION["id"]));
else if (isset($_COOKIE["longsession"])) {

    $result = $mysqli->query("
    SELECT session.user_id, user.username FROM session 
    INNER JOIN user ON user.id = session.user_id
    WHERE secret = '" . $_COOKIE["longsession"] . "'")->fetch_assoc();
    $_SESSION["id"] = $result["user_id"];
    $_SESSION["name"] = $result["username"];
}
