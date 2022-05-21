function changeName() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head2">Change your username</div>' +
        '<div id="yemail">Your username</div>' +
        '<div class="field">' +
        '   <input id="usern" type="text" maxlength="45" value="' + $('#usr').text() + '">' +
        '</div>' +
        '<a class="btn btn2 btn4" href="javascript:justName()">Continue</a>';
    document.getElementById("overlay").style.visibility = "visible";
    document.getElementById("overlay").style.opacity = '1';
}

function justName() {
    $("*").css("cursor", "wait");

    $.post("../phpScript/changeName.php", { name: $("#usern").val() })
        .done(function(data) {

            if (data == "exist") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Already taken!");
            } else {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Done!");
            }
            $("*").css("cursor", "");
        });
}

function close() {
    document.getElementById("overlay").style.visibility = "hidden";
    document.getElementById("overlay").style.opacity = '0';
}

function open() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head">To start writing, join Brand.<br> It\'s fast and free.</div>' +
        '<a href="javascript:setEmail()">' +
        '   <div id=btn3>' +
        '       <span>' +
        '           <svg width="25" height="25">' +
        '               <path d="M4 6v13h17V6H4zm5.9 7.97l2.6 2.12 2.6-2.12 4.14 4.02H5.76l4.15-4.02zm-4.88 3.32V9.97l4.1 3.35-4.1 3.97zm10.87-3.97l4.1-3.35v7.32l-4.1-3.97zm4.1-6.3v1.64l-7.49 6.12-7.48-6.13V7.01h14.96z"></path>' +
        '           </svg>' +
        '       </span>' +
        '       <span>Sign up with email</span>' +
        '   </div>' +
        '</a>';

    document.getElementById("overlay").style.visibility = "visible";
    document.getElementById("overlay").style.opacity = '1';
}

function login() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head">Welcome back.</div>' +
        '<a href="javascript:setCredentials()">' +
        '   <div id=btn3>' +
        '       <span>' +
        '           <svg width="25" height="25">' +
        '               <path d="M4 6v13h17V6H4zm5.9 7.97l2.6 2.12 2.6-2.12 4.14 4.02H5.76l4.15-4.02zm-4.88 3.32V9.97l4.1 3.35-4.1 3.97zm10.87-3.97l4.1-3.35v7.32l-4.1-3.97zm4.1-6.3v1.64l-7.49 6.12-7.48-6.13V7.01h14.96z"></path>' +
        '           </svg>' +
        '       </span>' +
        '       <span>Sign in with email</span>' +
        '   </div>' +
        '</a>';

    document.getElementById("overlay").style.visibility = "visible";
    document.getElementById("overlay").style.opacity = '1';
}

function setEmail() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head2">Sign up with email</div>' +
        '<div id="sub">Enter your email address to create an account.</div>' +
        '<div id="yemail">Your email</div>' +
        '<div class="field">' +
        '   <input id="email" type="email">' +
        '</div>' +
        '<a class="btn btn2 btn4" href="javascript:sendMail()">Continue</a>';
}

function setCredentials() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head2">Sign in with email</div>' +
        '<div id="sub">Enter the email address associated with your account, and password.</div>' +
        '<div id="yemail">Your email</div>' +
        '<div class="field">' +
        '   <input id="email" type="email">' +
        '</div>' +
        '<div id="yemail">Your password</div>' +
        '<div class="field">' +
        '   <input id="password" type="password">' +
        '</div>' +
        '<div id=check>' +
        '<input type="checkbox" id="remember">' +
        '<label>Remember me</label>' +
        '</div>' +
        '<a class="btn btn2 btn4" href="javascript:join()">Continue</a>' +
        '<a id="link" href="javascript:forgot()"><br>Forgot password</a>';
}

function join() {
    $("*").css("cursor", "wait");

    var re = /\S+@\S+\.\S+/;
    if (re.test($("#email").val()))
        $.post("../phpScript/join.php", {
            email: $("#email").val(),
            password: $("#password").val(),
            remember: $("#remember:checked").val()
        })
        .done(function(data) {
            if (data == "invalid") {
                if ($("#warn").length == 0)
                    $("#check").before("<div id='warn'></div>");
                $("#warn").text("Enter a valid email!");
            } else if (data == "ok") {
                window.location.reload();
            } else if (data == "noexist") {
                if ($("#warn").length == 0)
                    $("#check").before("<div id='warn'></div>");
                $("#warn").text("Wrong email or password!");
            }

            $("*").css("cursor", "");
        });
    else {
        if ($("#warn").length == 0)
            $("#check").before("<div id='warn'></div>");

        $("#warn").text("Enter a valid email!");
        $("*").css("cursor", "");
    }
}

function forgot() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head2">Type in your email address</div>' +
        '<div id="sub">You will receive an email. Follow the link and set a new password.</div>' +
        '<div id="yemail">Your email</div>' +
        '<div class="field">' +
        '   <input id="email" type="email">' +
        '</div>' +
        '<a class="btn btn2 btn4" href="javascript:sendPwReset()">Continue</a>';
}

function sendPwReset() {
    $("*").css("cursor", "wait");

    var re = /\S+@\S+\.\S+/;
    if (re.test($("#email").val()))
        $.post("../phpScript/sendPwReset.php", { email: $("#email").val() })
        .done(function(data) {
            if (data == "invalid") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Enter a valid email!");
            } else if (data == "ok") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Check your inbox!");
            } else if (data == "noexist") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Email doesn't exists!");
            }

            $("*").css("cursor", "");
        });
    else {
        if ($("#warn").length == 0)
            $(".field").first().after("<div id='warn'></div>");

        $("#warn").text("Enter a valid email!");
        $("*").css("cursor", "");
    }
}

function sendMail() {
    $("*").css("cursor", "wait");

    var re = /\S+@\S+\.\S+/;
    if (re.test($("#email").val()))
        $.post("../phpScript/sendMail.php", { email: $("#email").val() })
        .done(function(data) {
            if (data == "invalid") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Enter a valid email!");
            } else if (data == "ok") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Check your inbox!");
            } else if (data == "exist") {
                if ($("#warn").length == 0)
                    $(".field").first().after("<div id='warn'></div>");
                $("#warn").text("Email already exists!");
            }

            $("*").css("cursor", "");
        });
    else {
        if ($("#warn").length == 0)
            $(".field").first().after("<div id='warn'></div>");

        $("#warn").text("Enter a valid email!");
        $("*").css("cursor", "");
    }
}

function like() {
    $("*").css("cursor", "wait");

    $.post("phpScript/like.php")
        .done(function(data) {
            if (data == "cant") open();
            else if (data == "liked") {
                $("#like path").css("fill", "red");
                $("#dislike path").css("fill", "black");
            } else $("#like path").css("fill", "black");
            $("*").css("cursor", "");
        });
}

function dislike() {
    $("*").css("cursor", "wait");

    $.post("phpScript/dislike.php")
        .done(function(data) {
            if (data == "cant") open();
            else if (data == "disliked") {
                $("#dislike path").css("fill", "red");
                $("#like path").css("fill", "black");
            } else $("#dislike path").css("fill", "black");
            $("*").css("cursor", "");
        });
}

function follow() {
    $("*").css("cursor", "wait");

    $.post("phpScript/follow.php")
        .done(function(data) {
            if (data == "cant") open();
            else if (data == "ok") {
                document.getElementById("fllw").href = "javascript:unfollow()";
                document.getElementById("fllw").text = "Unfollow";
            }
            $("*").css("cursor", "");
        });
}

function unfollow() {
    $("*").css("cursor", "wait");

    $.post("phpScript/unfollow.php")
        .done(function(data) {
            if (data == "cant") open();
            else if (data == "ok") {
                document.getElementById("fllw").href = "javascript:follow()";
                document.getElementById("fllw").text = "Follow";
            }
            $("*").css("cursor", "");
        });
}

function closecommt() {
    $("#comment-slider").animate({ bottom: '-80%' }, 600);
}

id = [-1];
prevId = [0];
nomore = [false];
currId = 0;

function post(uid) {
    $("*").css("cursor", "wait");

    $.post("phpScript/post.php", {
        csrf: $("#csrf").text(),
        replyto: uid,
        text: $("#wall" + uid + " textarea").val(),

    }).done(function(data) {
        if (data == 'cant') open();
        else
            $("#wall" + uid).append(
                '<table class="comment" id=' + data + '>' +
                '    <tr>' +
                '        <td>' +
                '            <span class="va">' +
                '                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="22px" viewBox="0 0 45.532 45.532" style="enable-background:new 0 0 45.532 45.532;" xml:space="preserve">' +
                '                    <path d="M22.766,0.001C10.194,0.001,0,10.193,0,22.766s10.193,22.765,22.766,22.765c12.574,0,22.766-10.192,22.766-22.765' +
                '                    S35.34,0.001,22.766,0.001z M22.766,6.808c4.16,0,7.531,3.372,7.531,7.53c0,4.159-3.371,7.53-7.531,7.53' +
                '                    c-4.158,0-7.529-3.371-7.529-7.53C15.237,10.18,18.608,6.808,22.766,6.808z M22.761,39.579c-4.149,0-7.949-1.511-10.88-4.012' +
                '                    c-0.714-0.609-1.126-1.502-1.126-2.439c0-4.217,3.413-7.592,7.631-7.592h8.762c4.219,0,7.619,3.375,7.619,7.592' +
                '                    c0,0.938-0.41,1.829-1.125,2.438C30.712,38.068,26.911,39.579,22.761,39.579z">' +
                '                </svg>' +
                '            </span>' +
                '            <span class="name">' + $('#usr').text() + '</span>' +
                '        </td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td>' +
                '            <div class="des">' + $("#wall" + uid + " textarea").val() + '</div>' +
                '        </td>' +
                '    </tr>' +
                '    <tr>' +
                '        <td>' +
                '        <a href="javascript:edit(' + data + ')">edit</a>' +
                '        &nbsp;&nbsp;&nbsp;' +
                '        <a href="javascript:reply(' + data + ')">reply</a>' +
                '        </td>' +
                '    </tr>' +
                '</table>'
            );
        $("#wall" + uid + " textarea").val('')
        $("*").css("cursor", "");
    });
}

function update(uid) {
    $("*").css("cursor", "wait");

    $.post("phpScript/update.php", {
        csrf: $("#csrf").text(),
        yours: uid,
        text: $('#' + uid + ' textarea').val(),

    }).done(function() {
        nw = $('#' + uid + ' textarea').val();
        nope();
        $('#' + uid + ' .des').text(nw);
        $("*").css("cursor", "");
    });
}

function getComments() {
    if (!nomore[currId])
        $.get("phpScript/comment.php?id=" + id[currId])
        .done(function(data) {
            if (data != "nomore") $("#wall" + id[currId]).append(data);
            else nomore[currId] = true;
        });
}

function opencommt() {
    $("#comment-slider").animate({ bottom: 0 }, 600);

    if (id[currId] == -1) {
        id[currId] = 0;

        getComments();
    }
}

function reply(uid) {
    $("#wall" + id[currId]).hide();

    $('#back').show();

    if ($('#wall' + uid).length) {
        $('#wall' + uid).show();
        for (i = 0; i < id.length; i++)
            if (id[i] == uid) {
                currId = i;
                break;
            }
    } else {
        id.push(uid);
        prevId.push(currId);
        nomore.push(false);

        currId = id.length - 1;
        $("#comment-slider").append(
            '<div id="wall' + uid + '">' +
            '<textarea rows="5" cols="70%" maxlength="1024" placeholder="Reply to' + $('#' + uid + ' .name').text() + '"></textarea>' +
            '<a id="post" class="btn btn5" href="javascript:post(' + uid + ')">Post</a>' +
            '<div class="comment" style="margin-top: 0;">' +
            '    <span class="va">' +
            '        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="22px" viewBox="0 0 45.532 45.532" style="enable-background:new 0 0 45.532 45.532;" xml:space="preserve">' +
            '            <path d="M22.766,0.001C10.194,0.001,0,10.193,0,22.766s10.193,22.765,22.766,22.765c12.574,0,22.766-10.192,22.766-22.765' +
            '                        S35.34,0.001,22.766,0.001z M22.766,6.808c4.16,0,7.531,3.372,7.531,7.53c0,4.159-3.371,7.53-7.531,7.53' +
            '                        c-4.158,0-7.529-3.371-7.529-7.53C15.237,10.18,18.608,6.808,22.766,6.808z M22.761,39.579c-4.149,0-7.949-1.511-10.88-4.012' +
            '                        c-0.714-0.609-1.126-1.502-1.126-2.439c0-4.217,3.413-7.592,7.631-7.592h8.762c4.219,0,7.619,3.375,7.619,7.592' +
            '                        c0,0.938-0.41,1.829-1.125,2.438C30.712,38.068,26.911,39.579,22.761,39.579z">' +
            '        </svg>' +
            '    </span>' +
            '    <span class="name">' + $('#' + uid + ' .name').text() + '</span>' +
            '    <div class="des">' + $('#' + uid + ' .des').text() + '</div>' +
            '</div>' +
            '<hr>' +
            '</div>'
        );

        getComments();
    }
}

replacing = '';
replacingId = 0;

function edit(uid) {

    if (replacingId) nope();

    replacingId = uid;
    replacing =
        $('#' + uid + ' tr:nth-child(2)')[0].outerHTML +
        $('#' + uid + ' tr:nth-child(3)')[0].outerHTML;

    $('#' + uid).append(
        '<textarea rows="5" cols="70%" maxlength="1024">' + $('#' + uid + ' .des').text() + '</textarea>' +
        '<div><a id="post" class="btn btn5" href="javascript:update(' + uid + ')">Update</a>' +
        '<a id="post" class="btn btn5" href="javascript:nope(' + uid + ')">Go back</a></div>');

    $('#' + uid + ' tr:nth-child(3)').remove();
    $('#' + uid + ' tr:nth-child(2)').remove();
}

function nope(uid) {
    $('#' + replacingId + ' textarea').remove();
    $('#' + replacingId + ' div').remove();
    $('#' + replacingId).append(replacing);
    replacingId = 0;
}

function back() {

    $("#wall" + id[currId]).hide();

    currId = prevId[currId];
    $('#wall' + id[currId]).show();
    if (currId == 0) $('#back').hide();
}

$(document).ready(function() {
    $.ajaxSetup({ async: false });
    $("#comment-slider").on('scroll', function() {
        scrollTop = $("#comment-slider").scrollTop();
        scrollH = $("#comment-slider")[0].scrollHeight;
        offsetHeight = $("#comment-slider").innerHeight();

        if (!nomore[currId])
            if (scrollH - offsetHeight - scrollTop < 50) {

                $.get("phpScript/comment.php?id=" + id[currId])
                    .done(function(data) {
                        if (data != "nomore") $("#wall" + id[currId]).append(data);
                        else nomore[currId] = true;
                    });
            }

    });

    var refresh_session = function() {
        setTimeout(function() {
            $.ajax({
                url: '../extra/keepalive.php',
                cache: false,
                success: function() {
                    refresh_session();
                }
            });
        }, 300000);
    }
    refresh_session();
})

function delet() {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head">Are you sure you want to<br>delete the story?</div>' +
        '<a href="javascript:okdelete()">' +
        '   <div id=btn3>' +
        '       <span>Yeah</span>' +
        '   </div>' +
        '</a>';

    document.getElementById("overlay").style.visibility = "visible";
    document.getElementById("overlay").style.opacity = '1';
}

function okdelete() {

    $.post("phpScript/delete.php", {
        csrf: $("#csrf").text(),
    }).done(function() {
        window.location.href = "https://www.umbe.website";
    });
}