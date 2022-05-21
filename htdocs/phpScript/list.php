<?php
session_start();

$what = $_GET["what"];

if ($_SESSION["what"] != $what) {
    $_SESSION["what"] = $what;
    $_SESSION["offset"] = 0;
}

$mysqli = new mysqli("localhost", "root", "root", "youdream");

if ($_SESSION["what"] == "rand") {
    $result = $mysqli->query("
            SELECT user.username, blog.id, blog.title, blog.time_stamp, blog.desc
            FROM blog
            INNER JOIN user ON user.id = blog.user_id
            WHERE NOT EXISTS (SELECT blog_id FROM blog_confirm WHERE blog_id = blog.id)
            ORDER BY blog.time_stamp DESC
            LIMIT 6 OFFSET " . $_SESSION["offset"]);
} else {
    $stmt = $mysqli->prepare("
    SELECT user.username, blog.id, blog.title, blog.time_stamp, blog.desc
            FROM blog
            INNER JOIN user ON user.id = blog.user_id
            INNER JOIN blog_has_tag ON blog.id = blog_has_tag.blog_id
            WHERE blog_has_tag.tag_id = ? AND 
            NOT EXISTS (SELECT blog_id FROM blog_confirm WHERE blog_id = blog.id)
            ORDER BY blog.time_stamp DESC
            LIMIT 6 OFFSET " . $_SESSION["offset"]);
    $stmt->bind_param("i", $_SESSION["what"]);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result->num_rows == 0) echo "nomore";

date_default_timezone_set("Europe/Rome");
while ($row = $result->fetch_array()) {
    if ($image = file_get_contents("/storage/emulated/0/READY/" . $row["id"] . "/url.txt"))
        $image = '<img class="img" src="' . $image . '">';
    else $image = "";

    $when = new DateTime($row["time_stamp"]);
    $diff = time() - strtotime($row["time_stamp"]);

    if ($diff < 60) $date = $diff . " second" . ($diff == 1 ? "" : "s") . " ago";
    else if ($diff < 3600) $date = round($diff / 60) . " minute" . (round($diff / 60) == 1 ? "" : "s") . " ago";
    else if ($diff < 86400) $date = round($diff / 3600) . " hour" . (round($diff / 3600) == 1 ? "" : "s") . " ago";
    else if ($diff < 604800) $date = round($diff / 86400) . " day" . (round($diff / 86400) == 1 ? "" : "s") . " ago";
    else if ($diff < 31536000) $date = date_format($when, "M d");
    else $date = date_format($when, "M d Y");

    $block = <<<EOD
                <a class="paddup" href="https://www.umbe.website/read?story={$row["id"]}">
                <table>
                    <tr>
                        <td class="info">
                            <span class="va">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="22px" viewBox="0 0 45.532 45.532" style="enable-background:new 0 0 45.532 45.532;" xml:space="preserve">
                                    <path d="M22.766,0.001C10.194,0.001,0,10.193,0,22.766s10.193,22.765,22.766,22.765c12.574,0,22.766-10.192,22.766-22.765
		                            S35.34,0.001,22.766,0.001z M22.766,6.808c4.16,0,7.531,3.372,7.531,7.53c0,4.159-3.371,7.53-7.531,7.53
		                            c-4.158,0-7.529-3.371-7.529-7.53C15.237,10.18,18.608,6.808,22.766,6.808z M22.761,39.579c-4.149,0-7.949-1.511-10.88-4.012
		                            c-0.714-0.609-1.126-1.502-1.126-2.439c0-4.217,3.413-7.592,7.631-7.592h8.762c4.219,0,7.619,3.375,7.619,7.592
		                            c0,0.938-0.41,1.829-1.125,2.438C30.712,38.068,26.911,39.579,22.761,39.579z">
                                </svg>
                            </span>
                            <span class="name">&nbsp;{$row["username"]}</span>

                            <div class="tit">{$row["title"]}</div>
                            <div class="des">{$row["desc"]}</div>
                            <div class="dat">$date</div>
                        </td>
                        <td class="colspace"></td>
                        <td>
                        $image
                        </td>
                    </tr>
                </table>
            </a>
EOD;
    echo $block;
}

$_SESSION["offset"] += 6;
