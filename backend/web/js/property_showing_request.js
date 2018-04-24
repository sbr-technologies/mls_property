$(document).ready(function(){ //alert("hi")
    $('.bnt_replay_request').on('click', function(){ 
        
        $('#property_request_replay_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                //alert('hii');
                
            },
            success:function(resp){
                $.loaded();
                if (resp.success == true){
                    resetFormVal('property_request_replay_data',0);
                    $('.sucmsgdiv').html(resp.message);
                    $('#sucMsgDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 3000);
                    showData();
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
    showData();
});

function showData() {
    listingUrl	=   'index.php?r=property-showing-request/property-request-replay-list';
    listingUrl	+=	'&showing_request_id='+$('#showing_request_id').val();
    $.ajax({
        url: listingUrl,
        type: 'get',
        cache: false,
        success: function (res) {
            $('#listingTable').html(res);
        },
        error: function (xhr, textStatus, thrownError) {
            $('#loddingImage').hide();
            //alert('Something went to wrong.Please Try again later...');
        }
    });
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