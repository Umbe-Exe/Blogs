<?php session_start();

if ($_SESSION["csrf"] != $_POST["csrf"]) die();

$title = htmlspecialchars($_POST["title"]);
$desc = htmlspecialchars($_POST["desc"]);

$mysqli = new mysqli("localhost", "root", "root", "youdream");
$stmt = $mysqli->prepare("INSERT INTO blog (user_id, title, `desc`) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $_SESSION["id"], $title, $desc);
$stmt->execute();

$blog_id = $stmt->insert_id;

$secret = md5(uniqid(mt_rand(), true)); //to be confirmed
$mysqli->query("INSERT INTO blog_confirm (blog_id, secret) VALUES (" . $blog_id . ", '" . $secret . "')");

$fileLocation = "/storage/emulated/0/AWAIT/" . $blog_id . "/blog.txt";

$dirname = dirname($fileLocation);
if (!is_dir($dirname)) mkdir($dirname, 0755, true);

$file = fopen($fileLocation, "w");
fwrite($file, $_POST["story"]);
fclose($file);
$fileLocation = "/storage/emulated/0/AWAIT/" . $blog_id . "/url.txt";
$file = fopen($fileLocation, "w");
fwrite($file, $_POST["url"]);
fclose($file);

//tags are separated by a space and are turned to lowercase
$tags = explode(" ", strtolower($_POST["tags"]));

$query = "INSERT INTO tag (name) VALUES";
for ($i = 0; $i < count($tags); $i++) {
    if (ctype_alnum($tags[$i]) && strlen($tags[$i]) <= 16) //cant have special characters, cant be too long
        $query .= " ('" . $tags[$i] . "'),"; //the last comma will be removed
    else { 
        unset($tags[$i]);
        $tags = array_values($tags);
        $i--;
    }
}

if (count($tags) > 0) {
    $mysqli->query(substr($query, 0, strlen($query) - 1) . " ON DUPLICATE KEY UPDATE id=id"); //insert, if exists do nothing
    $query = "SELECT id FROM tag WHERE name = '" . $tags[0] . "'"; //i want to know the ids of those tags
    if (count($tags) > 1)
        for ($i = 1; $i < count($tags); $i++) $query .= " OR name = '" . $tags[$i] . "'";
    $result = $mysqli->query($query);

    $query = "INSERT INTO blog_has_tag (blog_id, tag_id) VALUES"; //i want to tie them to the submitted story
    while ($row = $result->fetch_array()) {
        $query .= " (" . $blog_id . ", " . $row[0] . "),";
    }
    $mysqli->query(substr($query, 0, strlen($query) - 1));
}

$to      = $mysqli->query("SELECT email FROM user WHERE id = " . $_SESSION["id"])->fetch_array()[0];
$subject = 'Story submission';
$headers = 'From: "Brand" <webmaster@umbe.website>' . "\r\n" .
    'Reply-To: webmaster@umbe.website' . "\r\n" .
    'MIME-Version: 1.0' . "\r\n" .
    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$message =
    <<<EOD
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0 auto !important;padding: 0 !important;height: 100% !important;width: 100% !important;">
<head style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <title style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Verify your email!</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    <meta charset="utf-8" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"> <!-- Tell iOS not to automatically link certain text strings. -->

    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
    <![endif]-->

</head>

<body width="100%" style="margin: 0 auto !important;padding: 0 !important;background: #f3f3f5;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100% !important;width: 100% !important;">
    <center style="width: 100%;background: #f3f3f5;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f3f3f5;">
    <tr>
    <td>
    <![endif]-->
    <div style="display: none;font-size: 1px;line-height: 1px;max-height: 0px;max-width: 0px;opacity: 0;overflow: hidden;mso-hide: all;font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    </div>

        <div class="email-container" style="max-width: 680px;margin: 0 auto;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
            <!--[if mso]>
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="680" align="center">
            <tr>
            <td>
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 680px;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">

                <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                    <td style="padding: 20px 30px;text-align: left;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;" class="sm-px">
                        <a href="https://www.umbe.website" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;text-decoration: none;">
                            <h1 border="0" height="36" width="146" style="display: block;line-height: 15px;color: black;margin: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Brand</h1>
                        </a>
                    </td>
                </tr>
                
                <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                    <td style="padding: 30px;background-color: #ffffff;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border-radius: 5px;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;" class="sm-p bar">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                            <!-- Rich Text : BEGIN -->
                            <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <td style="padding-bottom: 15px;font-family: arial, sans-serif;font-size: 15px;line-height: 21px;color: #3C3F44;text-align: left;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                    <h1 style="font-weight: bold;font-size: 27px;line-height: 27px;color: #0C0D0E;margin: 0 0 15px 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">$title</h1>
                                    <p style="margin: 0 0 15px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="has-markdown">$desc</p>
                                </td>
                            </tr>
                            <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <td style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                    <!-- Button : BEGIN -->
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                        <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <td class="s-btn s-btn__primary" style="border-radius: 4px;background: #0095ff;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                                <a class="s-btn s-btn__primary" href="https://www.umbe.website/extra/blog?token=$secret" target="_parent" style="background: #0095FF;border: 1px solid #0077cc;box-shadow: inset 0 1px 0 0 rgba(102,191,255,.75);font-family: arial, sans-serif;font-size: 17px;line-height: 17px;color: #ffffff;text-align: center;text-decoration: none;padding: 13px 17px;display: block;border-radius: 4px;white-space: nowrap;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Confirm submission</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </center>
</body>
</html>
EOD;
mail($to, $subject, $message, $headers);
