

$(document).ready(function(){
    var useroccupationType = $("#seller-occupation").val();
    showHideProfileDiv(useroccupationType);
});


function showHideProfileDiv(selectedVal){
    if(selectedVal == 'Other'){
        $("#otherOccupationDiv").show();
    }else{
        $("#otherOccupationDiv").hide();
        $("#seller-occupation_other").val('');
    }
}
