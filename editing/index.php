<?php session_start();

$mysqli = new mysqli("localhost", "root", "root", "youdream");

require '../phpScript/user_check.php';

if (
    !isset($_SESSION["id"]) ||
    $_SESSION["csrf"] != $_POST["csrf"] ||
    $_SESSION["writer"] != $_SESSION["id"]
) header("Location: https://www.umbe.website");

$story = $mysqli->query("
SELECT title, blog.desc
FROM blog
WHERE id = " . $_SESSION["story"])->fetch_assoc();

$title = $story["title"];
$desc = $story["desc"];

$result = $mysqli->query("
SELECT tag.name
FROM tag
INNER JOIN blog_has_tag ON blog_has_tag.tag_id = tag.id
WHERE blog_has_tag.blog_id = " . $_SESSION["story"]);

$tags = "";

while ($name = $result->fetch_array()) $tags .= $name[0] . " ";

$toedit = file_get_contents("/storage/emulated/0/READY/" . $_SESSION["story"] . "/blog.txt");
$image = file_get_contents("/storage/emulated/0/READY/" . $_SESSION["story"] . "/url.txt");

?>
<html>

<head>
    <title><?php echo 'edit ' . $title; ?></title>
    <link rel="icon" href="../img/icon.png">
    <link rel="stylesheet" href="../editor/editor.css">
    <script src="../editor/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="editing.js"></script>
</head>

<body>
    <div hidden id="csrf"><?php
                            echo $_SESSION["csrf"] = md5(uniqid(rand(), true));
                            ?></div>
    <div hidden id="idd"><?php
                            echo $_SESSION["id"];
                            ?></div>

    <nav class="center">
        <span class="v-mid">
            <a href="https://www.umbe.website">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30.000000pt" height="30.000000pt" viewBox="0 0 500.000000 540.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,540.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                        <path d="M2419 5330 c-73 -9 -99 -23 -859 -462 -1136 -656 -1210 -701 -1247
                            -757 -28 -41 -29 -66 -5 -106 19 -30 281 -192 767 -473 105 -60 379 -219 610
                            -353 711 -411 664 -389 826 -389 l110 0 132 68 c129 67 1227 701 1680 969 125
                            74 238 149 252 165 18 21 25 41 25 70 0 36 -6 47 -43 82 -23 23 -76 61 -117
                            85 -555 324 -1539 888 -1785 1024 -66 36 -136 68 -155 71 -76 11 -138 13 -191
                            6z m215 -675 c95 -18 182 -63 240 -125 60 -64 66 -107 36 -247 -27 -128 -23
                            -159 29 -206 l39 -35 -200 -113 -200 -112 -32 15 c-49 24 -97 69 -112 105 -19
                            44 -18 83 6 198 26 126 25 147 -5 184 -38 45 -101 65 -184 59 -136 -10 -335
                            -133 -431 -268 -82 -115 -58 -111 -200 -30 -160 92 -161 92 -129 126 38 42
                            217 183 291 230 151 97 359 187 508 218 86 19 250 19 344 1z m549 -721 c101
                            -51 257 -148 254 -158 -3 -10 -374 -226 -387 -226 -8 0 -313 170 -323 180 -9
                            8 370 228 396 230 4 0 31 -12 60 -26z" />
                        <path d="M174 3693 c-13 -14 -28 -38 -32 -52 -4 -14 -7 -501 -6 -1081 l0
                            -1055 38 -75 c47 -92 121 -166 237 -236 210 -129 1676 -967 1798 -1029 65 -33
                            104 -29 147 16 l29 30 3 1074 3 1074 -36 71 c-80 160 -36 130 -1285 850 -638
                            368 -774 440 -830 440 -32 0 -47 -6 -66 -27z m737 -812 c448 -151 750 -470
                            753 -796 1 -173 -46 -239 -221 -310 -72 -30 -123 -79 -123 -119 0 -63 -7 -61
                            -188 41 l-172 98 0 73 c0 118 18 138 195 227 122 61 149 93 143 170 -8 92 -63
                            173 -162 237 -80 52 -171 79 -291 86 l-100 7 -3 120 c-2 66 0 139 3 163 8 54
                            15 54 166 3z m227 -1347 c92 -52 170 -99 175 -103 4 -4 6 -91 5 -194 l-3 -187
                            -177 101 -178 101 0 189 c0 104 2 189 5 189 3 0 81 -43 173 -96z" />
                        <path d="M4684 3701 c-42 -19 -1526 -873 -1745 -1003 -166 -99 -216 -147 -273
                            -258 l-47 -90 3 -1062 c2 -856 6 -1067 16 -1086 17 -29 70 -62 100 -62 36 0
                            108 39 552 295 1549 893 1461 837 1546 999 l37 70 5 880 c3 485 1 970 -3 1079
                            l-7 197 -28 30 c-23 25 -36 30 -72 30 -23 0 -61 -9 -84 -19z m-512 -891 c76
                            -21 118 -107 118 -238 0 -130 -62 -283 -208 -519 -103 -165 -130 -223 -138
                            -296 l-7 -58 -106 -63 c-134 -79 -236 -136 -244 -136 -13 0 -7 95 8 155 23 88
                            51 143 174 347 61 101 120 210 131 241 51 145 3 226 -107 177 -70 -31 -143
                            -89 -290 -234 l-133 -129 0 161 0 161 86 76 c243 217 500 364 634 365 25 0 62
                            -5 82 -10z m-232 -1469 l0 -189 -137 -77 c-76 -43 -157 -89 -181 -102 l-42
                            -25 2 193 3 193 170 98 c94 54 173 98 178 98 4 0 7 -85 7 -189z" />
                    </g>
                </svg>
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="80.000000pt" height="30.000000pt" viewBox="0 0 738.000000 247.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,247.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                        <path d="M6905 2194 c-88 -14 -277 -58 -322 -75 -42 -16 -27 -37 35 -49 71
                                -13 85 -21 93 -51 4 -13 7 -110 8 -215 l1 -191 -57 9 c-97 16 -257 4 -341 -25
                                -237 -84 -409 -289 -464 -553 -24 -116 -21 -298 7 -399 46 -166 157 -311 289
                                -375 58 -29 82 -35 156 -38 144 -7 249 36 355 146 28 29 53 52 56 52 3 0 9
                                -41 13 -92 3 -50 9 -94 12 -97 9 -9 146 -4 227 9 40 6 120 22 180 36 98 24
                                107 28 107 49 0 25 -8 29 -77 40 -23 4 -48 14 -55 22 -10 13 -13 162 -13 762
                                0 410 2 814 4 896 l3 150 -63 2 c-35 0 -104 -5 -154 -13z m-268 -658 c27 -13
                                56 -32 64 -42 12 -14 14 -99 17 -508 l3 -492 -48 -23 c-146 -71 -272 -16 -353
                                155 -135 281 -85 779 90 904 65 47 144 49 227 6z" />
                        <path d="M157 2033 c-3 -5 -4 -19 -1 -31 5 -16 19 -24 67 -34 52 -11 64 -18
                                77 -43 13 -26 15 -131 15 -775 0 -587 -3 -753 -13 -782 -14 -38 -14 -38 -104
                                -54 -37 -6 -58 -38 -39 -57 5 -5 215 -7 468 -5 476 5 518 8 683 55 148 41 287
                                154 329 267 53 143 46 311 -17 416 -30 49 -98 112 -157 145 -59 33 -188 75
                                -232 75 -40 0 -34 19 9 30 194 49 312 157 338 308 16 97 -1 186 -49 257 -58
                                86 -129 135 -252 174 -147 47 -211 53 -675 58 -269 3 -444 1 -447 -4z m829
                                -92 c72 -34 124 -91 156 -170 20 -49 23 -74 23 -201 0 -144 0 -146 -33 -212
                                -54 -110 -114 -138 -299 -138 l-113 0 0 375 0 375 103 0 c92 0 108 -3 163 -29z
                                m30 -803 c118 -39 208 -149 234 -287 15 -78 12 -206 -6 -281 -39 -168 -142
                                -247 -334 -257 -114 -7 -140 3 -168 65 -15 32 -17 88 -20 410 l-3 372 115 0
                                c92 0 129 -5 182 -22z" />
                        <path d="M2622 1625 c-61 -28 -154 -113 -220 -200 -25 -33 -49 -64 -54 -70 -6
                                -6 -7 48 -2 139 l7 149 -79 -6 c-84 -5 -289 -45 -389 -75 -47 -14 -61 -23 -63
                                -39 -3 -18 4 -24 40 -33 66 -17 68 -18 78 -45 15 -39 13 -1067 -1 -1099 -9
                                -19 -22 -26 -59 -31 -37 -5 -49 -11 -54 -28 -3 -11 -3 -24 0 -29 3 -4 167 -8
                                365 -8 354 0 359 0 359 20 0 26 -26 36 -115 47 l-70 8 -13 39 c-9 29 -12 146
                                -10 479 l3 441 47 20 48 20 122 -41 c180 -60 191 -61 221 -21 35 47 58 121 64
                                208 5 67 3 79 -19 110 -27 40 -79 70 -123 70 -16 0 -54 -11 -83 -25z" />
                        <path d="M3522 1639 c-73 -11 -226 -61 -297 -96 -72 -37 -177 -106 -223 -147
                                -50 -45 -86 -126 -78 -174 6 -43 41 -82 72 -82 72 0 266 87 281 126 3 9 -2 56
                                -12 104 -15 75 -15 92 -4 116 17 35 64 47 167 42 71 -3 76 -5 108 -40 52 -57
                                68 -127 69 -299 0 -131 -2 -149 -19 -168 -11 -12 -25 -21 -31 -21 -7 0 -70
                                -18 -141 -41 -365 -116 -506 -232 -506 -419 0 -90 34 -161 107 -229 73 -66
                                130 -85 241 -79 70 4 94 10 158 41 41 21 100 60 129 87 30 28 57 50 60 50 2 0
                                12 -20 21 -44 20 -53 78 -109 131 -126 23 -8 69 -11 120 -8 69 4 95 10 151 38
                                97 48 189 144 157 163 -5 3 -36 -2 -71 -11 -48 -11 -68 -12 -87 -4 -45 21 -48
                                63 -39 472 5 206 7 403 6 438 -5 130 -67 228 -177 283 -53 26 -78 32 -147 34
                                -46 2 -111 -1 -146 -6z m83 -926 c-4 -131 -12 -243 -17 -250 -14 -18 -97 -43
                                -141 -43 -35 0 -47 6 -83 45 -29 29 -48 62 -59 96 -17 59 -20 176 -5 230 11
                                39 61 96 100 112 37 15 161 45 189 46 l23 1 -7 -237z" />
                        <path d="M5093 1635 c-90 -25 -203 -89 -285 -163 l-37 -34 6 101 6 101 -44 0
                                c-54 0 -198 -23 -316 -50 -162 -38 -163 -38 -163 -64 0 -21 8 -26 51 -36 39
                                -10 53 -18 62 -39 17 -38 17 -1078 0 -1107 -9 -15 -28 -25 -60 -30 -42 -8 -48
                                -12 -51 -37 l-3 -27 320 0 c176 0 322 4 325 8 3 5 3 18 0 29 -4 16 -17 22 -54
                                27 -26 4 -54 14 -61 23 -11 13 -15 115 -17 529 l-3 513 68 21 c168 53 282 12
                                345 -125 23 -49 23 -55 26 -476 2 -263 -1 -436 -7 -452 -8 -22 -18 -26 -65
                                -32 -42 -6 -57 -12 -61 -26 -4 -10 -3 -23 0 -29 4 -6 123 -10 331 -10 l325 0
                                -3 27 c-3 25 -8 29 -53 36 -27 4 -54 13 -60 18 -6 6 -12 186 -15 477 l-6 467
                                -27 82 c-75 223 -265 334 -474 278z" />
                    </g>
                </svg>
            </a>
        </span>
        <span id="fill"></span>
        <span class="nav-c">
            <a href="javascript:manage()">File manager</a>
        </span>
        <span class="v-mid">
            <a class="btn" href="javascript:last()">Update</a>
        </span>
    </nav>
    <div id="editor"><?php echo $toedit; ?></div>
    <br><a class="btn btn5" href="javascript:saveDraft()">Save draft</a>
    <script>
        CKEDITOR.replace('editor', {
            extraPlugins: 'wordcount',
            wordcount: {
                showParagraphs: false,
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: false,
                maxWordCount: -1,
                maxCharCount: -1
            },
            allowedContent: true
        });
    </script>

    <div hidden id="tail"></div>

    <div id="overlay">
        <div id="window">
            <a href="javascript:close()" id="closebtn">&times;</a>
            <div id="overlay-content">
                <div id="head">This information will be<br>seen on the front page</div>
                <?php echo '
                <div class="sub">Set a title</div>
                <textarea maxlength="128" class="field" id="titl">' . $title . '</textarea>
                <div class="sub">Set a description</div>
                <textarea maxlength="512" class="field" id="desc">' . $desc . '</textarea>
                <div class="sub">Set a few tags</div>
                <input class="field" id="tags" type="text" value="' . $tags . '">

                <div class="sub">Set an accompanying image</div>
                <div class="field"><label>URL: </label><input id="url" type="url" value="' . $image . '"></div>'
                ?>
                <center id="subsub">You will receive a confirmation email, follow it<br>so we know that its you</center>
                <a class="btn btn2 btn4" href="javascript:go()">Continue</a>
            </div>
        </div>
    </div>
</body>

</html>