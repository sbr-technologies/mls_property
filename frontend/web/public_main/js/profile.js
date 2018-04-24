$(function(){
    $(document).on('click', '.ask_a_question', function(){ 
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === false){ 
                $('#mls_bs_modal_one').modal({remote: loginPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
            }else{
                $('#mls_bs_modal_one').modal({remote: askPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    //$('#mls_bs_modal_one').find('.ask_redirect_url').val(location.href);
                });
            }
        });
        
    });
    $('body').on('submit', '#question_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");//alert(postUrl);
        $('.help-block help-block-error').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) {
                $.loaded();
                if (resp.success == true){
                    resetFormVal('question_form',0);
                    $('.sucmsgquestdiv').html(resp.message);
                    $('#sucMsgQuestDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgQuestDiv').fadeOut('slow'); }, 10000);
                }else{ 
                    $('.failmsgquestdiv').html(resp.message);
                    $('#failMsgQuestDiv').show('slow');
                    setTimeout(function(){ $('#failMsgQuestDiv').fadeOut('slow'); }, 10000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    $(document).on('click', '.write_review', function(){
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === false){ 
                $('#mls_bs_modal_one').modal({remote: loginPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
            }else{
                $('#mls_bs_modal_one').modal({remote: reviewPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    //$('#mls_bs_modal_one').find('.ask_redirect_url').val(location.href);
                });
            }
        }); 
    });
    $('body').on('submit', '#review_form', function(e){ 
        var postData = $(this).serialize(); 
        var postUrl = $(this).attr("action");//alert(postUrl);
        $('.help-block help-block-error').remove();
        $.loading();
        $.ajax({
            url : postUrl,
            type: "POST",
            //cache : false,
            data : postData,
            //dataType : 'json',
            success:function(resp) {
                $.loaded();
                if (resp.success == true){
                    resetFormVal('review_form',0);
                    $('.sucmsgreviewdiv').html(resp.message);
                    $('#sucMsgReviewDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgReviewDiv').fadeOut('slow'); }, 3000);
                    setTimeout(function(){ $('#mls_bs_modal_one').modal('hide'); }, 2000);
                }else{ 
                    $('.failmsgreviewdiv').html(resp.message);
                    $('#failMsgReviewDiv').show('slow');
                    setTimeout(function(){ $('#failMsgReviewDiv').fadeOut('slow'); }, 3000);
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
        return false;
    });
    
    
    $(document).on('click', '.recommend_me', function(){
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === true){
                //var markers = $('.realestate_map_view_container').find('.html_marker');
                if(response.insert === true){//alert(response.insert+"***"+response.id);
                    thisBtn.html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> Recommended');
                }else{
                    thisBtn.html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Recommend'); 
                }
            }else{
                $('#mls_bs_modal_one').modal({remote: loginPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
            }
        });
    });
    
    $(document).on('click', '.contact_info', function(){ 
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === false){ 
                $('#mls_bs_modal_one').modal({remote: loginPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    //$('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
            }else{
                $('#mls_bs_modal_one').modal({remote: contactPopupurl});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    //$('#mls_bs_modal_one').find('.ask_redirect_url').val(location.href);
                });
            }
        });
        
    });
});