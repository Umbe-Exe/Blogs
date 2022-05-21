function join() {
    $("*").css("cursor", "wait");

    $.post("join.php", {
            password: $("#password").val(),
            remember: $("#remember:checked").val()
        })
        .done(function(data) {
            if (data == "invalid") {
                if ($("#warn").length == 0)
                    $("#check").before("<div id='warn'></div>");
                $("#warn").text("Must be at least 8 characters long!");
            } else if (data == "ok") {
                window.location.replace("https://www.umbe.website");
            }
            $("*").css("cursor", "");
        });
}