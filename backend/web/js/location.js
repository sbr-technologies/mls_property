/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $("#geocomplete").geocomplete({
//        map: ".map_canvas",
        detailsAttribute: 'class^',
        details: "form.frm_geocomplete",
        types: ["geocode", "establishment"],
    });
    $(".geocomplete_local_info").geocomplete({
//        map: ".map_canvas",
//        detailsAttribute: 'class^',
//        details: "form.frm_geocomplete",
        types: ["geocode", "establishment"],
    }).bind("geocode:result", function(event, result){
        var thisElem = $(this);
        console.log(result);
        var lat = result.geometry.location.lat(), lng = result.geometry.location.lng();
        thisElem.parents('.item').find('.lat_').val(lat);
       thisElem.parents('.item').find('.lng_').val(lng);
    });
    
    $("#geocomplete_source").geocomplete({
//        map: ".map_canvas",
        //detailsAttribute: 'class^',
        //details: "form.frm_geocomplete",
        details: ".source_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
    
    $("#geocomplete_destination").geocomplete({
//        map: ".map_canvas",
        //detailsAttribute: 'class^',
        //details: "form.frm_geocomplete",
        details: ".dest_details",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"],
    });
});

                    