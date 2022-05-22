<?php session_start();

if ($_SESSION["csrf"] != $_POST["csrf"]) die();

$title = htmlspecialchars($_POST["title"]);
$desc = htmlspecialchars($_POST["desc"]);

$blog_id = $_SESSION["story"];

$mysqli = new mysqli("localhost", "root", "root", "youdream");
$stmt = $mysqli->prepare("
UPDATE blog
SET title = ?, `desc` = ?
WHERE id = " . $blog_id);
$stmt->bind_param("ss", $title, $desc);
$stmt->execute();

$fileLocation = "/storage/emulated/0/READY/" . $blog_id . "/blog.txt";

$dirname = dirname($fileLocation);
if (!is_dir($dirname)) mkdir($dirname, 0755, true);

$file = fopen($fileLocation, "w");
fwrite($file, $_POST["story"]);
fclose($file);
$fileLocation = "/storage/emulated/0/READY/" . $blog_id . "/url.txt";
$file = fopen($fileLocation, "w");
fwrite($file, $_POST["url"]);
fclose($file);

$tags = explode(" ", strtolower($_POST["tags"]));

$query = "INSERT INTO tag (name) VALUES";
for ($i = 0; $i < count($tags); $i++) {
    if (ctype_alnum($tags[$i]) && strlen($tags[$i]) <= 16)
        $query .= " ('" . $tags[$i] . "'),";
    else {
        unset($tags[$i]);
        $tags = array_values($tags);
        $i--;
    }
}

if (count($tags) > 0) {
    $mysqli->query(substr($query, 0, strlen($query) - 1) . " ON DUPLICATE KEY UPDATE id=id");

    $query = "SELECT id FROM tag WHERE name = '" . $tags[0] . "'";
    for ($i = 1; $i < count($tags); $i++) $query .= " OR name = '" . $tags[$i] . "'";
    $result = $mysqli->query($query);

    $query = "INSERT INTO blog_has_tag (blog_id, tag_id) VALUES";
    while ($row = $result->fetch_array())
        $query .= " (" . $blog_id . ", " . $row[0] . "),";

    $mysqli->query(substr($query, 0, strlen($query) - 1) . " ON DUPLICATE KEY UPDATE blog_id=blog_id"); //if tag already tied do nothing
}
