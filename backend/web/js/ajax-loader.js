$(function () {
    $.loading = function() {
        // add the overlay with loading image to the page
        var over = '<div id="ajax_overlay">' +
            '<div class="ajax_loader_image"><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>' +
            '</div>' +
            '</div>';
        $(over).appendTo('body');

        // click on the overlay to remove it
        //$('#overlay').click(function() {
        //    $(this).remove();
        //});

        // hit escape to close the overlay
//        $(document).keyup(function(e) {
//            if (e.which === 27) {
//                $('#ajax_overlay').remove();
//            }
//        });
    };
    $.loaded = function(msg){
        $('#ajax_overlay').remove();
        if(msg){
            alert(msg);
        }
    };
});
