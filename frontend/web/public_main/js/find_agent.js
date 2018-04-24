
function showHideDiv(selectedVal){
    if(selectedVal != ''){
        if(selectedVal == 'agent'){
            $("#agentDiv").show();
            $("#officeDiv").hide();
            $("#teamsDiv").hide();
        }else if(selectedVal == 'office'){
            $("#agentDiv").hide();
            $("#officeDiv").show();
            $("#teamsDiv").hide();
        }else if(selectedVal == 'teams'){
            $("#agentDiv").hide();
            $("#officeDiv").hide();
            $("#teamsDiv").show();
        }
    }else{
        $("#agentDiv").hide();
        $("#officeDiv").hide();
        $("#teamsDiv").hide();
    }
}

$(document).ready(function(){
    
    $(document).on('click', '.btn_search_agent_home', function(){
        var that = $(this);
        var $suggestion = $('input[name=location_suggestion]');
        var $agent = $('.realestate_search_agent');
        if(!$suggestion.val() && !$agent.val()){
            $suggestion.addClass('input_box_error');
            return false;
        }
        if($suggestion.val() && !$('.realestate_search_location').val()){
            $suggestion.addClass('input_box_error');
            return false;
        }
        var thisForm = that.closest('form');
        var url = thisForm.attr('action');
        url = updateQueryStringParameter(url, 'location', $('.realestate_search_location').val());
        url = updateQueryStringParameter(url, 'name', $('.realestate_search_agent').val());
        window.location.href = url;
    });
    
    $('input[name=location_suggestion]').on('focus', function(){
        $(this).removeClass('input_box_error');
    });
    
    $(document).on('click', '.btn_search_agent' ,function(){
        var that = $(this), validated = false;
        var thisForm = that.closest('form');       
        var url = thisForm.attr('action');
        var searchItems = $('.search_item');
        thisForm.find(searchItems).each(function(){
            var thisItem = $(this);
            var name = thisItem.attr('name');
            if(thisItem.val()){
                validated = true;
                url = updateQueryStringParameter(url, name, thisItem.val());
            }
        });
        if(validated === false){
            alert("Please enter a search item");
            return false;
        }
        window.location.href = url;
    });
    
    $(document).on('click', '.btn_search_agancy' ,function(){
        var that = $(this), validated = false;
        var thisForm = that.closest('form');
        var url = thisForm.attr('action');
        var searchItems = $('.search_item');
        thisForm.find(searchItems).each(function(){
            var thisItem = $(this);
            var name = thisItem.attr('name');
            if(thisItem.val()){
                validated = true;
                url = updateQueryStringParameter(url, name, thisItem.val());
            }
        });
        if(validated === false){
            alert("Please enter a search item");
            return false;
        }
        
        window.location.href = url;
    });
    
    $(document).on('click', '.btn_search_team' ,function(){
        var that = $(this), validated = false;
        var thisForm = that.closest('form');
        
        var url = thisForm.attr('action');
        var searchItems = $('.search_item');
        thisForm.find(searchItems).each(function(){
            var thisItem = $(this);
            var name = thisItem.attr('name');
            if(thisItem.val()){
                validated = true;
                url = updateQueryStringParameter(url, name, thisItem.val());
            }
        });
        if (validated == false) {
            alert("Please enter a search item");
            return false;
        }
        window.location.href = url;
    });
});