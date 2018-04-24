function validateForm(){
    var errorCnt = 0;
    $(".error-message").remove();
    if($("#share_with").val() == ''){
        errorCnt++;
        var modelErrorMsg   =   "Please enter your friend's email(s)";
        $('#share_with').after('<div class="error-message"><b>'+modelErrorMsg+'</b></div>'); 
    }else if($("#share_email").val() == ''){
        errorCnt++;
        var modelErrorMsg   =   "Please enter your email";
        $('#share_email').after('<div class="error-message"><b>'+modelErrorMsg+'</b></div>'); 
    }else if($("#share_name").val() == ''){
        errorCnt++;
        var modelErrorMsg   =   "Please enter your full name";
        $('#share_name').after('<div class="error-message"><b>'+modelErrorMsg+'</b></div>'); 
    }
    if(errorCnt == 0){
        sendShareProperty();
    }
}
function sendShareProperty(){
    $.loading();
    $(".error-message").remove();
    var postData = $("#frm_share_property_friends").serialize(); 
    var postUrl = $("#frm_share_property_friends").attr("action");
    $('.help-block help-block-error').remove();
    $.ajax({
        url : postUrl,
        type: "POST",
        //cache : false,
        data : postData,
        //dataType : 'json',
        success:function(resp) { 
            $.loaded();
            resetFormVal("frm_share_property_friends");
            if (resp.success == true){
                $('.sucsharemsgdiv').html(resp.message);
                $('#sucShareMsgDiv').show('slow');
                setTimeout(function(){  $('#sucMsgDiv').fadeOut('slow');  }, 2000);
            }else{ 
                $('.failsharemsgdiv').html(resp.message);
                $('#failShareMsgDiv').show('slow');
                setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
            }
        },
        error: function(xhr, textStatus, thrownError) {
            alert('Something went to wrong.Please Try again later...');
        }
    });
    return false;
}
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

