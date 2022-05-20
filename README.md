# ?Brand?

## A platform for blogging

Stable with both PHP 8.1.2 and PHP 7.4.3, other versions might give some problems.

###### These are the locations of the URLs you might want to change:

```
index.js:
  142:                 window.location.replace("https://www.umbe.website");

index.php:
   24:             <a href="https://www.umbe.website">
  195:             <a href="https://www.umbe.website/read?story={$row["id"]}">

editing\editing.js:
  38:         window.location.replace("https://www.umbe.website");
  73:         'https://www.umbe.website/editor/RFM/filemanager/dialog.php?akey=' + $("#idd").text() + '&type=0&editor=ckeditor&fldr=',

editing\index.php:
  11: ) header("Location: https://www.umbe.website");
  56:             <a href="https://www.umbe.website">

editor\editor.js:
  38:         window.location.replace("https://www.umbe.website");
  73:         'https://www.umbe.website/editor/RFM/filemanager/dialog.php?akey=' + $("#idd").text() + '&type=0&editor=ckeditor&fldr=',

editor\index.php:
   3: if (!isset($_SESSION["id"])) header("Location: https://www.umbe.website");
  29:             <a href="https://www.umbe.website">

editor\phpScript\sendStory.php:
   60: $headers = 'From: "Brand" <webmaster@umbe.website>' . "\r\n" .
   61:     'Reply-To: webmaster@umbe.website' . "\r\n" .
  108:                         <a href="https://www.umbe.website" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;text-decoration: none;">
  130:                                                 <a class="s-btn s-btn__primary" href="https://www.umbe.website/extra/blog?token=$secret" target="_parent" style="background: #0095FF;border: 1px solid #0077cc;box-shadow: inset 0 1px 0 0 rgba(102,191,255,.75);font-family: arial, sans-serif;font-size: 17px;line-height: 17px;color: #ffffff;text-align: center;text-decoration: none;padding: 13px 17px;display: block;border-radius: 4px;white-space: nowrap;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Confirm submission</a>

editor\RFM\filemanager\config\config.php:
  71:     'base_url' => 'https://www.umbe.website',

extra\blog\index.php:
   36:     $headers = 'From: "Brand" <webmaster@umbe.website>' . "\r\n" .
   37:         'Reply-To: webmaster@umbe.website' . "\r\n" .
   90:                         <a href="https://www.umbe.website" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;text-decoration: none;">
  112:                                                 <a class="s-btn s-btn__primary" href="https://www.umbe.website/read?story=$blog_id" target="_parent" style="background: #0095FF;border: 1px solid #0077cc;box-shadow: inset 0 1px 0 0 rgba(102,191,255,.75);font-family: arial, sans-serif;font-size: 17px;line-height: 17px;color: #ffffff;text-align: center;text-decoration: none;padding: 13px 17px;display: block;border-radius: 4px;white-space: nowrap;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Open</a>

extra\reset\reset.js:
  14:                 window.location.replace("https://www.umbe.website");

extra\verify\verify.js:
  14:                 window.location.replace("https://www.umbe.website");

phpScript\list.php:
  55:                 <a class="paddup" href="https://www.umbe.website/read?story={$row["id"]}">

phpScript\sendMail.php:
   25:         $headers = 'From: "Brand" <webmaster@umbe.website>' . "\r\n" .
   26:             'Reply-To: webmaster@umbe.website' . "\r\n" .
   74:                         <a href="https://www.umbe.website" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;text-decoration: none;">
  102:                                                 <a class="s-btn s-btn__primary" href="https://www.umbe.website/extra/verify?token=$secret" target="_parent" style="background: #0095FF;border: 1px solid #0077cc;box-shadow: inset 0 1px 0 0 rgba(102,191,255,.75);font-family: arial, sans-serif;font-size: 17px;line-height: 17px;color: #ffffff;text-align: center;text-decoration: none;padding: 13px 17px;display: block;border-radius: 4px;white-space: nowrap;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Chose a password</a>

phpScript\sendPwReset.php:
  25:         $headers = 'From: "Brand" <webmaster@umbe.website>' . "\r\n" .
  26:             'Reply-To: webmaster@umbe.website' . "\r\n" .
  74:                         <a href="https://www.umbe.website" style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;text-decoration: none;">
  96:                                                 <a class="s-btn s-btn__primary" href="https://www.umbe.website/extra/reset?token=$secret" target="_parent" style="background: #0095FF;border: 1px solid #0077cc;box-shadow: inset 0 1px 0 0 rgba(102,191,255,.75);font-family: arial, sans-serif;font-size: 17px;line-height: 17px;color: #ffffff;text-align: center;text-decoration: none;padding: 13px 17px;display: block;border-radius: 4px;white-space: nowrap;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Chose a password</a>

read\index.php:
  61:             <a href="https://www.umbe.website">

read\read.js:
  490:         window.location.href = "https://www.umbe.website";
```

###### These are the locations of the directories you might want to change:

```
editing\index.php:
  31: $toedit = file_get_contents("/storage/emulated/0/READY/" . $_SESSION["story"] . "/blog.txt");
  32: $image = file_get_contents("/storage/emulated/0/READY/" . $_SESSION["story"] . "/url.txt");

editing\phpScript\updateStory.php:
  18: $fileLocation = "/storage/emulated/0/READY/" . $blog_id . "/blog.txt";
  26: $fileLocation = "/storage/emulated/0/READY/" . $blog_id . "/url.txt";

extra\blog\index.php:
  16:     $dirname = dirname("/storage/emulated/0/READY/" . $blog_id);
  19:     rename("/storage/emulated/0/AWAIT/" . $blog_id, "/storage/emulated/0/READY/" . $blog_id);

phpScript\list.php:
  40:     if ($image = file_get_contents("/storage/emulated/0/READY/" . $row["id"] . "/url.txt"))

read\index.php:
  236:             <?php echo file_get_contents("/storage/emulated/0/READY/" . $id . "/blog.txt"); ?>

read\phpScript\delete.php:
  14: $dir = "/storage/emulated/0/READY/" .  $_SESSION["story"];

editor\phpScript\sendStory.php:
  18: $fileLocation = "/storage/emulated/0/AWAIT/" . $blog_id . "/blog.txt";
  26: $fileLocation = "/storage/emulated/0/AWAIT/" . $blog_id . "/url.txt";

extra\blog\index.php:
  19:     rename("/storage/emulated/0/AWAIT/" . $blog_id, "/storage/emulated/0/READY/" . $blog_id);
```

- The READY directory holds data related to the blogs available to the public

- The AWAIT directory holds data related to the blogs to be confirmed

It is suggested to keep the AWAIT directory outside of the document root.

###### Change <admin_password> to your desired password to freely access the filemanager through the interface, keep it a secret:

```
editor\RFM\filemanager\config\config.php:
  189  
  190:     'access_keys' => array(isset($_SESSION["id"]) ? $_SESSION["id"] : "admin_password"),
  191  
```
