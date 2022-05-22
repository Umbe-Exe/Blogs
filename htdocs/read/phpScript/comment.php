<?php
session_start();

$id = $_GET["id"]; //comment id, or 0 for the comments to the story

if (!is_numeric($id)) die();

if (!isset($_SESSION["offsets"][$id])) $_SESSION["offsets"][$id] = 0;

$mysqli = new mysqli("localhost", "root", "root", "youdream");

if ($id == 0) { 

    $result = $mysqli->query("SELECT id, user_id, text, nreplies FROM comment
    WHERE blog_id = " . $_SESSION["story"] . " AND is_top = 1 
    LIMIT 6 OFFSET " . $_SESSION["offsets"][$id]);
} else { //get the replies

    $result = $mysqli->query("
    SELECT comment.id, comment.user_id, comment.text, comment.nreplies FROM comment
    INNER JOIN comment_has_comment ON comment.id = comment_has_comment.child 
    WHERE comment.blog_id = " . $_SESSION["story"] . " 
    AND comment_has_comment.parent = " . $id . " 
    LIMIT 6 OFFSET " . $_SESSION["offsets"][$id]);
}

if ($result->num_rows == 0) echo "nomore"; //tell client no more rows found

$edit = "";

while ($row = $result->fetch_array()) {

    $user = $mysqli->query("SELECT username FROM user WHERE id = " . $row["user_id"])->fetch_array()[0];

    if (isset($_SESSION["id"]))
        if ($row["user_id"] == $_SESSION["id"]) //its a user's comment
            $edit = '<a href="javascript:edit(' . $row["id"] . ')">edit</a>';
        else $edit = "";

    if ($row["nreplies"] == 0) $reply = "reply";
    else if ($row["nreplies"] == 1) $reply = "1 reply";
    else $reply = $row["nreplies"] . " replies";

    $block = <<<EOD
                <table class="comment" id={$row["id"]}>
                    <tr>
                        <td>
                            <span class="va">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="22px" viewBox="0 0 45.532 45.532" style="enable-background:new 0 0 45.532 45.532;" xml:space="preserve">
                                    <path d="M22.766,0.001C10.194,0.001,0,10.193,0,22.766s10.193,22.765,22.766,22.765c12.574,0,22.766-10.192,22.766-22.765
		                            S35.34,0.001,22.766,0.001z M22.766,6.808c4.16,0,7.531,3.372,7.531,7.53c0,4.159-3.371,7.53-7.531,7.53
		                            c-4.158,0-7.529-3.371-7.529-7.53C15.237,10.18,18.608,6.808,22.766,6.808z M22.761,39.579c-4.149,0-7.949-1.511-10.88-4.012
		                            c-0.714-0.609-1.126-1.502-1.126-2.439c0-4.217,3.413-7.592,7.631-7.592h8.762c4.219,0,7.619,3.375,7.619,7.592
		                            c0,0.938-0.41,1.829-1.125,2.438C30.712,38.068,26.911,39.579,22.761,39.579z">
                                </svg>
                            </span>
                            <span class="name">&nbsp;$user</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="des">{$row["text"]}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        $edit
                        &nbsp;&nbsp;&nbsp;
                        <a href="javascript:reply({$row["id"]})">$reply</a>
                        </td>
                    </tr>
                </table>
EOD;
    echo $block;
}

$_SESSION["offsets"][$id] += 6;
