<?php session_start();
if (!isset($_SESSION["id"]) || $_SESSION["csrf"] != $_POST["csrf"]) die();

$story = $_POST["story"];
$title = htmlspecialchars($_POST["title"]);
$desc = htmlspecialchars($_POST["desc"]);
$tags = $_POST["tags"];
$url = $_POST["url"];

if ($title != "") $story .= "\r\n<div>Title: " . $title . "</div>"; //append the metadata
if ($desc != "") $story .= "\r\n<div>Description: " . $desc . "</div>";
if ($tags != "") $story .= "\r\n<div>Tags: " . $tags . "</div>";
if ($url != "") $story .= "\r\n<div>Url: " . $url . "</div>";

date_default_timezone_set("Europe/Rome");
$name = "Draft_" . date('dmYHis');
$fileLocation = "/storage/emulated/0/htdocs/editor/RFM/source/" . $_SESSION["id"] . "/" . $name . ".html";

$dirname = dirname($fileLocation);
if (!is_dir($dirname)) mkdir($dirname);

$file = fopen($fileLocation, "w");
fwrite($file, $story);
fclose($file);

echo $name;
