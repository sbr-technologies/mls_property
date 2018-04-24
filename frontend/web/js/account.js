$(document).ready(function () {
    //Login and forgot password Show/Hide
    $(document).on('click', '.lnk_forgot_password', function () {
        $('.full-login-box').slideUp();
        $('.forgot-password-box').slideDown();
    });
    $(document).on('click', '.lnk_login', function () {
        $('.full-login-box').slideDown();
        $('.forgot-password-box').slideUp();
    });
    
    $('#mls_bs_modal_lg').on('hidden.bs.modal', function (e) {
        $(e.target).removeData('bs.modal');
        $(e.target).find('.modal-content').html(''); 
    });
});


$(document).ready(function() {
    
    $('body').on('submit', '#login_form', function(e){
        var thisform = $(this);
        var now = new Date();
        var hrs = now.getHours();
        $('<input>').attr({
            type: 'hidden',
            value: hrs,
            name: '_cur_time'
        }).appendTo(thisform);
        var postData = thisform.serialize(); 
        var postUrl = thisform.attr("action");//alert(postUrl);
        $('.help-block help-block-error').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) {
                $.loaded();
                if (resp.success == true){
                    resetFormVal('login_form',0);
                    $('.sucloginmsgdiv').html(resp.message);
                    $('#sucLoginMsgDiv').show('slow');
                    setTimeout(function(){ window.location = resp.redirect_url }, 2000);
                }else{ 
                    $('.failloginmsgdiv').html(resp.message);
                    $('#failLoginMsgDiv').show('slow');
                    setTimeout(function(){ $('#failLoginMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#signup_form', function(e){
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) {
                $.loaded();
//                $('#signup_captcha_image').trigger('click');
                if (resp.success == true){
                    resetFormVal('signup_form',0);
                    $('.sucsignupmsgdiv').html(resp.message);
                    $('#sucSignUpMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucSignUpMsgDiv').fadeOut('slow'); }, 3000);
                }else{
                    $('#signup_popup_captcha_image').yiiCaptcha('refresh');
                    $('#signupform-verifycode').val('');
                    $('.failsignupmsgdiv').html(first(resp.errors));
                    $('#failSignUpMsgDiv').show('slow');
                    setTimeout(function(){ $('#failSignUpMsgDiv').fadeOut('slow'); }, 3000);
                }
                $('#mls_bs_modal_two').animate({scrollTop: 0}, 800);
            },
            error: function(xhr, textStatus, thrownError) {
                $('#signup_popup_captcha_image').yiiCaptcha('refresh');
                $('#signupform-verifycode').val('');
                $.loaded('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#request-password-reset-form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $('.error-message').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { 
                $.loaded();
                resetFormVal('request-password-reset-form',0);
                if (resp.success == true){ 
                    $('.sucpassmsgdiv').html(resp.message);
                    $('#sucPassMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucPassMsgDiv').fadeOut('slow'); }, 3000);
                }else{
                    $('.failpassmsgdiv').html(resp.message);
                    $('#failPassMsgDiv').show('slow');
                    setTimeout(function(){ $('#failPassMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#reset-password-form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) {  
                if (resp.success == true){
                    resetFormVal('reset-password-form',0);
                    $('.sucpassmsgdiv').html(resp.message);
                    $('#sucPassMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucPassMsgDiv').fadeOut('slow'); }, 3000);
                    window.location.replace(resp.redirect_to);
                }else{
                    $('.failpassmsgdiv').html(resp.message);
                    $('#failPassMsgDiv').show('slow');
                    setTimeout(function(){ $('#failPassMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#update_profile_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $('.error-message').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { 
                if (resp.success == true){
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000); 
                    $('html, body').animate({scrollTop: 0}, 800);
                    hideTeamDiv();
                    showTeamData();
                    
                }else if(resp.success == 'new_team'){
                    $('#team_name').after('<div class="error-message">'+resp.message+'</div>'); 
                }else if(resp.success == 'select_team'){
                    $('#team_id').after('<div class="error-message">'+resp.message+'</div>'); 
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#update_address_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { 
                if (resp.success == true){
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    $('body').on('submit', '#update_worksheet_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            dataType : 'json',
            success:function(resp) { 
                if (resp.success == true){
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }else{
                    $('.failmsgdiv').html(first(resp.errors));
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('.bnt_save_agency').on('click', function(){
        $('#update_agency_form').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                    $('.hid_manage_agency_agency_id').val(resp.agency_id);
                    if(resp.logoUrl){
                        $('.agency_image').attr('src', resp.logoUrl).show();
                    }
//                    $('.gallery-photo-contaner').hide();
//                    var loc = window.location.href + '#agency';
//                    window.location.href = loc;
                }else{
                    $('.failmsgdiv').html(first(resp.errors));
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }
            },
            error:function(e){
                $.loaded();
            }
        }).submit();
    });
    
    
    $('body').on('submit', '#manage_social_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { 
                if (resp.success == true){
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#buy_property_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");// alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "get",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { 
                
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    $('body').on('submit', '#update_broker_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");//alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { //alert(resp.redirect_url+"***"+resp.success);
                if (resp.success == true){
                    resetFormVal('login_form',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow');  }, 2000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }else{ 
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    $('body').on('submit', '#manage_company_form', function(e){
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");//alert(postUrl);
        $('.help-block help-block-error').remove();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) { //alert(resp.redirect_url+"***"+resp.success);
                if (resp.success == true){
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow');  }, 2000);
                    $('html, body').animate({scrollTop: 0}, 800);
                }else{ 
                    $('.failmsgdiv').html(first(resp.errors));
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                    $('html, body').animate({scrollTop: 0}, 800);
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
function resetAgencyFormVal(frmId){
    $('.'+frmId).val('');
    $('.'+frmId).prop('disabled',false);
    $('#agent-team_id').empty().append($('<option></option>')
                                                                      .attr('value', '').text('No Team'));;
    $('.hid_manage_agency_agency_id').val('');
    $('.agency_image').attr('style', 'display:block;');
    $('.add-upload-images').attr('style', 'display:none;');
    $('#uploadImageDispaly').hide('slow');
    $('#uploadImageDiv').show('slow');
    
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
       return false;
    }
    return true;
}
function isNumberKeyWithDot(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode == 46)
        return true
    else{
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        else
            return true;
    }
}
function isNumberWithHyphen(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode == 45)
        return true
    else{
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        else
            return true;
    }
}
function validateEmail(){
    var postData = $('#email').val(); 
    var postUrl = $('#email').data("validate_email_url");
    $('.help-block help-block-error').remove();
    $.ajax({
        url : postUrl,
        type: "POST",
        data : {"emailId" : postData},
        success:function(resp) {
            if (resp.success == false){
                $('#email').next('.help-block-error').text(resp.message).end().parents('.form-group').removeClass('has-success').addClass('has-error');
            }else{
                $('#email').next('.help-block-error').empty().end().parents('.form-group').removeClass('has-error').addClass('has-success');
            }
        },
        error: function(xhr, textStatus, thrownError) {
            alert('Something went to wrong.Please Try again later...');
        }
    });
    return false;
}

function first(obj) {
    for (var a in obj)
        return obj[a];
}