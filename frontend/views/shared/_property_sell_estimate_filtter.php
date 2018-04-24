<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\PropertyCategory;
use common\models\GeneralFeatureMaster;
use common\models\ConstructionStatusMaster;
use common\models\LocationSuggestion;
use kartik\select2\Select2;
use kartik\date\DatePicker;
//print_r($propTypes);die();
//print_r($constStatuses);die();
$this->registerCssFile(
    '@web/plugins/bootstrap-multiselect/bootstrap-multiselect.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);

$this->registerJsFile(
    '@web/plugins/bootstrap-multiselect/bootstrap-multiselect.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/plugins/underscore.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/public_main/js/sell_estimate.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
//echo $state;die();
//yii\helpers\VarDumper::dump($lotSize,12,1); exit;
?>
<div class="property-menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form action="<?= Url::to(['/sell-estimate'])?>" role="search" class="frm_search_result_page_search">
                    <input type="hidden" value="" name="location" class="hid_realestate_search_location" />
                    <input type="hidden" class="txt_filter_bedroom" value="<?php if(isset($bedroom))echo $bedroom?>" />
                    <input type="hidden" class="txt_filter_bathroom"  value="<?php if(isset($bathroom))echo $bathroom?>" />
                    <input type="hidden" class="txt_filter_garage"  value="<?php if(isset($garage))echo $garage?>" />
                    <input type="hidden" class="hid_location_suggestion" value="<?= $location?>" />
                    <input type="hidden" class="hid_search_category" value="<?= $category?>" />
                    <input type="hidden" class="hid_search_page" value="0" />
                    <input type="hidden" class="hid_view_type" value="<?=$viewType? $viewType:'summary'?>" />
                    <input type="hidden" class="hid_temp_state" value="<?= $state?>" />
                    <input type="hidden" class="hid_temp_town" value="<?= !is_array($town)?$town:''?>" />
                    <input type="hidden" class="hid_temp_area" value="<?= !is_array($area)?$area:''?>" />
                    <input type="hidden" class='hid_property_listing_base' value="<?= Url::to(['sell/estimate'])?>" />
                    
                        <div class="property-search-bar">
                            <div class="input-group">
                              <?php // echo $location;die();
                                $template = '<div class="location-suggestion-item"><p class="location-type">{{location_type}}</p>' .
                                      '<p class="location-name">{{value}}</p>' .
                                      '</div>';

                                echo Typeahead::widget([
                                    'name' => '',
                                    'disabled' => empty($location),
                                    'value' => $location?$location:'Multiple location selected',
                                    'options' => ['id' => 'typeAheadXX1', 'placeholder' => 'Pls enter Area, Town, State', 'class' => 'txt_location_suggestion'],
                                    'dataset' => [
                                        [
                                            'remote' => [
                                                'url' => Url::to(['/location-suggestion']) . '?q=%QUERY',
                                                'wildcard' => '%QUERY'
                                            ],
                                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                            'display' => 'value',
                                            'templates' => [
                                                'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find any location for selected query.</div>',
                                                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                            ],
                                            'limit' => 20
                                        ]
                                    ],
                                    'pluginEvents' => [
                                        "typeahead:select" => "function(e, data) {
                                        console.log(data);
                                        var data_arr = data.id.split('_');
                                        if(data_arr.length==1){
                                            tempState = data_arr[0];
                                        }else if(data_arr.length==2){
                                            tempState = data_arr[1];
                                            tempTown = data_arr[0];
                                        }
                                        else if(data_arr.length==3){
                                            tempState = data_arr[2];
                                            tempTown = data_arr[1];
                                            tempArea = data_arr[0];
                                            
                                        }
                                        
                                        $('.txt_filter_street_address').val('');
                                        $('.txt_filter_street_number').val('');
                                        $('.txt_filter_appartment_unit').val('');
                                        $('.hid_location_suggestion').val(data.value);
                                        $('.frm_search_result_page_search').submit();
                                      }"
                                    ]
                                ]);
                              ?>
                                <div class="disabled_element_cover" style="position:absolute; left:0; right:0; top:0; bottom:0;"></div>
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="property-menu-list">
                            <div class="dropdown property-type-menu prop_category_dropdown">
                              <button class="dropdown-toggle btn_filter_by_prop_category" type="button" data-toggle="dropdown"><span class="btntext">Category</span>
                                <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="property_type_option_group">
                                        <li>
                                            <?php 
                                            $propertyCategories = PropertyCategory::find()->active()->all();
                                            foreach($propertyCategories as $cat){
                                                $checked = '';
                                                if(is_array($categories)){
                                                    if(in_array($cat->id, $categories)){
                                                        $checked = 'checked';
                                                    }
                                                }elseif($categories == $cat->id){
                                                    $checked = 'checked';
                                                }
                                            ?>
                                            <div class="custom-check-radio">
                                                <label>
                                                    <input type="checkbox" value="<?= $cat->id?>" data-text_val="<?= $cat->title?>" name="chk_filter_property_category[]" class="chk_filter_prop_category" <?php echo $checked;?>>
                                                    <span class="lbl"><?= $cat->title?></span>
                                                </label>
                                            </div>
                                            <?php }?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown any-price-menu">
                              <button class="dropdown-toggle btn_filter_by_price" type="button" data-toggle="dropdown"><span class="btntext">Any Price</span>
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <div class="form-inline">
                                        <div class="row">
                                            <div class="col-sm-5 pright">
                                                <div class="input-group">
                                                    <span class="input-group-addon">N</span>
                                                    <input type="text" class="form-control txt_filter_min_price" value="<?php if($minPrice)echo $minPrice?>" placeholder="No Min">
                                                </div>
                                            </div>

                                            <div class="col-sm-1 pleft pright text-center">-</div>

                                            <div class="col-sm-5 pleft">
                                                <div class="input-group">
                                                    <span class="input-group-addon">N</span>
                                                    <input type="text" class="form-control txt_filter_max_price"  value="<?php if($maxPrice)echo $maxPrice?>" placeholder="No Max">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <ul class="pull-left min_price_option_group">
                                        <li><a href="javascript:void(0)" data-val="">N0</a></li>
                                        <li><a href="javascript:void(0)" data-val="100000">N100K</a></li>
                                        <li><a href="javascript:void(0)" data-val="250000">N250K</a></li>
                                        <li><a href="javascript:void(0)" data-val="500000">N500K</a></li>
                                        <li><a href="javascript:void(0)" data-val="750000">N750K</a></li>
                                        <li><a href="javascript:void(0)" data-val="1000000">N1M</a></li>
                                        <li><a href="javascript:void(0)" data-val="2000000">N2M</a></li>
                                        <li><a href="javascript:void(0)" data-val="5000000">N5M</a></li>
                                        <li><a href="javascript:void(0)" data-val="10000000">N10M</a></li>
                                        <li><a href="javascript:void(0)" data-val="20000000">N20M</a></li>
                                        <li><a href="javascript:void(0)" data-val="40000000">N40M</a></li>
                                        <li><a href="javascript:void(0)" data-val="50000000">N50M</a></li>
                                        <li><a href="javascript:void(0)" data-val="60000000">N60M</a></li>
                                        <li><a href="javascript:void(0)" data-val="80000000">N80M</a></li>
                                        <li><a href="javascript:void(0)" data-val="100000000">N100M</a></li>
                                    </ul>

                                    <ul class="pull-right max_price_option_group" style="visibility: hidden;">
                                        <li><a href="javascript:void(0)" data-val="100000">N100K</a></li>
                                        <li><a href="javascript:void(0)" data-val="250000">N250K</a></li>
                                        <li><a href="javascript:void(0)" data-val="500000">N500K</a></li>
                                        <li><a href="javascript:void(0)" data-val="750000">N750K</a></li>
                                        <li><a href="javascript:void(0)" data-val="1000000">N1M</a></li>
                                        <li><a href="javascript:void(0)" data-val="2000000">N2M</a></li>
                                        <li><a href="javascript:void(0)" data-val="5000000">N5M</a></li>
                                        <li><a href="javascript:void(0)" data-val="10000000">N10M</a></li>
                                        <li><a href="javascript:void(0)" data-val="20000000">N20M</a></li>
                                        <li><a href="javascript:void(0)" data-val="40000000">N40M</a></li>
                                        <li><a href="javascript:void(0)" data-val="50000000">N50M</a></li>
                                        <li><a href="javascript:void(0)" data-val="60000000">N60M</a></li>
                                        <li><a href="javascript:void(0)" data-val="80000000">N80M</a></li>
                                        <li><a href="javascript:void(0)" data-val="100000000">N100M</a></li>
                                        <li><a href="javascript:void(0)" data-val="">Any</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dropdown bedroom_dropdown">
                              <button class="dropdown-toggle btn_filter_by_bedroom" type="button" data-toggle="dropdown"><span class="btntext"><?php if($bedroom)echo $bedroom. '+ Beds';else echo 'Any Beds'?></span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="bedroom_option_group">
                                        <li><a href="javascript:void(0)" data-val="">Any</a></li>
                                        <li><a href="javascript:void(0)" data-val="1">1+</a></li>
                                        <li><a href="javascript:void(0)" data-val="2">2+</a></li>
                                        <li><a href="javascript:void(0)" data-val="3">3+</a></li>
                                        <li><a href="javascript:void(0)" data-val="4">4+</a></li>
                                        <li><a href="javascript:void(0)" data-val="5">5+</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dropdown bathroom_dropdown">
                              <button class="dropdown-toggle btn_filter_by_bathroom" type="button" data-toggle="dropdown"><span class="btntext"><?php if($bathroom)echo $bathroom. '+ Baths';else echo 'Any Baths'?></span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="bathroom_option_group">
                                        <li><a href="javascript:void(0)" data-val="">Any</a></li>
                                        <li><a href="javascript:void(0)" data-val="1">1+</a></li>
                                        <li><a href="javascript:void(0)" data-val="2">2+</a></li>
                                        <li><a href="javascript:void(0)" data-val="3">3+</a></li>
                                        <li><a href="javascript:void(0)" data-val="4">4+</a></li>
                                        <li><a href="javascript:void(0)" data-val="5">5+</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="dropdown garage_dropdown">
                              <button class="dropdown-toggle btn_filter_by_garage" type="button" data-toggle="dropdown"><span class="btntext"><?php if($garage)echo $garage. '+ Garages';else echo 'Any Garages'?></span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="garage_option_group">
                                        <li><a href="javascript:void(0)" data-val="">Any</a></li>
                                        <li><a href="javascript:void(0)" data-val="1">1+</a></li>
                                        <li><a href="javascript:void(0)" data-val="2">2+</a></li>
                                        <li><a href="javascript:void(0)" data-val="3">3+</a></li>
                                        <li><a href="javascript:void(0)" data-val="4">4+</a></li>
                                        <li><a href="javascript:void(0)" data-val="5">5+</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dropdown property-type-menu property_type_dropdown">
                              <button class="dropdown-toggle btn_filter_by_prop_type" type="button" data-toggle="dropdown"><span class="btntext">Property Type</span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="property_type_option_group">
                                        <li>
                                            <?php 
                                            $propertyTypes = \common\models\PropertyType::find()->active()->all();
                                            foreach($propertyTypes as $type){
                                            ?>
                                            <div class="custom-check-radio">
                                                <label>
                                                    <input type="checkbox" value="<?= $type->id?>" data-text_val="<?= $type->title?>" name="chk_filter_property_type[]" class="chk_filter_property_type" <?php if(in_array($type->id, $propTypes)) echo 'checked';?>>
                                                    <span class="lbl"><?= $type->title?></span>
                                                </label>
                                            </div>
                                            <?php }?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown property-type-menu property_const_status_dropdown">
                              <button class="dropdown-toggle btn_filter_by_const_status" type="button" data-toggle="dropdown"><span class="btntext">Construction Status</span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="property_const_status_option_group">
                                        <li>
                                            <?php 
                                            $propertyConstStatuses = ConstructionStatusMaster::find()->active()->all();
                                            foreach($propertyConstStatuses as $constStatus){
                                            ?>
                                            <div class="custom-check-radio">
                                                <label>
                                                    <input type="checkbox" value="<?= $constStatus->id?>" data-text_val="<?= $constStatus->title?>" name="chk_filter_property_const_status[]" class="chk_filter_property_const_status" <?php if(in_array($constStatus->id, $constStatuses)) echo 'checked';?>>
                                                    <span class="lbl"><?= $constStatus->title?></span>
                                                </label>
                                            </div>
                                            <?php }?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown property-type-menu property_market_status_dropdown">
                              <button class="dropdown-toggle btn_filter_by_market_status" type="button" data-toggle="dropdown"><span class="btntext">Market Status</span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <ul class="property_market_status_option_group">
                                        <li>
                                            <?php 
                                            $marketStatuses = ['Active', 'Pending', 'Sold'];
                                            foreach($marketStatuses as $marketStatus){
                                            ?>
                                            <div class="custom-check-radio">
                                                <label>
                                                    <input type="checkbox" value="<?= $marketStatus?>" data-text_val="<?= $marketStatus?>" name="chk_filter_property_market_status[]" class="chk_filter_property_market_status" <?php if(in_array($marketStatus, $marktStatuses)) echo 'checked';?>>
                                                    <span class="lbl"><?= $marketStatus?></span>
                                                </label>
                                            </div>
                                            <?php }?>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dropdown property_more_filters">
                              <button class="dropdown-toggle btn_filter_by_more" type="button"><span class="btntext">More Filters</span>
                                    <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                    <div class="form-sec">
                                        <div class="row">
                                            <h5>Property Basic info</h5>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label>Property ID</label>
                                                        <?= Html::textInput('property_id', $propertyID, ['class' => 'form-control txt_filter_property_id search_item'])?>
                                                    </div>
                                                    <div class="col-sm-4 more-search-checkbox">
                                                        <label for="">
                                                            <?php
                                                            if(!empty($soleMandate)){
                                                                echo Html::checkbox('sole_mandate', true, ['class' => 'chk_filter_sole_mandate search_item']);
                                                            }else{
                                                                echo Html::checkbox('sole_mandate', false, ['class' => 'chk_filter_sole_mandate search_item']);
                                                            }
                                                            ?>
                                                            Sole Mandate
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-4 more-search-checkbox">
                                                        <label for="">
                                                            <?php
                                                            if(!empty($featuredListing)){
                                                                echo Html::checkbox('featured_listing', true, ['class' => 'chk_filter_featured_listing search_item']);
                                                            }else{
                                                                echo Html::checkbox('featured_listing', false, ['class' => 'chk_filter_featured_listing search_item']);
                                                            }
                                                            ?>
                                                            Featured Listing
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5>Property Location & Landmark</h5>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="">State:</label>
                                                    <?php
                                                    echo Html::dropDownList('multi_state', $state, ArrayHelper::map(LocationSuggestion::find()->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all(), 'state', 'state'), ['id' => "multiXX1", 'class' => "txt_filter_state search_item", 'prompt' => 'Not selected']);

                                                    $js = "$(function(){
                                                            $('#multiXX1').multiselect({
                                                                enableFiltering:true,
                                                                enableCaseInsensitiveFiltering:true,
                                                                onChange:
                                                                function(option, checked, select) {
                                                                    $.loading();
                                                                    $('#multiXX3').empty();
                                                                    $('#multiXX3').multiselect('rebuild');
                                                                    $('option', $('#multiXX4')).remove();
                                                                    $('#multiXX4').multiselect('rebuild');
                                                                    $('#multiXX6').empty();
                                                                    $('#multiXX6').multiselect('rebuild');
                                                                    var state = $(option).val();
                                                                    $.post('".Url::to(['location-suggestion/get-town-and-lga'])."', {selected_state:state}, function(response){
                                                                        $.loaded();
                                                                        $('.hid_temp_state').val(state);
                                                                        $('#typeAheadXX1').typeahead('val', state);
                                                                        $('#typeAheadXX1').prop('disabled', false);
                                                                        $('#multiXX2').multiselect('dataprovider', response.output.towns);
                                                                        $('#multiXX5').multiselect('dataprovider', response.output.lgas);
                                                                        if(tempTown!=''){
                                                                             $('#multiXX2').multiselect('select',tempTown,true);
                                                                             tempTown='';
                                                                        }
                                                                    }, 'json');
                                                                }
                                                            });
                                                        });";
                                                    $this->registerJs($js, View::POS_END);

                                                    ?>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="">Town:</label>
                                                    <?php 
                                                    echo Html::dropDownList('multi_town', $town, ArrayHelper::map(LocationSuggestion::find()->where(['state' => $state])->select('city')->distinct()->orderBy(['city' => SORT_ASC])->all(), 'city', 'city'), ['id' => "multiXX2", 'class' => 'txt_filter_town search_item', 'multiple' => "multiple"]);
                                                    $js = "$(function(){
                                                            $('#multiXX2').multiselect({
                                                                enableFiltering:true,
                                                                enableCaseInsensitiveFiltering:true,
                                                                numberDisplayed:2,
                                                                disableIfEmpty: true,
//                                                                onDropdownHide:
                                                                onChange:
                                                                function(event){
                                                                    $.loading();
                                                                    var towns = $('#multiXX2 option:selected');
                                                                    var selected = [];
                                                                    $(towns).each(function(index, val){
                                                                        selected.push($(this).val());
                                                                    });
                                                                    $.post('".Url::to(['location-suggestion/get-area-and-zip'])."', {selected_cities:selected}, function(response){
                                                                        $.loaded();
                                                                        var location;
                                                                        if(selected.length == 0){
                                                                            $('.hid_temp_town').val('');
                                                                            location = $('.hid_temp_state').val();
                                                                            $('#typeAheadXX1').prop('disabled', false);
                                                                            $('#typeAheadXX1').typeahead('val', location);
                                                                        }else if(selected.length == 1){
                                                                            $('.hid_temp_town').val(selected[0]);
                                                                            location = selected[0]+ ', '+ $('.hid_temp_state').val();
                                                                            $('#typeAheadXX1').prop('disabled', false);
                                                                            $('#typeAheadXX1').typeahead('val', location);
                                                                        }else{
                                                                            $('.hid_temp_town').val('');
                                                                            $('#typeAheadXX1').val('Multiple location selected').prop('disabled', true);
                                                                        }
                                                                        $('#multiXX3').multiselect('dataprovider', response.output.areas);
                                                                        $('#multiXX4').multiselect('dataprovider', response.output.zips);
                                                                        if(tempArea!=''){
                                                                             $('#multiXX3').multiselect('select',tempArea);
                                                                             tempArea='';
                                                                        }
                                                                    }, 'json');
                                                                }
                                                            });
                                                        });";
                                                    $this->registerJs($js, View::POS_END);  

                                                    ?>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="">Area:</label>
                                                    <?php 
                                                    $areaData = [];
                                                    $areaEmpty = false;
                                                    if($town){
                                                        $areaRS = LocationSuggestion::find()->where(['city' => $town])->select('area')->distinct()->orderBy(['area' => SORT_ASC])->all();
                                                        foreach($areaRS as $rs){
                                                            if(trim($rs->area)){
                                                                $areaData = array_merge($areaData, [$rs->area => $rs->area]);
                                                            }
                                                        }
                                                    }
                                                    
                                                    if(empty($areaData)){
                                                        $areaData = ['Area'];
                                                        $areaEmpty = true;
                                                    }
                                                    echo Html::dropDownList('multi_area', $area, $areaData, ['id' => "multiXX3", 'class' => 'txt_filter_area search_item', 'multiple' => "multiple", 'disabled' => $areaEmpty]);
//                                                    
                                                    $js = "$(function(){
                                                            $('#multiXX3').multiselect({
                                                                enableFiltering:true,
                                                                enableCaseInsensitiveFiltering:true,
                                                                disableIfEmpty: true,
                                                                numberDisplayed:2,
                                                                //onDropdownHide:
                                                                onChange:
                                                                function(event){
                                                                    var location = '';
                                                                    var areas = $('#multiXX3 option:selected');
                                                                    var selected = [];
                                                                    $(areas).each(function(index, val){
                                                                        selected.push($(this).val());
                                                                    });
                                                                    if(selected.length == 0){
                                                                        $('.hid_temp_area').val('');
                                                                        location = $('.hid_temp_town').val()+ ', '+ $('.hid_temp_state').val();
                                                                        $('#typeAheadXX1').prop('disabled', false);
                                                                        $('#typeAheadXX1').typeahead('val', location);
                                                                    }else if(selected.length == 1 && $('.hid_temp_town').val()){
                                                                        $('.hid_temp_area').val(selected[0]);
                                                                        location = selected[0]+ ', '+ $('.hid_temp_town').val()+ ', '+ $('.hid_temp_state').val();
                                                                        $('#typeAheadXX1').prop('disabled', false);
                                                                        $('#typeAheadXX1').typeahead('val', location);
                                                                        
                                                                    }else{
                                                                        $('.hid_temp_area').val('');
                                                                        $('#typeAheadXX1').val('Multiple location selected').prop('disabled', true);
                                                                    }
                                                                }
                                                            });
                                                        });";
                                                        $this->registerJs($js, View::POS_END);  

                                                    ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="">Zip Code:</label>
                                                    <?php 
                                                    $zipData = [];
                                                    $zipEmpty = false;
                                                    if ($town) {
                                                        $zipRS = LocationSuggestion::find()->where(['city' => $town])->select('zip_code')->distinct()->orderBy(['zip_code' => SORT_ASC])->all();
                                                        foreach ($zipRS as $rs) {
                                                            if (trim($rs->zip_code)) {
                                                                $zipData = array_merge($zipData, [$rs->zip_code => $rs->zip_code]);
                                                            }
                                                        }
                                                    }

                                                    if (empty($zipData)) {
                                                        $zipData = ['Zip Code'];
                                                        $zipEmpty = true;
                                                    }
                                                    
                                                    echo Html::dropDownList('multi_zip', '', $zipData, ['id' => "multiXX4", 'class' => 'txt_filter_zip_code search_item', 'multiple' => "multiple", 'disabled' => $zipEmpty,]);
//                                                    
                                                    $js = "$(function(){
                                                        $('#multiXX4').multiselect({
                                                            enableFiltering:true,
                                                            enableCaseInsensitiveFiltering:true,
                                                            disableIfEmpty: true,
                                                            numberDisplayed:2,
                                                        });
                                                    });";
                                                    $this->registerJs($js, View::POS_END);
                                                        
                                                    ?>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="">Local Government Area:</label>
                                                    <?php 
                                                    
                                                    echo Html::dropDownList('multi_lga', '', ArrayHelper::map(LocationSuggestion::find()->where(['state' => $state])->select('local_government_area')->distinct()->orderBy(['local_government_area' => SORT_ASC])->all(), 'local_government_area', 'local_government_area'), ['id' => "multiXX5", 'class' => 'txt_filter_local_govt_area search_item', 'multiple' => "multiple"]);
//                                                    
                                                    $js = "$(function(){
                                                        $('#multiXX5').multiselect({
                                                            enableFiltering:true,
                                                            enableCaseInsensitiveFiltering:true,
                                                            disableIfEmpty: true,
                                                            numberDisplayed:2,
                                                            onDropdownHide:
                                                                function(event){
                                                                    $.loading();
                                                                    var lgeas = $('#multiXX5 option:selected');
                                                                    var selected = [];
                                                                    $(lgeas).each(function(index, brand){
                                                                        selected.push($(this).val());
                                                                    });
                                                                    $.post('".Url::to(['location-suggestion/get-district-multi-lga'])."', {selected_lgaes:selected}, function(response){
                                                                        $.loaded();
                                                                        $('#multiXX6').multiselect('dataprovider', response.output.districts);
                                                                    }, 'json');
                                                                }
                                                        });
                                                    });";
                                                    $this->registerJs($js, View::POS_END);
                                                    ?>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="">District:</label>
                                                    <?php 
                                                    
                                                    echo Html::dropDownList('multi_district', '', [], ['id' => "multiXX6", 'class' => 'txt_filter_district', 'multiple' => "multiple", 'disabled' => true]);
//                                                    
                                                    $js = "$(function(){
                                                        $('#multiXX6').multiselect({
                                                            enableFiltering:true,
                                                            enableCaseInsensitiveFiltering:true,
                                                            disableIfEmpty: true,
                                                            numberDisplayed:2,
                                                        });
                                                    });";
                                                    $this->registerJs($js, View::POS_END);
                                                    
                                                    ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="">Street Name:</label>
                                                        <?= Html::textInput('street_address', $streetAddress, ['class' => 'form-control txt_filter_street_address search_item', 'placeholder' => 'e.g Inner Block street'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">House Number:</label>
                                                        <?= Html::textInput('street_number', $streetNumber, ['class' => 'form-control txt_filter_street_number search_item', 'placeholder' => 'e.g 1234'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">Apartment/Unit/Suite Number #:</label>
                                                        <?= Html::textInput('appartment_unit', $appartmentUnit, ['class' => 'form-control txt_filter_appartment_unit search_item', 'placeholder' => 'e.g 100'])?>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5>Property Info</h5>
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-sm-4">
                                                        <label for="">Lot Size:</label>
                                                        <?= Html::textInput('lot_size', $lotSize, ['class' => 'form-control txt_filter_lot_size search_item', 'placeholder' => 'Min - Max'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">Building Size:</label>
                                                        <?= Html::textInput('building_size', $buildingSize, ['class' => 'form-control txt_filter_building_size search_item', 'placeholder' => 'Min - Max'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">House / Apartment / Unit Size:</label>
                                                        <?= Html::textInput('house_size', $houseSize, ['class' => 'form-control txt_filter_house_size search_item', 'placeholder' => 'Min - Max'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">No of Toilets:</label>
                                                        <?= Html::dropDownList('no_of_toilet', $noOfToilet, [1 => '1+', 2 => '2+', 3 => '3+', 4 => '4+', 5 => '5+'], ['class' => 'form-control txt_filter_no_of_toilet search_item', 'prompt' => 'Any'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">No of Boys Quarter:</label>
                                                        <?= Html::dropDownList('no_of_boys_quater', $noOfBoysQuater, [1 => '1+', 2 => '2+', 3 => '3+', 4 => '4+', 5 => '5+'], ['class' => 'form-control txt_filter_no_of_boys_quater search_item', 'prompt' => 'Any'])?>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">Year Built:</label>
                                                        <?= Html::textInput('year_built', $yearBuilt, ['class' => 'form-control txt_filter_year_built search_item', 'placeholder' => 'Min - Max'])?>
                                                    </div>

                                                </div>
                                            </div>

                                            <h5>Search by Office, Agent</h5>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="">Search by Office Name:</label>
                                                        <?php
                                                        $data = [];
                                                        $value = '';
                                                        if (isset($filters['officeName']) && $filters['officeName']) {
                                                            $data = [$filters['officeName'] => $filters['officeName']];
                                                            $value = $filters['officeName'];
                                                        }
                                                        echo Select2::widget([
                                                            'name' => 'officeName',
                                                            'value' => $value,
                                                            'data' => $data,
                                                            'maintainOrder' => true,
                                                            'options' => ['placeholder' => 'Office Name', 'multiple' => false, 'class' => 'property_search_office_name txt_filter_agency_name search_item', 'id' => 'property_search_office_name'],
                                                            'pluginOptions' => [
                                                                'maximumInputLength' => 10,
                                                                'allowClear' => true,
                                                                'minimumInputLength' => 3,
                                                                'ajax' => [
                                                                    'url' => Url::to(['/agency/search-by-name-json']),
                                                                    'dataType' => 'json',
                                                                    'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                                                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                                ]
                                                            ],
                                                            'pluginEvents' => [
                                                                "select2:select" => "function() { 
                                                                var name = $('#property_search_office_name').find('option:selected').text();
                                                                $.post('" . Url::to(['agency/populate-children-by-name-json']) . "', {name:name}, function(response){
                                                                    if(response.result){
                                                                        var result = response.result;
                                                                        var newID = new Option(result.text, result.id, true, true);
                                                                        $('#property_search_office_id').append(newID).trigger('change');
                                                                    }
                                                                }, 'json');
                                                            }",
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="">Search by Office ID:</label>
                                                        <?php
                                                        $data = [];
                                                        $value = '';
                                                        if (isset($filters['officeID']) && $filters['officeID']) {
                                                            $data = [$filters['officeID'] => $filters['officeID']];
                                                            $value = $filters['officeID'];
                                                        }
                                                        echo Select2::widget([
                                                            'name' => 'officeID',
                                                            'value' => $value,
                                                            'data' => $data,
                                                            'maintainOrder' => true,
                                                            'options' => ['placeholder' => 'Office ID', 'multiple' => false, 'class' => 'property_search_office_id txt_filter_agency_id search_item', 'id' => 'property_search_office_id'],
                                                            'pluginOptions' => [
                                                                'maximumInputLength' => 10,
                                                                'allowClear' => true,
                                                                'minimumInputLength' => 3,
                                                                'ajax' => [
                                                                    'url' => Url::to(['/agency/search-by-name-id-json']),
                                                                    'dataType' => 'json',
                                                                    'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#property_search_office_name").val()}; }'),
                                                                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                                ]
                                                            ],
                                                            'pluginEvents' => [
                                                                "select2:select" => "function() { 
                                                                var id = $('#property_search_office_id').val();
                                                                $.post('" . Url::to(['agency/populate-children-by-id-json']) . "', {id:id}, function(response){
                                                                    if(response.result){
                                                                        var result = response.result;
                                                                        var newName = new Option(result.text, result.name, true, true);
                                                                        $('#property_search_office_name').append(newName).trigger('change');
                                                                    }
                                                                }, 'json');
                                                            }",
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="">Search by Agent Name:</label>
                                                        <?php
                                                        $data = [];
                                                        $value = '';
//                                                        if (isset($filters['name']) && $filters['name']) {
//                                                            $data = [$filters['name'] => $filters['name']];
//                                                            $value = $filters['name'];
//                                                        }
                                                        echo Select2::widget([
                                                            'name' => 'agentName',
                                                            'value' => $value,
                                                            'data' => $data,
                                                            'maintainOrder' => true,
                                                            'options' => ['placeholder' => 'Name', 'multiple' => false, 'class' => 'property_search_agent_name txt_filter_agent_name search_item', 'id' => 'property_search_agent_name'],
                                                            'pluginOptions' => [
                                                                'maximumInputLength' => 10,
                                                                'allowClear' => true,
                                                                'minimumInputLength' => 3,
                                                                'ajax' => [
                                                                    'url' => Url::to(['/agent/search-by-name-json']),
                                                                    'dataType' => 'json',
                                                                    'data' => new JsExpression('function(term,page) { return {search:term}; }'),
                                                                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                                ]
                                                            ],
                                                            'pluginEvents' => [
                                                                "select2:select" => "function() { 
                                                                var name = $('#property_search_agent_name').find('option:selected').text();
                                                                $.post('" . Url::to(['/agent/populate-children-by-name-json']) . "', {name:name}, function(response){
                                                                    if(response.result){
                                                                        var result = response.result;
                                                                        var newID = new Option(result.text, result.id, true, true);
                                                                        $('#property_search_agent_id').append(newID).trigger('change');



                                                                        var office = result.office;
                                                                        var newOfficeName = new Option(office.name, office.name, true, true);
                                                                        $('#property_search_office_name').append(newOfficeName).trigger('change');
                                                                        var newOfficeID = new Option(office.id, office.id, true, true);
                                                                        $('#property_search_office_id').append(newOfficeID).trigger('change');
                                                                    }
                                                                }, 'json');
                                                            }",
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="">Search by Agent ID:</label>
                                                        <?php
                                                        $data = [];
                                                        $value = '';
//                                                        if (isset($filters['agentID']) && $filters['agentID']) {
//                                                            $data = [$filters['agentID'] => $filters['agentID']];
//                                                            $value = $filters['agentID'];
//                                                        }
                                                        echo Select2::widget([
                                                            'name' => 'agentID',
                                                            'value' => $value,
                                                            'data' => $data,
                                                            'maintainOrder' => true,
                                                            'options' => ['placeholder' => 'Agent ID', 'multiple' => false, 'class' => 'property_search_agent_id txt_filter_agent_id search_item', 'id' => 'property_search_agent_id'],
                                                            'pluginOptions' => [
                                                                'maximumInputLength' => 10,
                                                                'allowClear' => true,
                                                                'minimumInputLength' => 3,
                                                                'ajax' => [
                                                                    'url' => Url::to(['/agent/search-by-name-id-json']),
                                                                    'dataType' => 'json',
                                                                    'data' => new JsExpression('function(term,page) { return {search:term, parent:$("#property_search_agent_name").val()}; }'),
                                                                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                                                                ]
                                                            ],
                                                            'pluginEvents' => [
                                                                "select2:select" => "function() { 
                                                                var id = $('#property_search_agent_id').val();
                                                                $.post('" . Url::to(['/agent/populate-children-by-id-json']) . "', {id:id}, function(response){
                                                                    if(response.result){
                                                                        var result = response.result;
                                                                        $('#txt_agent_suggestion').val(result.name);
                                                                        var newName = new Option(result.text, result.name, true, true);
                                                                        $('#property_search_agent_name').append(newName).trigger('change');

                                                                        var office = result.office;
                                                                        var newOfficeName = new Option(office.name, office.name, true, true);
                                                                        $('#property_search_office_name').append(newOfficeName).trigger('change');
                                                                        var newOfficeID = new Option(office.id, office.id, true, true);
                                                                        $('#property_search_office_id').append(newOfficeID).trigger('change');
                                                                    }
                                                                }, 'json');
                                                            }",
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5>Search by Listing Date, Sold Date</h5>
                                            <div class="form-group">
                                                <label>Listing Date</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <?php 
                                                        echo '<label>From</label>';
                                                        echo DatePicker::widget([
                                                            'name' => 'listing_from_date',
//                                                            'value' => date('d-M-Y', strtotime('+2 days')),
                                                            'options' => ['placeholder' => 'Select listing from date', 'class' => 'txt_filter_listing_from_date search_item'],
                                                            'pluginOptions' => [
                                                                'autoclose' => true,
                                                                'format' => Yii::$app->params['dateFormatJs'],
                                                                'todayHighlight' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <?php 
                                                        echo '<label>To</label>';
                                                        echo DatePicker::widget([
                                                            'name' => 'listing_to_date',
//                                                            'value' => date('d-M-Y', strtotime('+2 days')),
                                                            'options' => ['placeholder' => 'Select listing to date', 'class' => 'txt_filter_listing_to_date search_item'],
                                                            'pluginOptions' => [
                                                                'autoclose' => true,
                                                                'format' => Yii::$app->params['dateFormatJs'],
                                                                'todayHighlight' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Sold Date</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <?php 
                                                        echo '<label>From</label>';
                                                        echo DatePicker::widget([
                                                            'name' => 'closing_from_date',
//                                                            'value' => date('d-M-Y', strtotime('+2 days')),
                                                            'options' => ['placeholder' => 'Select closing from date', 'class' => 'txt_filter_closing_from_date search_item'],
                                                            'pluginOptions' => [
                                                                'autoclose' => true,
                                                                'format' => Yii::$app->params['dateFormatJs'],
                                                                'todayHighlight' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <?php 
                                                        echo '<label>To</label>';
                                                        echo DatePicker::widget([
                                                            'name' => 'closing_to_date',
//                                                            'value' => date('d-M-Y', strtotime('+2 days')),
                                                            'options' => ['placeholder' => 'Select closing to date', 'class' => 'txt_filter_closing_to_date search_item'],
                                                            'pluginOptions' => [
                                                                'autoclose' => true,
                                                                'format' => Yii::$app->params['dateFormatJs'],
                                                                'todayHighlight' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5>Features</h5>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="">General Features:</label>
                                                        <?php echo Html::dropDownList('general_feature[]', $generals, ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'general'])->all(), 'id', 'name'), ['class' => 'form-control multiselect_dropdown txt_filter_general_feature search_item', 'multiple' => true])?>
                                                        
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">Exterior Features:</label>
                                                        <?php echo Html::dropDownList('exterior_feature[]', $exteriors, ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'exterior'])->all(), 'id', 'name'), ['class' => 'form-control multiselect_dropdown txt_filter_exterior_feature search_item', 'multiple' => true])?>
                                                        
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="">Interior Features:</label>
                                                        <?php echo Html::dropDownList('interior_feature[]', $interiors, ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'interior'])->all(), 'id', 'name'), ['class' => 'form-control multiselect_dropdown txt_filter_interior_feature search_item', 'multiple' => true])?>
                                                        
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button name="" type="button" class="btn btn-default gray-btn btn_filter_by_more_options_reset">Reset</button>
                                                <button name="" type="submit" class="btn btn-default gray-btn btn_filter_by_more_options_cancel">Cancel</button>
                                                <button name="" type="submit" class="btn btn-default red-btn btn_filter_by_more_options">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php if(!Yii::$app->user->isGuest){
                    if($source){
                        $savedSearchModel = \common\models\SavedSearch::findOne($source);
                    }else{
                        $savedSearchModel = new \common\models\SavedSearch();
                    }
                    ?>
                    <?php // if(1){?>
                    <button class="btn btn-default save-search-btn" type="button" data-toggle="modal" data-target="#mdl_save_property_search">Save Search</button>
                    <!-- Modal -->
                    <div class="modal fade" id="mdl_save_property_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Save Search</h4>
                          </div>
                          <div class="modal-body">
                              <div class="form-group">
                                  <label>Enter Name</label>
                                  <?= Html::activeTextInput($savedSearchModel, 'name', ['class' => 'txt_save_search_name form-control', 'placeholder' => 'e.g. Mr X Home search - Maitama'])?>
                                  <div class="error"></div>
                              </div>
                              <div class="form-group">
                                  <label>Who gets alerts? <span><a href="javascript:void(0)" class="add_more_alert_recipient"><i class="fa fa-plus-circle"></i></a></span></label>
                                  <div>
                                      <label>
                                          <?= Html::activeCheckbox($savedSearchModel, 'cc_self', ['class' => 'chk_save_search_cc_self'])?>
                                      </label>
                                      <div class="alert_recipient_holder">
                                          <?php if(!$savedSearchModel->isNewRecord && !empty($savedSearchModel->recipient)){?>
                                          <?php for ($i = 0; $i<count($savedSearchModel->recipient); $i++){?>
                                          <div class="form-group row item">
                                            <div class="col-sm-11">
                                                <?= Html::activeTextInput($savedSearchModel, "recipient[$i]", ['class' => 'form-control txt_save_search_recipient', 'required']);?>
                                            </div>
                                            <div class="col-sm-1">
                                                <!--<a href="javascript:void(0)" class="remove-recipient"><i class="fa fa-minus-circle"></i></a>-->
                                            </div>
                                          </div>
                                          <?php }}else{?>
                                          <div class="form-group row item">
                                            <div class="col-sm-11">
                                                <input type="text" name="SavedSearch[recipient][]" class="form-control txt_save_search_recipient" />
                                            </div>
                                            <div class="col-sm-1">
                                                <!--<a href="javascript:void(0)" class="remove-recipient"><i class="fa fa-minus-circle"></i></a>-->
                                            </div>
                                          </div>
                                          <?php }?>
                                      </div>
                                  </div>
                                  <div class="error"></div>
                              </div>
                              <div class="form-group">
                                  <label>Schedule Aler</label>
                                  <?= Html::activeDropDownList($savedSearchModel, 'schedule', ['never' => 'Never', 'asap' => 'ASAP', 'daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'], ['class' => 'sel_save_search_schedule_alert']) ?>
                                  <div class="error"></div>
                              </div>
                              <div class="form-group">
                                  <label>Message</label>
                                  <div>
                                      <?= Html::activeTextarea($savedSearchModel, 'message', ['class' => 'form-control txt_save_search_message', 'placeholder' => 'Your Message'])?>
                                  </div>
                                  <div class="error"></div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <?php if($source){?>
                            <button type="button" class="btn btn-primary btn_save_property_search" data-url="<?= Url::to(['realestate/update-save-search', 'id' => $source])?>">Update</button>
                            <button type="button" class="btn btn-primary btn_save_property_search" data-url="<?= Url::to(['realestate/save-search'])?>">Save As New Search</button>
                            <?php }else{?>
                            <button type="button" class="btn btn-primary btn_save_property_search" data-url="<?= Url::to(['realestate/save-search'])?>">Save</button>
                            <?php }?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php }?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$js = "$(function(){
        var min = $('.txt_filter_min_price').val();
        var max = $('.txt_filter_max_price').val();
        $('.btn_filter_by_price .btntext').text(getPriceButtonText(min, max));
        
        var btnText;
        
        if($('input[name=\'chk_filter_property_type[]\']:checked').length == 1){
            btnText = $(\"input[name='chk_filter_property_type[]']:checked\").data('text_val');
        }else if($(\"input[name='chk_filter_property_type[]']:checked\").length == 0){
            btnText = 'Property type';
        }else{
            btnText = 'Property type ('+ $(\"input[name='chk_filter_property_type[]']:checked\").length+')';
        }
        $('.btn_filter_by_prop_type .btntext').text(btnText);
        
        if($('input[name=\'chk_filter_property_const_status[]\']:checked').length == 1){
            btnText = $(\"input[name='chk_filter_property_const_status[]']:checked\").data('text_val');
        }else if($(\"input[name='chk_filter_property_const_status[]']:checked\").length == 0){
            btnText = 'Construction Status';
        }else{
            btnText = 'Construction Status ('+ $(\"input[name='chk_filter_property_const_status[]']:checked\").length+')';
        }
        $('.btn_filter_by_const_status .btntext').text(btnText);
        
        if($('input[name=\'chk_filter_property_market_status[]\']:checked').length == 1){
            btnText = $(\"input[name='chk_filter_property_market_status[]']:checked\").data('text_val');
        }else if($(\"input[name='chk_filter_property_market_status[]']:checked\").length == 0){
            btnText = 'Market Status';
        }else{
            btnText = 'Market Status ('+ $(\"input[name='chk_filter_property_market_status[]']:checked\").length+')';
        } 
        $('.btn_filter_by_market_status .btntext').text(btnText);
        
        if($('input[name=\'chk_filter_property_category[]\']:checked').length == 1){
            btnText = $(\"input[name='chk_filter_property_category[]']:checked\").data('text_val');
        }else if($(\"input[name='chk_filter_property_category[]']:checked\").length == 0){
            btnText = 'Category';
        }else{
            btnText = 'Category ('+ $(\"input[name='chk_filter_property_category[]']:checked\").length+')';
        } 
        $('.btn_filter_by_prop_category .btntext').text(btnText);
        

        $('.multiselect_dropdown').multiselect({
            'enableFiltering': true,
            'enableCaseInsensitiveFiltering': true,
        });
        
//        $('.disabled_element_cover').on('click', function(){
//            alert('hello');
//            $(this).hide();
//            $('.txt_location_suggestion').prop('disabled', false).focus();
//        });

        $(document).on('click', '.add_more_alert_recipient', function(){
            $('<div class=\"form-group row item\"><div class=\"col-sm-11\"><input type=\"text\" name=\"SavedSearch[recipient][]\" class=\"form-control txt_save_search_recipient\" /></div><div class=\"col-sm-1\"><a href=\"#\" class=\"remove-recipient\"><i class=\"fa fa-minus-circle\"></i></a></div></div>').appendTo('.alert_recipient_holder');
        });

        $(document).on('click', '.remove-recipient', function(){
            $(this).closest('.item').remove();
        });                                                              
    });";

$this->registerJs($js, View::POS_END);

$varJs = "var tempState='';var tempTown='';var tempArea=''; var loginPopupurl = '".Url::to(['site/login', 'popup' => 1])."';";
$this->registerJs($varJs, View::POS_HEAD);