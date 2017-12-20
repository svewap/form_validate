
jQuery(document).ready(function() {




});

function sendData() {


    $.ajax({
        type: "POST",
        url: jsonLink,
        data: $('#test2').serialize()
    });

}