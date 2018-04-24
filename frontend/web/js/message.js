$(function () {
       $('html').on('change', '#selectall', function () {
        if ($(this).is(":checked")) {
            $('.message_action').each(function () {
                if (!$(this).is(":checked")) {
                    $(this).next("label").trigger("click");
                }

            });
        } else {
            $('.message_action').each(function () {
                if ($(this).is(":checked")) {
                    $(this).next("label").trigger("click");
                }

            });
        }
    });
    
        $('html').on('click', '.deleteselected', function () {
        if (typeof msgDeleteUrl == 'undefined') {
            return false;
        }
        if (confirm("Are you sure you want to delete the selected messages? This can't be undone!")) {
            allVals = [];
            $('.message_action:checked').each(function () {
                allVals.push($(this).val());
            });
            if (allVals.length > 0) {
                $.post(msgDeleteUrl, {msgs: allVals}, function (resp) {
                    alert("Successfully deleted!");
                    document.location.reload();
                })

            } else {
                alert("Nothing to delete.");
            }


        }
    });
    
});