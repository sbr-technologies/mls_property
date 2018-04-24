/**Used for generating Calener Start**/
$(document).ready(function () {
    $(".datepkr").datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        endDate: new Date()
    });
    $(".datepkrNoRestrict").datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        //endDate:new Date()
    });
    
});
/**Used for generating Calener Start**/
function calenderPopup(calObj) {//alert(calObj.format('YYYY/MM/DD HH:mm:ss'))
    $('#calenderid').val('');
    resetFormVal('entryFrm', 0);
    $('.error-message').remove();
    $('#sucMsgDiv').hide('slow');
    $('#failMsgDiv').hide('slow');
    $('#loddingImage').hide();
    $('#failMsgDiv').addClass('text-none');
    $('#sucMsgDiv').addClass('text-none');
    var start_date = '';
    var start_time = '';
    var end_date = '';
    var end_time = '';
    if (calObj.format()) {
        start_date = calObj.format('MM/DD/YYYY');
        end_date = calObj.format('MM/DD/YYYY');
        $('#calender_end_date_hidden').val(calObj.format('YYYY-MM-DD'));
        if (calObj.hasTime()) {
            start_time = calObj.format('YYYY-MM-DD HH:mm:ss');
            end_time = calObj.format('YYYY-MM-DD HH:mm:ss');
        }
    }
    $('#start_date').val(start_date);
    $('#end_date').val(end_date);
    $('#start_time').val(start_time);
    $('#end_time').val(end_time);
    $('#calenderPopup').modal('show');
}


function deleteCalenderEvent() {
    if (confirm('Are you sure to delete ?')) {
        $('.frmbtngroup').prop('disabled', true);
        $('#loddingImage').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfTkn
            }
        });
        $.ajax({
            url: baseUrl + '/calender/deletecalenderevent',
            type: 'post',
            cache: false,
            data: {
                "id": $('#calenderid').val(),
            },
            success: function (res) {
                $('.frmbtngroup').prop('disabled', false);
                $('.error-message').remove();
                $('#sucMsgDiv').hide('slow');
                $('#failMsgDiv').hide('slow');
                $('#loddingImage').hide();
                $('#failMsgDiv').addClass('text-none');
                $('#sucMsgDiv').addClass('text-none');
                var resp = res.split('****');
                if (resp[1] == 'SUCCESS') {
                    $('#sucMsgDiv').removeClass('text-none');
                    $('.sucmsgdiv').html(resp[2]);
                    $('#sucMsgDiv').show('slow');
                    showData();
                    $('#calenderPopup').modal('hide');
                    resetFormVal('entryFrm', 0);
                } else if (resp[1] == 'ERROR') {
                    $('#failMsgDiv').removeClass('text-none');
                    $('.failmsgdiv').html(resp[2]);
                    $('#failMsgDiv').show('slow');
                }
            },
            error: function (xhr, textStatus, thrownError) {
                //alert('Something went to wrong.Please Try again later...');
            }
        });
    }
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
    $('.error-message').remove();
    //resetting file upload content
    
}