
$(document).ready(function(){
    var useroccupationType = $("#buyer-occupation").val();
    showHideProfileDiv(useroccupationType);
});


function showHideProfileDiv(selectedVal){
    if(selectedVal == 'Other'){
        $("#otherOccupationDiv").show();
    }else{
        $("#otherOccupationDiv").hide();
        $("#buyer-occupation_other").val('');
    }
}