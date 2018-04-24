<?php 
use common\models\Property;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\helpers\PropertyHelper;
PropertyHelper::filterListing($properties);
?>
<div class="property-listing-top-title">
  <div class="col-sm-9">
  	<div class="breadcrumb-list">
            <ul>
                <li><a href="#"><?= $state?></a></li>
                <li><a href="#"><?= $city?> </a></li>
            </ul>
        </div>
    <div class="propery-listing-title-bar">

      <?php
      if (!empty($properties)) {
          ?>
          <h3 class="pull-left"><?= $location . ($propertyFor == 'Sale'?' Real Estate':' Apartment').' & Homes for '. $propertyFor ?></h3>
          <div class="pull-right propery-listing-title-bar-right"><span><?= count($properties) ?> Homes sorted by</span>
            <select class="pull-right sort_property_by property-listing-select">
              <option value="<?= Property::SORT_RELEVANT ?>" <?php if ($sortBy == Property::SORT_RELEVANT) echo 'selected' ?>>Relevant Listings</option>
              <option value="<?= Property::SORT_NEWEST ?>" <?php if ($sortBy == Property::SORT_NEWEST) echo 'selected' ?>>Newest Listings</option>
              <option value="<?= Property::SORT_LOWEST_PRICE ?>" <?php if ($sortBy == Property::SORT_LOWEST_PRICE) echo 'selected' ?>>Lowest Price</option>
              <option value="<?= Property::SORT_HIGHEST_PRICE ?>" <?php if ($sortBy == Property::SORT_HIGHEST_PRICE) echo 'selected' ?>>Highest Price</option>
              <option value="<?= Property::SORT_LARGEST_AREA ?>" <?php if ($sortBy == Property::SORT_LARGEST_AREA) echo 'selected' ?>>Largest Sqft</option>
            </select>
          </div>

          <?php
      }
      ?>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group clearfix">
      <a href="javascript:void(0)" class="btn btn-default pull-left realestate_search_map_view <?php if($viewType == 'map') echo 'active'?>">Map</a>
      <a href="javascript:void(0)" class="btn btn-default pull-left realestate_search_list_view <?php if($viewType == 'list') echo 'active'?>">List</a>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-9 search_result_left">
<?php
if (!empty($properties)) {
    foreach ($properties as $key => $property) {
        ?>
        <div class="property-listing-sec listing_item" data-id="<?= $property->id?>">
          <div class="property-listing">
              <div class="col-sm-7 property-listing-left">
                <?php
                $photosArr = $property->photos;
                if (is_array($photosArr) && count($photosArr) > 0) {
                    foreach ($photosArr as $photoKey => $photoVal) {
                        if ($photoKey == 0) {
                            if (isset($photoVal) && $photoVal != '') {
                                $alias = $photoVal->getImageUrl($photoVal::LARGE);
                                echo Html::img($alias, ['class' => 'property-listing-img']);
                            } else {
                                Html::img(Yii::getAlias('@backend/web/images/banner_image/no-preview.jpg'));
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
                <div class="property-listing-left-bottom">
                    <div class="property-listing-left-bottom-left">
                        <?php 
                            $agency = $property->user->agency;
                            if(!empty($agency)){
                                if(!empty($agency->photos[0])){ 
                                ?>
                                    <img src="<?= $property->user->agency->photos[0]->imageUrl ?>" alt="" >
                                <?php
                                }?>
                                <p><?= $agency->name ? $agency->name : "" ?></p>
                                <?php
                            }else{
                        ?>
                                <img src="<?= Yii::$app->urlManager->baseUrl ?>/public_main/images/property-listing-logo1.png" alt="">
                            <?php } ?>
                        
                    </div>

                  <div class="property-listing-left-bottom-right">
                    <span><a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>">View Details</a></span>
                  </div>
                </div>
              </div>

              <div class="col-sm-5 property-listing-right">
                <div class="pull-left indicator-block">
                    <?php if($property->market_status == "Active"){?>
                        <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                    <?php }elseif($property->market_status == "Sold"){?>
                        <span class="btn btn-default btn-sm red-new-btn"><?= $property->market_status ?></span>
                    <?php }elseif($property->market_status == "Pending"){?>
                        <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                    <?php } ?>
                    <span class="btn btn-info btn-sm"><?php echo $property->categoryName?></span>    
                    <?php if($property->isNew){?>
                        <span class="btn btn-default btn-sm green-new-btn" style="color: #fff;background-color:#800080">New</span>
                    <?php }?>
                </div>
                <?php 
                    $session   =   Yii::$app->session;
                    $compProps = $session->get('comp_props');
                ?>
                <div class="property-listing-save-icon">
                    <button type="button" class="lnk_add_to_compare" id="text_<?= $property->id ?>" value="<?php if($compProps && in_array($property->id, $compProps))echo 'Added';else echo 'Compare';?>" data-value ="<?= $property->id ?>" data-url="<?= Url::to(['property/add-to-compare','id' => $property->id]) ?>"><i class="fa fa-<?php if($compProps && in_array($property->id, $compProps))echo 'minus';else echo 'plus';?>" aria-hidden="true"></i></button>
                  <a href="javascript:void(0)" class="save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i></a>
                </div>
                <h2><?php echo Yii::$app->formatter->asCurrency($property->price); ?></h2>
                <h4>
                  <?php echo $property->formattedAddress; ?>,
                </h4>
                <a href="javascript:void(0)" class="property-listing-refid">Property ID # <?= $property->referenceId ?></a>
                <p><?= $property->firstPropertyType?></p>
                <ul class="property-listing-room-details">
                    <li><strong><i class="fa fa-bed" aria-hidden="true"></i></strong> bd <span><?php echo $property->no_of_room; ?></span></li>
                    <li><strong><i class="fa fa-bath" aria-hidden="true"></i></strong> ba <span><?php echo $property->no_of_bathroom; ?></span></li>
                    <li><strong><i class="fa fa-square" aria-hidden="true"></i></strong> Sq ft <span><?php echo $property->size; ?></span></li>
                    <!--<li><strong><i class="fa fa-train" aria-hidden="true"></i></strong> Lift <span><?php // echo $property->lift; ?></span></li>-->
                    <li><strong><i class="fa fa-columns" aria-hidden="true"></i></strong> Balcony <span><?php echo $property->no_of_balcony; ?></span></li>
                </ul>

                <?= Html::a('Contact Agent', 
                    ['/property/contact-agent','id' => $property->id],
                    ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal','class' => 'btn btn-primary contact-agent-btn']
                ); ?>
              </div>
              <?php if($property->featured){echo '<div class="ribbon red"><span>Featured</span></div>';};?>
              <a href="<?php echo Url::to(['rental/view', 'slug' => $property->slug]) ?>" class="details-block-link"></a>
          </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="alert alert-info margine10top">
      <i class="fa fa-info"></i>					
      No Property found.
    </div>
    <?php
}
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