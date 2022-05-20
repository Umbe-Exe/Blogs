<?php
session_start();

if (isset($_SESSION["id"]));
else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) echo "invalid";
else {
    $mysqli = new mysqli("localhost", "root", "root", "youdream");
    $stmt = $mysqli->prepare("
    SELECT id, username, password 
    FROM user 
    WHERE email = ?");
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($_POST["password"], $row["password"])) {

            $_SESSION["id"] = $row["id"];
            $_SESSION["name"] = $row["username"];

            if ($_POST["remember"] == "on" || $_POST["remember"] == "true" || $_POST["remember"] == "1") {
                $secret = md5(uniqid(mt_rand(), true));

                $mysqli->query("
                INSERT INTO session (user_id, secret) VALUES (" . $_SESSION["id"] . ", '" . $secret . "')
                ON DUPLICATE KEY UPDATE secret = '" . $secret . "'");
                setcookie("longsession", $secret, time() + 604800, "/", null, null, true);
            }

            echo "ok";
        } else echo "noexist";
    } else echo "noexist";
}
