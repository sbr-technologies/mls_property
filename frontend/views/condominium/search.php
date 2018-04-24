<?php

use common\models\Property;
use frontend\helpers\PropertyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\helpers\StringHelper;
use common\models\User;
use common\models\Agency;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use kartik\select2\Select2;
use common\models\PropertyType;

$session = Yii::$app->session;

$session->set('locationId', $location);


$this->title = 'Condominium';
$properties = $dataProvider->getModels();
//PropertyHelper::filterListing($properties);
//$dataProvider->setTotalCount(count($properties));
//$dataProvider->setModels($properties);
//yii\helpers\VarDumper::dump($properties,12,1); exit;
//print_r($propTypes);die();

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
    '@web/public_main/js/condominium_search.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<section class="propertymenubar_holder">
    <!-- Property Menu Bar -->
    <div class="col-sm-12">
        <div class="property-search-bar pull-left" style="width: 25%">
            <div class="input-group">
                <?php
                // echo $location;die();
                $template = '<div class="location-suggestion-item"><p class="location-type">{{location_type}}</p>' .
                        '<p class="location-name">{{value}}</p>' .
                        '</div>';

                echo Typeahead::widget([
                    'name' => '',
                    'value' => $location,
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
                    <button class="btn btn-default search_condominium" type="submit" data-action="<?= Url::to(['condominium/search']) ?>"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="pull-left" style="width: 25%; padding: 12px 12px;">
            <?= Html::hiddenInput('prop_ids', implode(',', $propTypes), ['id' => 'hid_prop_types'])?>
            <?= Html::dropDownList('property_type_id', $propTypes, yii\helpers\ArrayHelper::map(PropertyType::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Property Type', 'id' => 'filter_condo_by_property_types', 'multiple' => true]);?>
        </div>
        <div class="pull-left" style="width: 30%; padding: 12px 12px;">
            <span><?= $dataProvider->totalCount ?> Condo sorted by</span>
            <select class="sort_property_by property-listing-select" data-action="<?= Url::to(['condominium/search']) ?>">
                <option value="newest" <?php if ($sortBy == 'newest') echo 'selected' ?>>Newest listings</option>
                <option value="name" <?php if ($sortBy == 'name') echo 'selected' ?>>Name</option>
                <option value="town" <?php if ($sortBy == 'town') echo 'selected' ?>>Town</option>
                <option value="area" <?php if ($sortBy == 'area') echo 'selected' ?>>Area</option>
            </select>
        </div>
        <div class="pull-left" style="width: 20%; padding: 12px 12px;">
            <?php 
            echo Select2::widget([
                'name' => 'condominium',
                'value' => '',
                'data' => \yii\helpers\ArrayHelper::map(Property::find()->condo()->all(), 'slug', 'building_name'),
                'options' => ['prompt' => 'Select Condominium', 'id' => 'sel_condominium_list', 'data-action' => Url::to(['condominium/view'])]
            ]);
            ?>
        </div>
    </div>
    <!-- Property Menu Bar -->
    <div class="inner-content-sec" style="display:inline-block; padding: 0 0 30px; width: 100%;">
        <div class="container">
            <div class="row" style="position: relative">
                <div id="xPopup" class="map-popup-box"></div>
                <div id="realestate_map_view_container" class="realestate_map_view_container" style="position: absolute; left: 0; top: 0; right: 33%; display: none;"></div>
                    <div class="property_search_result_container">
                    <div class="property-listing-top-title">
                        <div class="col-sm-9">
                        </div>
                        <div class="col-sm-3">
                        </div>
                    </div>
<!--                  <div class="clearfix"></div>-->
                  <!-- Property Listing Left bar -->
                  <div class="col-sm-9 search_result_left">
                      <?php $navLinks = [];
                        if (!empty($properties)) {
                            
                          foreach ($properties as $key => $property) {
                              if(isset($properties[$key + 1])){
                                $navLinks[$property->id]['next'] = $properties[$key + 1]->slug;
                              }
                              if(isset($properties[$key - 1])){
                                $navLinks[$property->id]['prev'] = $properties[$key - 1]->slug;
                              }
                          ?>
                          <div class="property-listing-sec listing_item" data-id="<?= $property->id?>">
                              <?php 
                              $dups = $property->duplicate;
                              if(!empty($dups)){ $dIndex = 2;?>
<!--                              <div class="duplicate-listing">
                                  <span>Multiple Listings found for this property:</span>
                                  <?php echo Html::a('Listing 1', Url::to(['property/view', 'slug' => $property->slug])) ?>
                                  <?php foreach($dups as  $dup){
                                     echo ' | '. Html::a('Listing '. $dIndex, Url::to(['property/view', 'slug' => $dup->slug]));
                                     $dIndex++;
                                  }?>
                              </div>-->
                              <?php }?>
                                <div class="property-listing condominium">
                                    <div class="col-sm-7 property-listing-left">
                                        <?php
                                        $photosArr = $property->photos;
                                        if(is_array($photosArr) && count($photosArr) > 0){
                                            foreach($photosArr as $photoKey => $photoVal){
                                                if($photoKey == 0){
                                                    if(isset($photoVal) && $photoVal != ''){
                                                        $alias = $photoVal->getImageUrl($photoVal::LARGE);
                                                        echo Html::img($alias,['class' => 'property-listing-img']);
                                                    }
                                                }
                                            }
                                        }else{
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'property-listing-img']);
                                        }
                                        ?>
                                        <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> <?= count($photosArr) ?></span>
                                        <div class="featurespopupslider">
                                            <?php
                                            $photos = $property->photos;
                                            foreach ($photos as $key => $photo) {
                                                if($key == 0){
                                                    $active     =   'active';
                                                }else{
                                                    $active     =   '';
                                                }
                                                if($key > 0){
                                                    if(isset($photo) && $photo != ''){
                                                        $alias = $photo->getImageUrl($photo::LARGE);
                                                        echo Html::img($alias,['class' => 'property-listing-img featuresimg']);
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 property-listing-right">
                                        <?php 
                                            $session   =   Yii::$app->session;
                                            $compProps = $session->get('comp_props');
                                        ?>
<!--                                        <div class="property-listing-save-icon">
                                            <?php if($compProps && in_array($property->id, $compProps)){?>
                                                <button type="button" class="lnk_add_to_compare" title="Added to compare" value="Added" data-value ="<?= $property->id ?>" data-url="<?= Url::to(['property/add-to-compare','id' => $property->id]) ?>"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                            <?php }else{?>
                                                <button type="button" class="lnk_add_to_compare" title="Add to compare" value="Compare" data-value ="<?= $property->id ?>" data-url="<?= Url::to(['property/add-to-compare','id' => $property->id]) ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <?php }?>
                                            <a href="javascript:void(0)" class="save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i></a>
                                        </div>-->
                                        <!--<h2><?php echo substr(Yii::$app->formatter->asCurrency($property->price), 0, -3); ?></h2>-->
                                        <h4>
                                            <?= $property->building_name; ?>
                                        </h4>
                                        <a href="javascript:void(0)" class="property-listing-refid">Property ID # <?= $property->referenceId ?></a>
                                        <p><?= substr($property->propertyTypes, 0, 45)?></p>
                                        <p><?= $property->formattedAddress?></p>
                                        <ul>
                                            <li><strong><i class="fa fa-bed" aria-hidden="true"></i></strong> Bedroom Range: <span><?php echo $property->bedroom_range; ?></span></li>
                                            <li><strong><i class="fa fa-bath" aria-hidden="true"></i></strong> Bathroom Range: <span><?php echo $property->bathroom_range ?></span></li>
                                            <li><strong><i class="fa fa-trello" aria-hidden="true"></i></strong> Toilet Range: <span><?php echo $property->toilet_range ?></span></li>
                                            <li><strong><i class="fa fa-glide-g" aria-hidden="true"></i></strong> Garage Range: <span><?php echo $property->parking_range ?></span></li>
                                            <li><strong><i class="fa fa-money" aria-hidden="true"></i></strong> Price Range: <span><?php echo $property->price_range; ?></span></li>
                                            <li><strong><i class="fa fa-home" aria-hidden="true"></i></strong> Available Units for Sale: <span><?php echo $property->unitsForSellCount; ?></span></li>
                                            <li><strong><i class="fa fa-home" aria-hidden="true"></i></strong> Available Units for Rent: <span><?php echo $property->unitsForRentCount; ?></span></li>
                                        </ul>
                                        <div class="listing-added-date" style="margin: auto"><i class="fa fa-calendar" aria-hidden="true"></i> added : <?= date("dS F Y",$property->created_at) ?></div>
                                        <a href="<?php echo Url::to(['condominium/view', 'slug' => $property->slug]) ?>" style="margin-top: 10px; display: inline-block">View Details</a>
                                    </div>
                                    <?php if($property->featured){echo '<div class="ribbon red"><span>Featured</span></div>';};?>
                                    <a href="<?php echo Url::to(['condominium/view', 'slug' => $property->slug]) ?>" class="details-block-link"></a>
                                </div>
                          </div>
                      <?php
                            }
                            ?>
                            <div class="property_pagination">
                                <?=
                                LinkPager::widget([
                                    'pagination' => $dataProvider->getPagination(),
                                ]);
                                ?>
                            </div>
                        <?php
                        }else{
                      ?>
                            <div class="alert alert-info margine10top">
                                <i class="fa fa-info"></i>
                                No Property found.
                            </div>
                            <p class="text-center">
                                <strong>
                                    Can't find what you're looking for? Pls 
                                    <a href="<?= Url::to(['property/request']) ?>"> Post a Request</a>
                                </strong>
                            </p> 
                      <?php  
                        }
                        Yii::$app->session->set('nav_links', $navLinks);
                      ?>
                  </div>
                  <!-- Property Listing Left bar -->
                  <!-- Property Listing right bar -->
                  <div class="col-sm-3 search_result_right_sidebar">
                      <?php
                      echo $this->render('//shared/_right_side_bar', []);
                      ?>
                  </div>
                  <!-- Property Listing right bar -->
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="compareCntId" value="<?= (isset($compProps)? count($compProps):0)?>" />
<a href="<?php echo Url::to(['property/compare-property']) ?>"  target="_blank" class="compare-count lnk_compare_property" data-url="" title="Compare" style='display: <?php if(!$compProps)echo 'none';else echo 'block'; ?>'>Compare <span id="totalCntDiv"><?= (isset($compProps)? count($compProps):0)?></span></a>

<script type="foo/bar" id='usageList'>
        <div class="map-popup-box-list">
            <a href="<%= detail_url %>" target="_blank">
                <img src="<%= feature_image %>" alt="">
                <div class="map-popup-box-list-content">
                        <p class="map-popup-box-list-content-txt"><%= address %></p>
                        <p class="map-popup-box-list-content-txt"><span><%= price%></span> <strong><%= bedroom%> bd <i class="fa fa-circle" aria-hidden="true"></i> <%= bathroom %> ba <i class="fa fa-circle" aria-hidden="true"></i> <%= area %></strong></p>
                </div>
            </a>
	</div>
</script>

<?php
$js = "$(function(){
        $('#filter_condo_by_property_types').multiselect({
            enableFiltering:true,
            numberDisplayed:2,
            onDropdownHide: function(event) {
                var types = $('#filter_condo_by_property_types option:selected');
                var selected = [];
                $(types).each(function(index, val){
                    selected.push($(this).val());
                });
                var sortBy = $('.sort_property_by').val();
                var loc = $('#typeAheadXX1').val();
                
                var url = '". Url::to(['condominium/search'])."';
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
                if(selected){
                    url = updateQueryStringParameter(url, 'prop_types', selected);
                }
                    
                if(sortBy){
                    url = updateQueryStringParameter(url, 'sort', sortBy);
                }
                window.location.href = url;
            }
        });
    })";

$this->registerJs($js, View::POS_END);