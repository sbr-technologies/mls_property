$(function () {
    $("#message-to").tokenInput(tokenInputUrl, {
        preventDuplicates: true,
        theme: 'facebook',
        placeholder: "To",
        prePopulate: selectedRecipient
    });
    doMessageDocUpload('#message_upload_file');
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