/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){ //alert("hi")
   
    $('.bnt_update_feedback').on('click', function(){
        $('#frm_feedback_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                //alert('hii');
            },
            success:function(resp){
                if (resp.success == true){
                    resetFormVal('frm_feedback_data',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    location.href = resp.redirectUrl;
                }else{
                    $('.failmsgdiv').html(resp.message);
                    $('#failMsgDiv').show('slow');
                    setTimeout(function(){ $('#failMsgDiv').fadeOut('slow'); }, 3000);
                }
            },
            error:function(e){
                //alert('Error');
            }
        }).submit();
    });
});