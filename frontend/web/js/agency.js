/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $("#geocomplete_agency").geocomplete({
//        map: ".map_canvas",
        //detailsAttribute: 'class^',
        //details: "form.frm_geocomplete",
        details: ".agency_addr_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
    showTeamData();
    var useroccupationType = $("#agent-occupation").val();
    showHideProfileDiv(useroccupationType);
});

function showTeamDiv(){
    $("#selectTeamDiv").show('slow');
}
function hideTeamDiv(){
    $("#selectTeamDiv").hide('slow');
    $("#team_name").val('');
    $("#team_id").val('');
    $("#team_type").val('');
    hideTeamData();
}
function showTeamData(){ 
    listingUrl	=	'teamlisting';	
    $.ajax({
        url:listingUrl,
        type: 'get',
        cache: false,			
        success: function(res) {
            $('#listingTable').html(res);
        },
        error: function(xhr, textStatus, thrownError) {
        }
    });
}
function hideTeamData(){
    $("#newTeamDiv").hide('slow');
    $("#existTeamDiv").hide('slow');
}
function showhideTeam(team_id){
    if(team_id == 0){
        $("#newTeamDiv").show('slow');
        $("#existTeamDiv").hide('slow');
        $("#team_name").val('');
    }else if(team_id == 1){
        $("#newTeamDiv").hide('slow');
        $("#existTeamDiv").show('slow');
        $("#team_id").val('');
    }else{
        $("#newTeamDiv").hide('slow');
        $("#existTeamDiv").hide('slow');
    }
}


function showHideProfileDiv(selectedVal){
    if(selectedVal == 'Other'){
        $("#otherOccupationDiv").show();
    }else{
        $("#otherOccupationDiv").hide();
        $("#agent-occupation_other").val('');
    }
}