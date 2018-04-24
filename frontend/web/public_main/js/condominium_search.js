/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $('.search_condominium').on('click', function(){
        var loc = $('#typeAheadXX1').val();

        var url = $(this).data('action');
        if(loc){
        var loca = loc.split(', '), state, town, area;
        if(loca.length === 1){
            state = loca[0];
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 2){
            town = loca[0];
            state = loca[1];
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 3) {
            area = loca[0];
            town = loca[1];
            state = loca[2];
            url = updateQueryStringParameter(url, 'area', area);
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }
        }
        var propTypes = $('#hid_prop_types').val();
        if(propTypes){
            url = updateQueryStringParameter(url, 'prop_types', propTypes);
        }
        
        window.location.href = url;
    });
    
    $('.sort_property_by').on('change', function(){
        var sortBy = $(this).val();
        var loc = $('#typeAheadXX1').val();
        var url = $(this).data('action');
        if(loc){
        var loca = loc.split(', '), state, town, area;
        if(loca.length === 1){
            state = loca[0];
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 2){
            town = loca[0];
            state = loca[1];
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }else if(loca.length === 3) {
            area = loca[0];
            town = loca[1];
            state = loca[2];
            url = updateQueryStringParameter(url, 'area', area);
            url = updateQueryStringParameter(url, 'town', town);
            url = updateQueryStringParameter(url, 'state', state);
        }
    }
        var propTypes = $('#hid_prop_types').val();
        if(propTypes){
            url = updateQueryStringParameter(url, 'prop_types', propTypes);
        }
        
        if(sortBy){
            url = updateQueryStringParameter(url, 'sort', sortBy);
        }
        window.location.href = url;
    });
    
    
    
    $('#sel_condominium_list').on('change', function(){
        var condo = $(this).val();
        if(condo){
            var url = $(this).data('action');
            url = updateQueryStringParameter(url, 'slug', condo);
            window.location.href = url;
        }
    });
})