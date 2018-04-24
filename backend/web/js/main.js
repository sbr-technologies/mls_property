/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$( document ).ready(function() {
    var curTime = Math.floor(Date.now() / 1000);
    $(".lnk_delete_image").click(function(){
        var element = $(this);
        var url = element.attr('href');
        if(!confirm("Are you sure you want to delete this Record?")){
            return false;
        }
        $.ajax({
                type: "POST",
                url: url,
                success: function(response) {
                    var obj = $.parseJSON( response ); 
                    if(obj.status == 'success'){
                        alert(obj.message);
                        location.reload();
                    }else if(obj.status == 'failed'){
                        alert(obj.message);
                    } 
                    $('.ui-icon-delete').trigger('click');
                },
        });
        return false;
        });
        
    $('body').on('click', '#btn_add_email', function () {
        var selectedEmails = $('#list_avaliable').val();
        if (selectedEmails === null)
            return false;
        $.loading();
        $.post(assignUrl, {'email_ids': selectedEmails}, function (response) {
            $.loaded();
            $('#emailAssignmentWraper').html(response);
        });
        return false;
    });
    
    $('body').on('click', '#btn_remove_email', function () {
        var selectedEmails = $('#list_assigned').val();
        if (selectedEmails === null)
            return false;
        $.loading();
        $.post(unAssignUrl, {'email_ids': selectedEmails}, function (response) {
            $.loaded();
            $('#emailAssignmentWraper').html(response);
        });
        return false;
    });
    
    
   $(document).on('click', '.btn_add_advertisement_banner_info', function () {
        var factInfoRowHtml = $('.dv_advertisement_banner_info_template').html().replace(/curTime/g, Math.floor(Date.now() / 1000));
        $('.dv_advertisement_banner_info_container').append(factInfoRowHtml);
    });
    
    $(document).on('click', '.delete_child', function () {
        var that = $(this), thatItem = that.closest('.item');
        if (thatItem.hasClass('new') || confirm("Are you sure you want to delete this row?")) {
            if(that.hasClass('new')){
                thatItem.remove();
            }else{
                thatItem.find('.hidin_child_id').val('1');
                thatItem.hide();
            }
        }
    });
    
    /**
     * Bootstrap modal handalling
    */
    
    $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
        $('#mls_bs_modal_one').off('hidden.bs.modal');
    });
    
    $(document).on('hidden.bs.modal', function (e) {
        // in cases where we do not need the modals to be refreshed.
        if (typeof $(e.target).data('noremote') != 'undefined') {
            return true;
        }
        $(e.target).removeData('bs.modal');
        $(e.target).find('.modal-content').html('<div class="loading"></div>');
    });
    
    $('#txt_left_menu_filter').keyup(function(){
        var searchText = $(this).val().toString().toLowerCase();
        $('ul.sidebar-menu li a').each(function(){
            var currentLiText = $(this).text().toLowerCase(),
            showCurrentLi = currentLiText.indexOf(searchText) !== -1;
            $(this).toggle(showCurrentLi);
        });     
    });
    
});

$("#name").keyup(function () { 
    var textValue = $(this).val();
    textValue =textValue.replace(/ /g,"-").toLowerCase();
    $('#slug').val(textValue);
});
$("#title").keyup(function () { 
    var textValue = $(this).val();
    textValue =textValue.replace(/ /g,"-").toLowerCase();
    $('#slug').val(textValue);
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
       return false;
    }
    return true;
}


$(document).ready(function(){
	$(".table.table-striped.table-bordered").wrap("<div class='table-responsive'></div>");
});
