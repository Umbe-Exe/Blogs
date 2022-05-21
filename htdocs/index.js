what = "rand";
nomore = false;

$(document).ready(function() {
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 350) {
            $("nav").css("background-color", "white");
            $("nav .btn").css("background-color", "#0f730cbe");
            $("nav .btn").hover(function() {
                $("nav .btn").css("background-color", "green");
            }, function() {
                $("nav .btn").css("background-color", "#008000b6");
            });
        } else {
            $("nav").css("background-color", "#C4E2FF");
            $("nav .btn").css("background-color", "#000000d5");
            $("nav .btn").hover(function() {
                $("nav .btn").css("background-color", "black");
            }, function() {
                $("nav .btn").css("background-color", "#000000d5");
            });
        }

        if (!nomore)
            if (scroll > document.documentElement.scrollHeight - window.innerHeight - 200) {
                $.get("phpScript/list.php?what=" + what)
                    .done(function(data) {
                        if (data != "nomore") $("#reco").append(data);
                        else nomore = true;
                    });
            }

    });
    $.get("phpScript/list.php?what=" + what)
        .done(function(data) {
            $("#reco").append(data);
        });
})

function search(tag_id) {
	if (what != tag_id) {
    		document.getElementById("reco").innerHTML = '';
    		what = tag_id;
    		$.get("phpScript/list.php?what=" + what)
        		.done(function(data) {
            			$("#reco").append(data);
        	});
	}
}

function open(str) {
    document.getElementById("overlay-content").innerHTML =
        '<div id="head"></div>' +
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
    if (str == 1) document.getElementById("head").innerText = "Join Brand.";
    else if (str == 2) document.getElementById("head").innerText = "To start writing, join Brand. It's fast and free.";

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

function close() {
    document.getElementById("overlay").style.visibility = "hidden";
    document.getElementById("overlay").style.opacity = '0';
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
        $.post("phpScript/join.php", {
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
                window.location.replace("https://www.umbe.website");
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
        $.post("phpScript/sendPwReset.php", { email: $("#email").val() })
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
        $.post("phpScript/sendMail.php", { email: $("#email").val() })
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

    $.post("phpScript/changeName.php", { name: $("#usern").val() })
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