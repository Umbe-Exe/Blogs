<?php
session_start();

if (isset($_SESSION["id"]));
else if (isset($_SESSION["email"]))
    if (strlen($_POST["password"]) >= 8) {

        $mysqli = new mysqli("localhost", "root", "root", "youdream");
        $mysqli->query("DELETE FROM confirmation WHERE email = '" . $_SESSION["email"] . "'");

        $mysqli->query("INSERT INTO user (email, password, username) VALUES 
    ('" . $_SESSION["email"] . "', '" . password_hash($_POST["password"], PASSWORD_DEFAULT) . "', '" . $_SESSION["email"] . "')
    ON DUPLICATE KEY UPDATE password = '" . password_hash($_POST["password"], PASSWORD_DEFAULT) . "'");

        $_SESSION["id"] =
            $mysqli->query("SELECT id FROM user WHERE email = '" . $_SESSION["email"] . "'")->fetch_array()[0];
        $_SESSION["name"] = $_SESSION["email"];

        if ($_POST["remember"] == "on" || $_POST["remember"] == "true" || $_POST["remember"] == "1") {
            $secret = md5(uniqid(mt_rand(), true));

            $mysqli->query("
            INSERT INTO session (user_id, secret) VALUES (" . $_SESSION["id"] . ", '" . $secret . "')
            ON DUPLICATE KEY UPDATE secret = '" . $secret . "'");
            setcookie("longsession", $secret, time() + 604800, "/", null, null, true);
        }

        unset($_SESSION["email"]);

        echo "ok";
    } else echo "invalid";
