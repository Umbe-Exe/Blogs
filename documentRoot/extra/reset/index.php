<?php
$mysqli = new mysqli("localhost", "root", "root", "youdream");
$stmt = $mysqli->prepare("
    SELECT email 
    FROM confirmation 
    WHERE secret = ? LIMIT 1");
$stmt->bind_param("s", $_GET["token"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    session_start();
    $_SESSION["email"] = $result->fetch_array()[0];
}
?>

<html>

<head>
    <link rel="stylesheet" href="reset.css">
    <script type="text/javascript" src="reset.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div id="overlay">
        <div id="window">
            <div id="overlay-content">
                <div id="head2">Join now</div>
                <div id="sub">Set a new password.</div>
                <div id="yemail">Your password</div>
                <div class="field">
                    <input id="password" type="password">
                </div>
                <div id=check>
                    <input type="checkbox" id="remember">
                    <label>Remember me</label>
                </div>
                <a class="btn btn2 btn4" href="javascript:join()">Continue</a>
            </div>
        </div>
    </div>
</body>

</html>