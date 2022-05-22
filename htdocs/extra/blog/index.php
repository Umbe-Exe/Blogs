<?php

$mysqli = new mysqli("localhost", "root", "root", "youdream");
$stmt = $mysqli->prepare("
    SELECT blog_id 
    FROM blog_confirm 
    WHERE secret = ? LIMIT 1");
$stmt->bind_param("s", $_GET["token"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $blog_id = $result->fetch_array()[0];
    $mysqli->query("DELETE FROM blog_confirm WHERE blog_id = '" . $blog_id . "'");

    $dirname = dirname("/storage/emulated/0/READY/" . $blog_id);
    if (!is_dir($dirname)) mkdir($dirname, 0755, true);

    rename("/storage/emulated/0/AWAIT/" . $blog_id, "/storage/emulated/0/READY/" . $blog_id);

    $mysqli->query("UPDATE blog SET time_stamp = CURRENT_TIMESTAMP() WHERE id = " . $blog_id);

    $result = $mysqli->query("
        SELECT user.email
        FROM user
        INNER JOIN subscription ON subscription.subscriptor_id = user.id
        INNER JOIN blog ON blog.user_id = subscription.user_id
        WHERE blog.id = " . $blog_id); //all the followers' mail

    $writer = $mysqli->query("
        SELECT user.username, blog.title, blog.desc
        FROM user
        INNER JOIN blog ON blog.user_id = user.id
        WHERE blog.id = " . $blog_id)->fetch_assoc(); //the writer username and blog title, description

    $headers = 'From: "Brand" <webmaster@umbe.website>' . "\r\n" .
        'Reply-To: webmaster@umbe.website' . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    while ($row = $result->fetch_array()) { //all the followers to notify

        $to      = $row["email"];
        $subject = $writer["username"] . ' has published a new story!';
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
    Welcome to Brand, get access to a vast community of writers NOW!
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
                                    <h1 style="font-weight: bold;font-size: 27px;line-height: 27px;color: #0C0D0E;margin: 0 0 15px 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">{$writer["title"]}</h1>
                                    <p style="margin: 0 0 15px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="has-markdown">{$writer["desc"]}</p>
                                </td>
                            </tr>
                            <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <td style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                    <!-- Button : BEGIN -->
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                        <tr style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                            <td class="s-btn s-btn__primary" style="border-radius: 4px;background: #0095ff;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt !important;mso-table-rspace: 0pt !important;">
                                                <a class="s-btn s-btn__primary" href="https://www.umbe.website/read?story=$blog_id" target="_parent" style="background: #0095FF;border: 1px solid #0077cc;box-shadow: inset 0 1px 0 0 rgba(102,191,255,.75);font-family: arial, sans-serif;font-size: 17px;line-height: 17px;color: #ffffff;text-align: center;text-decoration: none;padding: 13px 17px;display: block;border-radius: 4px;white-space: nowrap;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Open</a>
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
    }

    echo "Thanks";
} else echo "Nope"; //wrong token
