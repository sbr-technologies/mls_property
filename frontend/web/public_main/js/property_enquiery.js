/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){ //alert("hi")
    $(document).on('submit', '#frm_property_enquiery', function(e){ //alert(1);
        $.loading();
        $(".error-message").remove();
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action"); //alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { 
                $.loaded();
                if (resp.success == true){
                    resetFormVal('frm_property_enquiery',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){  $('#sucMsgDiv').fadeOut('slow');  }, 2000);
                }else{ 
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    if(resp.errors.name){
                        $('#propertyenquiery-name').after("<div class='error-message'>"+resp.errors.name+"</div>")   ;
                    }
                    if(resp.errors.email){
                        $('#propertyenquiery-email').after("<div class='error-message'>"+resp.errors.email+"</div>")   ;
                    }
                    if(resp.errors.phone){
                        $('#propertyenquiery-phone').after("<div class='error-message'>"+resp.errors.phone+"</div>")   ;
                    }
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
});

function resetFormVal(frmId,radVal,hidVal){		
    if(radVal == 1){
        $('#'+frmId).find('input:checkbox').removeAttr('checked').removeAttr('selected');
        $('.'+frmId).find('input:checkbox').removeAttr('checked').removeAttr('selected');
    }else{
        $('#'+frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        $('.'+frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');			
    }
    if(hidVal == 1){
        $('#'+frmId).find('input:hidden').val('');
    }
    $('#'+frmId).find('input:password,input:text, input:file, select, textarea').val('');	
    $('.'+frmId).find('input:password,input:text, input:file, select, textarea').val('');
    $('.help-block help-block-error').remove();
}

