<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey'] ?>"></script>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\StaticBlock;
use common\models\StaticBlockLocationMaster;
use common\models\BannerType;
use common\models\Banner;
use common\models\Property;
use common\models\PropertyType;
use common\models\PropertyCategory;

$bannerType = BannerType::findByName('Home');
$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();
$blockLocation = StaticBlockLocationMaster::findByTitle('Home Page');
$searchOptionBuy = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Buy'])->active()->one();
$searchOptionRent = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Rent'])->active()->one();
$searchOptionShortLet = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Short Let'])->active()->one();
$searchOptionHotel = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Hotel & BNB'])->active()->one();

$controller = yii::$app->controller->id;
//echo $controller;
?>

<?php 
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
?>
<figure class="bannerwithsearch">
  <!-- Home Slider -->
  <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
      <?php
      if (!empty($banners)) {
          foreach ($banners as $key => $banner) {
              $bannerUrl = '';
              $photo = $banner->photo;
              $alias = $photo->getImageUrl();
              //echo Html::img($alias);
              if ($banner->property_id != '') {
                  $bProp = Property::findOne($banner->property_id);
                  if (!empty($bProp)) {
                      $bannerUrl = Url::to(['property/view', 'slug' => $bProp->slug]);
                  }
              }
              ?>
              <div class="item slider <?php echo $key == 0 ? 'active' : ''; ?>" style="background-image:url(<?php echo $photo->getImageUrl() ?>);">
                <a href="<?= $bannerUrl ?>">
                  <div class="slidercontent">
                    <div class="container">
                      <div class="figuretext"><?php echo $banner->title; ?></div>
                      <div class="figuretextbottom"><?php echo $banner->description; ?></div>
                    </div>
                  </div>
                </a>
              </div> 
              <?php
          }
      } else {
          ?>
          <div class="item slider active" style="background-image:url(<?php echo Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg') ?>);">
            <div class="slidercontent">
              <div class="container">
    <!--                            <div class="figuretext"><?php //echo Yii::$app->language == "ar" ? (!empty($banner->title_ar) ? $banner->title_ar : $banner->title) : $banner->title;  ?></div>
                  <div class="figuretextbottom"><?php //echo Yii::$app->language == "ar" ? (!empty($banner->description_ar) ? $banner->description_ar : $banner->description) : $banner->description;  ?></div>-->
              </div>
            </div>
          </div>   
          <?php
      }
      ?> 

    </div>
    <?php
    if (!empty($banners) && count($banners) > 1) {
        ?>
        <a class="left carousel-control" href="#slider" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
        <a class="right carousel-control" href="#slider" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        <?php
    }
    ?>

  </div>
  <!-- Home Slider -->

  <!-- Home Search Form -->
  <div class="searchhome">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-push-1">
          <div class="searchholder clearfix">
            <div class="searchtopbar">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?= $type == 'property' ? "active" : "" ?>"><a href="#buy" aria-controls="buy" role="tab" data-toggle="tab"><?= $searchOptionBuy->title ? $searchOptionBuy->title : "" ?></a></li>
                <li role="presentation" class="<?= $type == 'rental' ? "active" : "" ?>"><a href="#rent" aria-controls="rent" role="tab" data-toggle="tab"><?= $searchOptionRent->title ? $searchOptionRent->title : "" ?></a></li>
                <li role="presentation" class="<?= $type == 'short_let' ? "active" : "" ?>"><a href="#short_let" aria-controls="short_let" role="tab" data-toggle="tab"><?= $searchOptionShortLet->title ? $searchOptionShortLet->title : "" ?></a></li>
                <li role="presentation" class="<?= $type == 'hotel' ? "active" : "" ?>"><a href="#sell" aria-controls="sell" role="tab" data-toggle="tab"><?= $searchOptionHotel->title ? $searchOptionHotel->title : "" ?></a></li>
              </ul>
            </div>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane <?= $type == 'property' ? "active" : "" ?>" id="buy">
                <div class="row">
                  <div class="searchbox clearfix form-group-md">
                    <?php echo $this->render('//shared/_location_suggestion'); ?>
                    <?= Html::beginForm(['realestate/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search', 'id' => 'buy_property_form']) ?>  
                    <div class="button_holder">

                    <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location']) ?>
                    <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_realestate']) ?>

                    </div>
                    <div class="clearfix">
                      <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                      <div class="adventure-search-box">
                        <a href="javascript:void(0)" class="adventure-search-close"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                        <h3>Advanced Search</h3>
                        <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select name="" class="selectpicker adv_min_price form-control">
                                  <option value="">Min Price</option>
                                  <option value="100000">N100K</option>
                                  <option value="250000">N250K</option>
                                  <option value="500000">N500K</option>
                                  <option value="750000">N750K</option>
                                  <option value="1000000">N1M</option>
                                  <option value="2000000">N2M</option>
                                  <option value="5000000">N5M</option>
                                  <option value="10000000">N10M</option>
                                  <option value="20000000">N20M</option>
                                  <option value="40000000">N40M</option>
                                  <option value="50000000">N50M</option>
                                  <option value="60000000">N60M</option>
                                  <option value="80000000">N80M</option>
                                  <option value="100000000">N100M</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select name="" class="selectpicker adv_max_price form-control">
                                  <option value="">Max Price</option>
                                  <option value="100000">N100K</option>
                                  <option value="250000">N250K</option>
                                  <option value="500000">N500K</option>
                                  <option value="750000">N750K</option>
                                  <option value="1000000">N1M</option>
                                  <option value="2000000">N2M</option>
                                  <option value="5000000">N5M</option>
                                  <option value="10000000">N10M</option>
                                  <option value="20000000">N20M</option>
                                  <option value="40000000">N40M</option>
                                  <option value="50000000">N50M</option>
                                  <option value="60000000">N60M</option>
                                  <option value="80000000">N80M</option>
                                  <option value="100000000">N100M</option>
                                </select>
                              </div>
                            </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <select name="" class="selectpicker adv_bedroom form-control">
                                <option value="">Bedroom</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <select name="" class="selectpicker adv_bathroom form-control">
                                <option value="">Bathroom</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('property_type_id', '', yii\helpers\ArrayHelper::map(PropertyType::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Property Type', 'class' => 'adv_property_type multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('construction_status', '', yii\helpers\ArrayHelper::map(\common\models\ConstructionStatusMaster::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Construction Status', 'class' => 'adv_construction_status multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('market_status', [Property::MARKET_ACTIVE], [Property::MARKET_ACTIVE => Property::MARKET_ACTIVE, Property::MARKET_PENDING => Property::MARKET_PENDING, Property::MARKET_SOLD => Property::MARKET_SOLD] , ['data-placeholder' => 'Market Status', 'class' => 'adv_market_status multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::textInput('reference_id', '',  ['placeholder' => 'Property ID', 'class' => 'form-control adv_propertyid']);?>
                            </div>
                          </div>
                        </div> <!-- Row End-->
                        <div class="row">
                            <div class="col-sm-2 col-sm-push-5">
                            <div class="form-group">
                              <button name="" type="button" class="btn_search_realestate btn btn-primary red-btn">Search Now</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
<?= Html::endForm() ?>
                  </div>
                </div>
              </div>

              <div role="tabpanel" class="tab-pane <?= $type == 'rental' ? "active" : "" ?>" id="rent">
                <div class="row">
                  <div class="searchbox clearfix form-group-md">
                    <?php echo $this->render('//shared/_location_suggestion'); ?>
                      <?= Html::beginForm(['rental/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search', 'id' => 'buy_property_form']) ?>
                    <div class="button_holder">
                        <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location']) ?>
                        <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_realestate']) ?>
                    </div>
                    <div class="clearfix">
                      <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                      <div class="adventure-search-box">
                        <a href="javascript:void(0)" class="adventure-search-close"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                        <h3>Advanced Search</h3>
                        <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select name="" class="selectpicker adv_min_price form-control">
                                  <option value="">Min Price</option>
                                  <option value="100000">N100K</option>
                                  <option value="250000">N250K</option>
                                  <option value="500000">N500K</option>
                                  <option value="750000">N750K</option>
                                  <option value="1000000">N1M</option>
                                  <option value="2000000">N2M</option>
                                  <option value="5000000">N5M</option>
                                  <option value="10000000">N10M</option>
                                  <option value="20000000">N20M</option>
                                  <option value="40000000">N40M</option>
                                  <option value="50000000">N50M</option>
                                  <option value="60000000">N60M</option>
                                  <option value="80000000">N80M</option>
                                  <option value="100000000">N100M</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select name="" class="selectpicker adv_max_price form-control">
                                  <option value="">Max Price</option>
                                  <option value="100000">N100K</option>
                                  <option value="250000">N250K</option>
                                  <option value="500000">N500K</option>
                                  <option value="750000">N750K</option>
                                  <option value="1000000">N1M</option>
                                  <option value="2000000">N2M</option>
                                  <option value="5000000">N5M</option>
                                  <option value="10000000">N10M</option>
                                  <option value="20000000">N20M</option>
                                  <option value="40000000">N40M</option>
                                  <option value="50000000">N50M</option>
                                  <option value="60000000">N60M</option>
                                  <option value="80000000">N80M</option>
                                  <option value="100000000">N100M</option>
                                </select>
                              </div>
                            </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <select name="" class="selectpicker adv_bedroom form-control">
                                <option value="">Bedroom</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <select name="" class="selectpicker adv_bathroom form-control">
                                <option value="">Bathroom</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('property_type_id', '', yii\helpers\ArrayHelper::map(PropertyType::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Property Type', 'class' => 'adv_property_type multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('construction_status', '', yii\helpers\ArrayHelper::map(\common\models\ConstructionStatusMaster::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Construction Status', 'class' => 'adv_construction_status multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('market_status', [Property::MARKET_ACTIVE], [Property::MARKET_ACTIVE => Property::MARKET_ACTIVE, Property::MARKET_PENDING => Property::MARKET_PENDING, Property::MARKET_SOLD => Property::MARKET_SOLD] , ['data-placeholder' => 'Market Status', 'class' => 'adv_market_status multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                            <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::textInput('reference_id', '',  ['placeholder' => 'Property ID', 'class' => 'form-control adv_propertyid']);?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-sm-push-5">
                            <div class="form-group">
                              <button name="" type="button" class="btn_search_realestate btn btn-primary red-btn">Search Now</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
<?= Html::endForm() ?>
                  </div>
                </div>
              </div>
                
              <div role="tabpanel" class="tab-pane <?= $type == 'short_let' ? "active" : "" ?>" id="short_let">
                <div class="row">
                  <div class="searchbox clearfix form-group-md">
                    <?php echo $this->render('//shared/_location_suggestion'); ?>
                      <?= Html::beginForm(['rental/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search', 'id' => 'short_let_property_form']) ?>
                    <div class="button_holder">
                        <?= Html::hiddenInput('rent_type', 'short_let', ['class' => 'realestate_search_rent_type']) ?>
                        <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location']) ?>
                        <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_realestate']) ?>
                    </div>
                    <div class="clearfix">
                      <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                      <div class="adventure-search-box">
                        <a href="javascript:void(0)" class="adventure-search-close"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                        <h3>Advanced Search</h3>
                        <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select name="" class="selectpicker adv_min_price form-control">
                                  <option value="">Min Price</option>
                                  <option value="100000">N100K</option>
                                  <option value="250000">N250K</option>
                                  <option value="500000">N500K</option>
                                  <option value="750000">N750K</option>
                                  <option value="1000000">N1M</option>
                                  <option value="2000000">N2M</option>
                                  <option value="5000000">N5M</option>
                                  <option value="10000000">N10M</option>
                                  <option value="20000000">N20M</option>
                                  <option value="40000000">N40M</option>
                                  <option value="50000000">N50M</option>
                                  <option value="60000000">N60M</option>
                                  <option value="80000000">N80M</option>
                                  <option value="100000000">N100M</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select name="" class="selectpicker adv_max_price form-control">
                                  <option value="">Max Price</option>
                                  <option value="100000">N100K</option>
                                  <option value="250000">N250K</option>
                                  <option value="500000">N500K</option>
                                  <option value="750000">N750K</option>
                                  <option value="1000000">N1M</option>
                                  <option value="2000000">N2M</option>
                                  <option value="5000000">N5M</option>
                                  <option value="10000000">N10M</option>
                                  <option value="20000000">N20M</option>
                                  <option value="40000000">N40M</option>
                                  <option value="50000000">N50M</option>
                                  <option value="60000000">N60M</option>
                                  <option value="80000000">N80M</option>
                                  <option value="100000000">N100M</option>
                                </select>
                              </div>
                            </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <select name="" class="selectpicker adv_bedroom form-control">
                                <option value="">Bedroom</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <select name="" class="selectpicker adv_bathroom form-control">
                                <option value="">Bathroom</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('property_type_id', '', yii\helpers\ArrayHelper::map(PropertyType::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Property Type', 'class' => 'adv_property_type multiselect_dropdown form-control', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('construction_status', '', yii\helpers\ArrayHelper::map(\common\models\ConstructionStatusMaster::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Construction Status', 'class' => 'adv_construction_status multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::dropDownList('market_status', [Property::MARKET_ACTIVE], [Property::MARKET_ACTIVE => Property::MARKET_ACTIVE, Property::MARKET_PENDING => Property::MARKET_PENDING, Property::MARKET_SOLD => Property::MARKET_SOLD] , ['data-placeholder' => 'Market Status', 'class' => 'adv_market_status multiselect_dropdown', 'multiple' => true]);?>
                            </div>
                          </div>
                            <div class="col-sm-3">
                            <div class="form-group">
                              <?= Html::textInput('reference_id', '',  ['placeholder' => 'Property ID', 'class' => 'form-control adv_propertyid']);?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-sm-push-5">
                            <div class="form-group">
                              <button name="" type="button" class="btn_search_realestate btn btn-primary red-btn">Search Now</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
<?= Html::endForm() ?>
                  </div>
                </div>
              </div>

              <div role="tabpanel" class="tab-pane <?= $type == 'hotel' ? "active" : "" ?>" id="sell">
                <div class="row">
                  <div class="searchbox clearfix form-group-md">
                    <?php echo $this->render('//shared/_location_suggestion'); ?>
                      <?= Html::beginForm(['hotel/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search', 'id' => 'buy_property_form']) ?>
                    <div class="button_holder">
                      <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location']) ?>
<?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_hotel']) ?>
                    </div>
                    <div class="clearfix">
                      <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                      <div class="adventure-search-box">
                        <a href="javascript:void(0)" class="adventure-search-close"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                        <h3>Advanced Search</h3>
                        <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <select name="" class="selectpicker custom_select adv_user_rating form-control">
                                    <option value="">Rating</option>
                                    <option value="1">1+</option>
                                    <option value="2">2+</option>
                                    <option value="3">3+</option>
                                    <option value="4">4+</option>
                                    <option value="5">5</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-4 addvance_search_drop">
                                <div class="dropdown property-type-menu hotel_facilities_dropdown">
                                  <button class="dropdown-toggle btn btn-block btn-search-custom btn_filter_by_hotel_facilities" type="button" data-toggle="dropdown"><span class="btntext">Facilities</span>
                                    <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <ul class="property_type_option_group">
                                        <?php $facilityMaster = common\models\HotelFacilityMaster::find()->active()->all() ?>
                                        <?php  foreach ($facilityMaster as $facility){?>
                                        <li>
                                            <div class="custom-check-radio">
                                                <label>
                                                  <input type="checkbox" value="<?= $facility->name?>" data-text_val="<?= $facility->name?>" name="chk_filter_hotel_facilities[]" class="chk_filter_hotel_facilities">
                                                    <span class="lbl"><?= $facility->name?></span>
                                                </label>
                                            </div>
                                        </li>
                                        <?php }?>
                                    </ul>
                                  </div>
                                </div>
                            </div>
<!--                            <div class="col-sm-10">
                              <div class="form-group">
                                <?php // echo Html::dropDownList('property_type_id', '', yii\helpers\ArrayHelper::map(PropertyType::find()->where(['property_category_id' => PropertyCategory::CATEGORY_SELL])->active()->all(), 'id', 'title'));?>
                              </div>
                            </div>-->
                            <div class="col-sm-2">
                              <div class="form-group">
                                <button name="" type="button" class="btn btn-primary red-btn btn_search_hotel">Search Now</button>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
<?= Html::endForm() ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Home Search Form -->
</figure>

<?php
$js = "$(function(){
        $('.searchLink').click(function(){
            var thisForm = $(this).closest('form');
            thisForm.find('.adventure-search-box').slideDown();
        });
        $('.adventure-search-close').click(function(){
            var thisForm = $(this).closest('form');
            thisForm.find('.adventure-search-box').slideUp();
        });
        $('.multiselect_dropdown').multiselect();
    })";

$this->registerJs($js, View::POS_END);
