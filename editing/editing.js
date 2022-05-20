$(document).ready(function() {
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
});

function last() {
    document.getElementById("overlay").style.visibility = "visible";
    document.getElementById("overlay").style.opacity = '1';
}

function close() {
    document.getElementById("overlay").style.visibility = "hidden";
    document.getElementById("overlay").style.opacity = '0';
}

function go() {
    $("*").css("cursor", "wait");

    $.post("phpScript/updateStory.php", {
        csrf: $("#csrf").text(),
        title: $("#titl").val(),
        desc: $("#desc").val(),
        tags: $("#tags").val(),
        url: $("#url").val(),
        story: CKEDITOR.instances['editor'].getData()
    }).done(function() {
        $("*").css("cursor", "");
        window.location.replace("https://www.umbe.website");
    });
}

$(document).on('mousemove', function(e) {
    $('#tail').css({
        left: e.pageX,
        top: e.pageY
    });
});

function saveDraft() {
    $("*").css("cursor", "wait");

    $.post("../editor/phpScript/saveDraft.php", {
        csrf: $("#csrf").text(),
        title: $("#titl").val(),
        desc: $("#desc").val(),
        tags: $("#tags").val(),
        url: $("#url").val(),
        story: CKEDITOR.instances['editor'].getData()
    }).done(function(data) {
        $("*").css("cursor", "");

        $('#tail').text(data + " saved");
        $('#tail').fadeTo(500, 0.9);

        setTimeout(() => {
            $('#tail').fadeTo(1000, 0);
        }, 3500);
    });
}

function manage() {
    var win = window.open(
        'https://www.umbe.website/editor/RFM/filemanager/dialog.php?akey=' + $("#idd").text() + '&type=0&editor=ckeditor&fldr=',
        'File manager', "width=980,height=700");
}