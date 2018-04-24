$(document).ready(function(){ 
    $('.bnt_replay_request').on('click', function(){ 
        $('#property_request_replay_data').ajaxForm({
            //display the uploaded images
            beforeSubmit:function(e){
                $.loading();
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
                $.loaded();
            }
        }).submit();
    });
    showData();
});

function showData() {
    listingUrl	=   'property-request-replay-list';
    listingUrl	+=	'?showing_request_id='+$('#showing_request_id').val();
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
function deletePropertyRequest(selectedVal){ 
    if(confirm('Are you sure to delete ?')){
        listingUrl	=   'delete-property-request';
        listingUrl	+=  '?id='+selectedVal;
        $.ajax({
            url: listingUrl,
            type: 'get',
            cache: false,
            success: function (resp) {
                if (resp.success == true){
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
            error: function (xhr, textStatus, thrownError) {
            }
        });
    } 
}