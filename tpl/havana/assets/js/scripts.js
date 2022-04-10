$("body").css("display", "none");
$("body").fadeIn(500);
$("a.link-off").click(function(event) {
    event.preventDefault();
    linkLocation = this.href;
    $("body").fadeOut(500);
    setTimeout(function() {
        redirectPage();
    }, 500);
});

function redirectPage() {
    window.location = linkLocation;
}

$(document).ready(function() {
    $(document).delegate("#confirm-button", "click", function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "/whitelist",
            data: $('#form-whitelist').serialize(),
            success: function(result) {
                if (result.status) {
                    $('#notis-area').fadeIn('slow', function() {
                        $('#notis-area').html('<div class="alert alert-success" role="alert">' + result.message + '</div>')
                    }).delay(8000).fadeOut('slow', function() {
                        $('#notis-area').html('')
                    })
                } else {
                    $('#notis-area').fadeIn('slow', function() {
                        $('#notis-area').html('<div class="alert alert-danger" role="alert">' + result.message + '</div>')
                    }).delay(8000).fadeOut('slow', function() {
                        $('#notis-area').html('')
                    })
                }
            }
        });
    });
});