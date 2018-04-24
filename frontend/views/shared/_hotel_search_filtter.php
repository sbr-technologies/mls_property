<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile(
    '@web/plugins/underscore.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/public_main/js/hotel_search.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
    ]
);
?>
<div class="property-menu-bar find-agent-menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="hotel-listing-form">
                    <form action="<?= Url::to(['/hotel-search-result'])?>" role="search" class="form-inline frm_search_result_page_search">
                        <input type="hidden" value="<?= $locationId?>" name="location" class="hid_hotel_search_location_id" />
                        <input type="hidden" class="hid_location_suggestion" value="<?= $location?>" />
                        <input type="hidden" class="hid_filter_hotel_rating" value="" />
                        <div class="form-group">
                            <!--<label for="">City, State or Zip:</label>-->
                            <?php // echo $location;die();
                                $template = '<div class="location-suggestion-item"><p class="location-type">{{location_type}}</p>' .
                                      '<p class="location-name">{{value}}</p>' .
                                      '</div>';

                                echo Typeahead::widget([
                                    'name' => '',
                                    'options' => ['placeholder' => 'New York, NY', 'class' => 'txt_location_suggestion'],
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
                                            ]
                                        ]
                                    ],
                                    'pluginEvents' => [
                                        "typeahead:select" => "function(e, data) {
                                          console.log(data);
                                          $('.hid_hotel_search_location_id').val(data.id);
                                          $('.hid_location_suggestion').val(data.value);
                                          $('.frm_search_result_page_search').submit();
                                      }"
                                    ]
                                ]);
                              ?>
                        </div>
                        <div class="form-group">
                          <input type="text" name="hotel_name" placeholder="Enter Hotel Name" class="form-control txt_filter_hotel_name" />
                        </div>
                        <button class="btn btn-default save-search-btn" type="submit">Modify Search</button>
                    </form>
                </div>

                <div class="property-menu-list">
                    <div class="dropdown">
                      <button class="dropdown-toggle btn_filter_by_rating" type="button" data-toggle="dropdown"><span class="btntext"><?php if($rating) echo $rating. ' Star';else echo 'Rating';?></span>
                        <span class="caret"></span></button>
                        <div class="dropdown-menu filter_hotel_by_rating">
                            <ul>
                                <li>
                                  <a href="javascript:void(0)" data-value="">Any</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"  data-value="1">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="2">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="3">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="4">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>    
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-value="5">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>    
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                  <div class="dropdown property-type-menu hotel_facilities_dropdown">
                          <button class="dropdown-toggle btn_filter_by_hotel_facilities" type="button" data-toggle="dropdown"><span class="btntext">Facilities</span>
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                                <ul class="property_type_option_group">
                                    <?php $facilityMaster = common\models\HotelFacilityMaster::find()->active()->all() ?>
                                    <?php  foreach ($facilityMaster as $facility){?>
                                    <li>
                                        <div class="custom-check-radio">
                                            <label>
                                              <input type="checkbox" value="<?= $facility->name?>" <?php if(in_array($facility->name, $facilities)) echo 'checked'; ?> data-text_val="<?= $facility->name?>" name="chk_filter_hotel_facilities[]" class="chk_filter_hotel_facilities">
                                                <span class="lbl"><?= $facility->name?></span>
                                            </label>
                                        </div>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = "$(function(){
        $('.txt_location_suggestion').val('".$location."');
        $('.txt_agent_suggestion').val('".$hotelName."');
        $('.hid_agent_search_location').val('".$locationId."');
            
        var btnText;
        if($(\"input[name='chk_filter_hotel_facilities[]']:checked\").length == 1){
            btnText = $(\"input[name='chk_filter_hotel_facilities[]']:checked\").data('text_val');
        }else if($(\"input[name='chk_filter_hotel_facilities[]']:checked\").length == 0){
            btnText = 'Facilities';
        }else{
            btnText = 'Facilities ('+ $(\"input[name='chk_filter_hotel_facilities[]']:checked\").length+')';
        }
        $('.btn_filter_by_hotel_facilities .btntext').text(btnText);
        
    });";

$this->registerJs($js, View::POS_END);