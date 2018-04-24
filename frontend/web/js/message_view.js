jQuery(function ($) {
    $("#to_field").tokenInput(tokenInputUrl, {
        preventDuplicates: true,
        theme: 'facebook',
        placeholder: "Type a name..",
        onReady: function () {
            $('.token-input-list-facebook').hide(1)
        }
    });
    doMessageDocUpload('#message_upload_file');
    if (typeof rAction != 'undefined') {
        if (rAction == 'fd') {
            $('.forward').trigger('click');
            $('html, body').animate({
                scrollTop: $('#user-reply-form').offset().top
            }, 300, function () {
                $('#reply_s_e').trigger("focus")
            });
        } else {
            $('html, body').animate({
                scrollTop: $('#user-reply-form').offset().top
            }, 300, function () {
                $('#reply_s_e').trigger("focus")
            });
        }

    }
    $(document).on('focus', '#reply_s_e', function () {

        $(this).slideUp(100, function () {
            $('.mce-container').slideDown(100);
        });

    });
    $(document).on('submit', '#user-reply-form', function () {
        if ($('#reply_s_e').is(":visible")) {
            alert("Reply can't be empty!");
            return false;
        } else {
            return true;
        }
    });
   
});
$(document).on('click', '.cancel', function () {
    $('.replyone').trigger('click');
    $('.mce-container').slideUp(100, function () {
        $('#reply_s_e').slideDown(100);
    });
});


$(document).on('click', '.message_text_holder_icon .dropdown-menu .reply', function () {
    var forward = '<i class="fa fa-mail-forward "></i> Forward';
    var reply = '<i class="fa fa-reply"></i> Reply';
    var caret = ' <span class="caret"></span>';
    var replyHtml = '';
    if ($(this).hasClass('replyone')) {
        //<a href="javascript:void(0)" class="reply">
        $('#mode').val('reply');
        $('.token-input-list-facebook').animate(
                {
                    'margin-left': '1000px'

                }, 100,
                function () {
                    $(this).slideUp(1);
                }
        );
        vHtml = '<li><a href="javascript:void(0)" class="reply forward">' + forward + '</a></li>';
        replyHtml = reply + caret;

    } else {
        $('#mode').val('forward');
        replyHtml = forward + caret;
        var vHtml = '<li><a href="javascript:void(0)" class="reply replyone">' + reply + '</a></li>';

        $('.token-input-list-facebook').animate(
                {
                    'margin-left': '0'

                }, 100,
                function () {
                    $(this).slideDown(1);

                }
        )
    }

    $('.message_text_holder_icon .btn-default').html(replyHtml);
    $('.message_text_holder_icon .dropdown-menu').html(vHtml);
    return true;
});
function doMessageDocUpload(elem) {
    $(elem).AjaxFileUpload({
        action: uploadMessageDocUrl,
        onComplete: function (filename, response) {
            ;
            if (response.error != 0) {
                alert(response.error);
            } else {
                var elem = $('#mdud');
                var currentDoc = elem.val();
                currentDoc == '' ? elem.val(response.hash) : elem.val(currentDoc + '|||||' + response.hash);
                var elem = $('.filetext');
                elem.append('<a class="label label-primary" href="javascript:void(0)" data-hash="'+response.hash+'"><i class="fa fa-paperclip"></i>'+response.oname+'&nbsp;<i class="fa fa-close file-upload-close"></i></a>');
                
            }
        }
    });
}