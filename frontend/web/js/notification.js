$(function(){
    $('html').on('click', '.readall', function () {
        markAsRead('all');
    });
});

$('html').on('click', '.mark_as_read', function () {
    markAsRead($(this).data('id'));
});

if (typeof updateNotificationDiv == "function") {
    var uind = setInterval(updateNotificationDiv, 10000);
}
    
function markAsRead(id) {
    if (typeof notifUrl == "undefined") {
        return false;
    }
    if (id == "all") {
        $.post(notifUrl, {action: 'readall'}, function () {

        })
        setTimeout(function () {
            updateNotificationDiv();
        }, 200);
    } else {
        $.post(notifUrl, {action: 'readit', id: id}, function () {

        });
        setTimeout(function () {
            updateNotificationDiv();
        }, 200);
    }
}