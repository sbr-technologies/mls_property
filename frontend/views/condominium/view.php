<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Property;
use common\models\PropertyCategory;
use common\models\PropertyLocationLocalInfo;
use common\models\PropertyFactInfo;
use common\models\MetaTag;
use common\models\SocialMediaLink;
use common\models\User;
use common\models\Agency;
use common\models\PhotoGallery;
use yii\helpers\StringHelper;
use yii\web\View;
use frontend\helpers\PropertyHelper;

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use common\helpers\LocationHelper;
use nullref\datatable\DataTable;
use kartik\social\FacebookPlugin;
use kartik\social\TwitterPlugin;
use kartik\social\GooglePlugin;
use common\models\Advertisement;
use yii\web\Response;
use common\models\SavedSearch;
use common\models\PropertyContact;
use common\models\PropertyType;
use common\models\Contact;


$this->title = $property->building_name;
$today = date('Y-m-d');
$radius = 5; //in Km
$areaWhere = '';
if($property->area){
    $areaWhere = " AND area='".$property->area."'";
}
$typesWhere = '';
//$types = explode(',', $property->property_type_id);
//if(!empty($types)){
//    $typesWhere = "AND (";
//    foreach($types as $type){
//        if(trim($type)){
//            $typesWhere .= " FIND_IN_SET($type, property_type_id)>0 OR";
//        }
//    }
//    $typesWhere = substr($typesWhere, 0, -2);
//    $typesWhere .= ")";
//}

$commonWhere = "WHERE property_category_id='".$property->property_category_id."' AND town='".$property->town."' AND state='".$property->state."' ". $typesWhere.$areaWhere;

$activeWhere = "AND status= '".Property::STATUS_ACTIVE."' and market_status='".Property::MARKET_ACTIVE."' AND expired_date>='".$today."'";

$soldWhere = "AND status= '".Property::STATUS_ACTIVE."' and market_status='".Property::MARKET_SOLD."' AND expired_date>='".$today."'";

$activeSql = "SELECT *, ( 6371 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians(".$property->lat.") ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property $commonWhere AND LAT IS NOT NULL AND LNG IS NOT NULL $activeWhere HAVING distance < $radius order by distance asc LIMIT 0 , 100";
$soldSql = "SELECT *, ( 6371 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians(".$property->lat.") ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property $commonWhere AND lat IS NOT NULL AND lng IS NOT NULL $soldWhere HAVING distance < $radius order by distance asc LIMIT 0 , 100";
if($property->lat && $property->lng){
    $activeProperty     =   Property::findBySql($activeSql)->all();
    $soldProperty       =   Property::findBySql($soldSql)->all();
}
$contactModels = Contact::find()->where(['property_id' => $property->id, 'type' => 'Buyer Agent'])->all();
//yii\helpers\VarDumper::dump($property->id,12,1); exit;


$soldItems = [];


$activeItems = [];

$LocalInfoItems = [];
foreach ($property->propertyLocationLocalInfo as $localInfo){
    $LocalInfoItems[] = ['id' => $localInfo->id, 'info_type' =>  $localInfo->localInfoType->title, 'info_type_id' => $localInfo->local_info_type_id, 'title' => $localInfo->title, 'description' => $localInfo->description, 'lat' => $localInfo->lat, 'lng' => $localInfo->lng];
}

$propMapJson = json_encode(['title' => $property->formattedAddress, 'description' => $property->description, 'lat' => $property->lat, 'lng' => $property->lng]);

$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/moment/moment.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
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
    '@web/public_main/js/property_enquiery.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/public_main/js/property.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<?php 
$place_photos = [];
//$location = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng={$property->lat},{$property->lng}&sensor=true");
$location = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$property->lat},{$property->lng}&radius=100&key=". Yii::$app->params['googlePhotoKey']);
$locationObj = json_decode($location);
foreach($locationObj->results as $result){
    if(isset($result->photos)){
        foreach($result->photos as $photo){
            $photo_reference = $photo->photo_reference;
            if($photo_reference){
                $place_photos[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&minwidth=400&photoreference=$photo_reference&key=". Yii::$app->params['googlePhotoKey'];
            }
        }
    }
}
$ads = [];
$adLocation = common\models\AdvertisementLocationMaster::find()->where(['page' => 'Property details'])->active()->one();
if(!empty($adLocation)){
    $ads = $adLocation->advertisements;
}
?>
<section>
    <!-- Property Menu Bar -->
    <?php
//    echo $this->render('//shared/_property_search_filtter', ['location' => '']);
    ?>
    <!-- Property Menu Bar -->
    <!-- On Scroll Top bar -->
    <div class="scroll-top-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="property-details-left-titlePart">
                        <ul>
                            <li><strong><?= $property->formattedAddress ?></strong> <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><span class="label label-danger" style="vertical-align: middle">Property ID # <?= $property->ReferenceId ?></span></li>
                        </ul>
                        
                        <ul>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->bedroom_range ?> Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-bath" aria-hidden="true"></i> <?= $property->bathroom_range?> Bath <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-trello" aria-hidden="true"></i> <?= $property->toilet_range ?> Toilet <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-glide-g" aria-hidden="true"></i> <?= $property->parking_range ?> Garage <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->lot_size ?> Lot Size <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->building_size ?> Building Size <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="scroll-top-menu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="m1 menu">
                            <div id="menu-center">
                                <ul>
                                    <li><a href="#property-details" class="active smoothscrollproperty">Condominium Details</a></li>
                                    <?php
                                    if(isset($property->propertyLocationLocalInfo) && !empty($property->propertyLocationLocalInfo)){
                                    ?>
                                    <li><a href="#property-location" class="smoothscrollproperty">Schools & Neighborhood</a></li>
                                    <?php 
                                    } 
                                    ?>
                                    <li><a href="#available_units" class="smoothscrollproperty">Available Units</a></li>
                                    <li><a href="#sold_units" class="smoothscrollproperty">Sold Units</a></li>
                                    <li><a href="#property-nearby-google-map" class="smoothscrollproperty">Explore Neighborhood</a></li>
                                    <li><a href="#photos-of-area" class="smoothscrollproperty">Photos of the Area</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- On Scroll Top bar -->
    <?php 
    $navLinks = Yii::$app->session->get('nav_links');
    $listUrl = Yii::$app->session->get('list_url');
    ?>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <!-- Property Details Left -->
                <div class="col-sm-9 property-details-left gallerypopupslider">
                    <!-- Property Details Slider Sec -->
                    <div class="property-details-slider-sec">
                        <?php
                        $photos                 =   $property->photos; 
                        $active                 =   '';
                        if(!empty($photos)){
                        ?>
                        <div id="slider" class="carousel slide" data-ride="carousel" data-interval="6000"> 
                            <div class="carousel-inner" role="listbox">
                                <?php
                                foreach ($photos as $key => $photo) {
                                    if($key == 0){
                                        $active     =   'active';
                                    }else{
                                        $active     =   '';
                                    }
                                    ?>
                                    <div class="item <?= $active ?>">
                                    <?php
                                        if(isset($photo) && $photo != ''){
                                            $alias = $photo->getImageUrl(PhotoGallery::LANDSCAPE);
                                            echo Html::img($alias,['class' => 'galleryimg']);
                                        }
                                        //echo Html::img($alias);
                                    ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            if(count($photos) > 1){
                            ?>
                            <!-- Left and right controls --> 
                            <a class="left carousel-control" href="#slider" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>
                            <a class="right carousel-control" href="#slider" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span></a>
                            <?php 
                            } 
                            ?>
                        </div>
                        <?php 
                        }else{
                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['height' => '350px','width' => '100%','class' => 'galleryimg']);
                        }
                        ?>
                        <div class="slider-top-img">
                            <a href="https://www.google.com/maps?saddr=My+Location&daddr=<?php echo "{$property->lat},{$property->lng}"?>" title="Direction" target="_blank"><span class="property-total-img detail-page-image-icon"><i class="fa fa-map-marker"></i> Direction</span></a>
                            <?php if($property->virtual_link){?>
                            <a href="<?= $property->virtual_link?>" title="Virtual Tour" target="_blank"><span class="property-total-img detail-page-image-icon"><i class="fa fa-share-square"></i> VR Tour</span></a>
                            <?php }?>
                            <span class="property-total-img detail-page-image-icon"><i class="fa fa-camera" aria-hidden="true"></i> <?= count($property->photos)?> Photos</span>
                        </div>
                    </div>
                    <!-- Property Details Slider Sec -->

                    <div class="property-details-left-titlePart">
                        <ul>
                            <li><?= $property->building_name ?> </li>
                        </ul>
                        <ul>
                            <li>Address: <?= $property->formattedAddress ?> </li>
                        </ul>
                        <ul>
                            <li>Property ID # <strong><?= $property->ReferenceId ?></strong> <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li>
                                Added On: <?= date("dS F Y", $property->created_at) ?>
                            </li>
                        </ul>
                        <ul>
                            <li>Category: <?= $property->property_category_id ? $property->propertyCategory->title : "" ?> <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li>Types: 
                                
                            <?php
                            echo $property->propertyTypes;
                            ?>
                            <span>
                                <i class="fa fa-circle" aria-hidden="true"></i>
                            </span>
                            </li>
                            <li>Status:
                                <?php
                                if ($property->market_status == "Active") {
                                    ?>
                                    <label class="label label-success"><?= $property->market_status ?></label>
                                    <?php
                                } elseif ($property->market_status == "Sold") {
                                    ?>
                                    <label class="label label-danger"><?= $property->market_status ?></label>
                                    <?php
                                } else {
                                    ?>
                                    <label class="label label-info"><?= $property->market_status ?></label>
                                    <?php
                                }
                                ?>
                                <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                            </li>
                            <li>Construction Status:
                                
                                    <?php
                                    $consStatus = '';
                                    if (!empty($property->constructionStatus)) {
                                        foreach ($property->constructionStatus as $construction) {
                                            $consStatus .= $construction->title . ",";
                                        }
                                    }
                                    echo trim($consStatus, ',');
                                    ?>
                                
                                <?php if ($property->market_status == "Sold") {?><span>
                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                </span><?php }?>
                                
                            </li>
                        </ul>
                        <ul>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->bedroom_range ?> Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-bath" aria-hidden="true"></i> <?= $property->bathroom_range?> Bath <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-trello" aria-hidden="true"></i> <?= $property->toilet_range ?> Toilet <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-glide-g" aria-hidden="true"></i> <?= $property->parking_range ?> Garage <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->lot_size ?> Lot Size <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->building_size ?> Building Size <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                        </ul>
                    </div>

                    <div class="property-details-left-con">
                        <h4 class="property-details-title" id="property-details"><i class="ra ra-property-features"></i> Property Details for <?= $property->shortAddress ?></h4>
                        <div class="row property-details-icon-sec">
                            <div class="col-sm-2">
                                <i class="ra ra-home-style"></i>
                                <h3>Category</h3>
                                <p><?= $property->propertyCategory->title?></p>
                            </div>
                            
                            <div class="col-sm-2">
                                <i class="ra ra-status-sale"></i>
                                <h3>Status</h3>
                                <p><?= $property->market_status?></p>
                            </div>
                            
                            <div class="col-sm-2">
                                <i class="ra ra-price-per-sq-ft"></i>
                                <h3>Price/Sq Ft</h3>
                                <p>₦<?= $property->price_range?></p>
                            </div>
                            
                            <div class="col-sm-2">
                                <img src="/public_main/images/mls-Nicon.png" />
                                <h3>On naijahouses.com<sup>®</sup></h3>
                                <p><?= $property->daysListed?> days</p>
                            </div>
                            
                            <div class="col-sm-2">
                                <i class="ra ra-property-type"></i>
                                <h3>Type</h3>
                                <p><?= $property->firstPropertyType?></p>
                            </div>
                            
                            <div class="col-sm-2">
                                <i class="ra ra-year-built"></i>
                                <h3>Built</h3>
                                <p><?= $property->year_built?></p>
                            </div>
                            
                        </div>
                        <p><?= $property->description ?></p>
                        <h6><span>Property Features</span></h6>
                        <div class="row">
                            <?php 
                            $genralFeature = $property->propertyGeneralFeature;
                            if(!empty($genralFeature)){
                            ?>
                            <div class="col-sm-4 form-sec">
                                <h5>General Features:</h5>
                                <div class="form-sec-box">
                                    <?php
                                    foreach ($genralFeature as $general){
                                        if($general->generalFeatureMasters->type == 'general'){
                                    ?>
                                            <div class="form-group">
                                                <?=  $general->generalFeatureMasters->name ?>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php 
                            }
                            $genralFeature = $property->propertyGeneralFeature;
                            if(!empty($genralFeature)){
                            ?>
                            <div class="col-sm-4 form-sec">
                                <h5>External Features:</h5>
                                <div class="form-sec-box">
                                    <?php 
                                    foreach ($genralFeature as $general){
                                       if($general->generalFeatureMasters->type == 'exterior'){
                                    ?>
                                            <div class="form-group">
                                                <?=  $general->generalFeatureMasters->name ?>
                                            </div>
                                    <?php
                                        }
                                     }
                                    ?>
                                </div>
                            </div>
                            <?php 
                            }
                            $genralFeature = $property->propertyGeneralFeature;
                            if(!empty($genralFeature)){
                            ?>
                            <div class="col-sm-4 form-sec">
                                <h5>Internal Features:</h5>
                                <div class="form-sec-box">
                                    <?php 
                                    foreach ($genralFeature as $general){
                                        if($general->generalFeatureMasters->type == 'interior'){
                                    ?>
                                            <div class="form-group">
                                                <?=  $general->generalFeatureMasters->name ?>
                                            </div>
                                    <?php
                                        }
                                     }
                                    ?>
                                </div>
                            </div>
                            <?php 
                            }
                            ?>
                        </div>
                        <?php
                        //yii\helpers\VarDumper::dump($property->propertyFeatures,4,12);
                        if(isset($property->propertyFeatures) && !empty($property->propertyFeatures)){
                        ?>
                        <h6><span>Feature Gallery</span></h6>

                        <div class="features-listing-sec">
                            <div class="row">
                                <?php
                                foreach (array_chunk($property->propertyFeatures, 4, true) as $propertyFeatures) {
                                    echo '<div class="features-listing-group">';
                                foreach($propertyFeatures as $feature){
                                $photos = $feature->photos;
                                $itemListArr   =   $feature->featureItems;
                                if(count($itemListArr) > 0){
                                ?>
                                <div class="col-sm-3 features-listing">
                                    <h4><?= $feature->featureMaster->name  ?></h4>
                                    <a href="javascript:void(0)">
                                        <div class="item <?= $active ?>">
                                        <?php
                                                                       // \yii\helpers\VarDumper::dump(count($photos));
                                        if(count($photos) == 0){
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'featuresimg_0']);
                                        }else{
                                            foreach ($photos as $key => $photo) {
                                                if($key == 0){
                                                    $active     =   'active';
                                                }else{
                                                    $active     =   '';
                                                }
                                            
                                                if($key == 0){
                                                    if(isset($photo) && $photo != ''){
                                                        $alias = $photo->getImageUrl($photo::LARGE);
                                                        echo Html::img($alias,['class' => 'featuresimg_'.$feature->id]);
                                                    }
                                                }else{
                                                    if(isset($photo) && $photo != ''){
                                                        $alias = $photo->getImageUrl($photo::LARGE);
                                                        echo Html::img($alias,['class' => 'featuresimg_'.$feature->id,'style'=>'display:none;']);
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        </div>
                                        <span><i class="fa fa-camera" aria-hidden="true"></i> <?= count($photos) ?></span>
                                    </a>
                                    <?php
                                    $itemListArr   =   $feature->featureItems;
                                    if(!empty($itemListArr)){
                                        
                                    ?>
                                    <ul>
                                        <?php
                                        if(!empty($itemListArr)){
                                            if(count($itemListArr) <= 2){
                                                foreach($itemListArr as $key => $item){     
                                        ?>  
                                                    <li><?= $item->name ?><?= $item->size ? " - ".$item->size : "" ?></li>
                                                    <?php
                                                    if(!empty($item->description)){
                                                        ?>
                                                    <li title="<?= $item->description?>"><?= substr($item->description, 0, 20) ?></li>
                                                        <?php
                                                    }
                                                }
                                            }else{
                                                foreach($itemListArr as $key => $item){ 
                                                    if($key <= 1){
                                                    ?>  
                                                    <li><?= $item->name ?> <?= $item->size ? " - ".$item->size : "" ?></li>
                                                    <?php
                                                        if(!empty($item->description)){
                                                            ?>
                                                            <li title="<?= $item->description?>"><?= substr($item->description, 0, 20) ?></li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <li class="features-listing-sub">
                                                    <ul>
                                                        <?php
                                                        foreach($itemListArr as $key => $menu){
                                                            if($key > 1){
                                                        ?>   
                                                            <li><?= $item->name ?> <?= $item->size ? " - ".$item->size : "" ?></li>
                                                            <?php
                                                                if(!empty($item->description)){
                                                                    ?>
                                                                    <li title="<?= $item->description?>"><?= substr($item->description, 0, 20) ?></li>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </li>
                                                <li class="features-more"><a href="javascript:void(0)">More</a></li>
                                                <li class="features-less"><a href="javascript:void(0)">Less</a></li>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                    }
                                    ?>
                                </div>  <!-- End of features-listing -->
                                <?php
                                    $js = "$(function(){
                                            $('.featuresimg_$feature->id').gallerybox();
                                        });";
                                        $this->registerjs($js, View::POS_END);
                                    } 
                                }  // End of outer foreach
                                echo '</div>'; // <!-- End of features-listing-group -->'
                                }
                                ?>
                            </div>
                            <!--<a href="javascript:void(0)" class="features-more">More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" class="features-less">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>-->
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                    <?php
                    //echo 11;
                    if(isset($property->propertyLocationLocalInfo) && !empty($property->propertyLocationLocalInfo)){
                    ?>
                        <div class="property-location-sec" id="property-location">
                            <h4 class="property-details-title"><i class="ra ra-schools"></i> Schools & Neighborhood to <?= $property->shortAddress?></h4>
                            <ul class="nav nav-tabs location-tabbar" role="tablist">
                                <li role="presentation" class="active"><a href="#local_info_map" aria-controls="map" role="tab" data-toggle="tab">Map</a></li>
                                <li role="presentation"><a href="#local_info_list" aria-controls="list" role="tab" data-toggle="tab"> List</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="local_info_map">
                                    <div class="tabbable tabs-left">
                                        <div class="row">
                                            <div class="col-sm-3 pright">
                                                <ul class="nav nav-tabs location-left-tab">
                                                    <?php
                                                        if(isset($property->propertyLocationLocalInfo) && !empty($property->propertyLocationLocalInfo)){?>
                                                        <li class=""><a href="javascript:void(0)" class="local_info_filter_by_type" data-local_info_type_id="0"><span class="property-location-icons icon-bank"></span> All</a></li>
                                                        <?php    
                                                            $localLocationDataArr = $property->propertyLocationLocalInfo;
                                                            foreach($localLocationDataArr as $key => $locationData){
                                                    ?>
                                                  <li class=""><a href="javascript:void(0)" class="local_info_filter_by_type" data-local_info_type_id="<?= $locationData->local_info_type_id?>"><span class="property-location-icons icon-bank"></span> <?= $locationData->localInfoType->title ?></a></li>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>

                                            <div class="col-sm-9 pleft">
                                                <div class="tab-content location-left-tab-content">
                                                  <div id="local_info_map_canvas" style="height:345px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="local_info_list">
                                    <div class="table-responsive">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table property-location-table-list">
                                            <tbody>
                                                <tr>
                                                    <th>Location Name</th>
                                                    <th>No. Of Location</th>
                                                    <th>Distance</th>
                                                </tr>
                                                <?php
                                                if(isset($property->propertyLocationLocalInfo) && !empty($property->propertyLocationLocalInfo)){
                                                    foreach($property->propertyLocationLocalInfo as $key => $locationData){
                                                ?>
                                                <tr>
                                                    <td><span class="property-location-icons icon-bank"></span> <?= $locationData->localInfoType->title ?></td>
                                                    <td><?= $locationData->title  ?></td>
                                                    <td><?= round($locationData->distance, 1) ?> Km</td>
                                                </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    $availableUnitsForSale = Property::find()->where(['parent_id' => $property->id, 'property_category_id' => 2])->active()->all();
                    $availableUnitsForRent = Property::find()->where(['parent_id' => $property->id, 'property_category_id' => 1])->active()->all();
                    $soldUnits = Property::find()->where(['parent_id' => $property->id])->sold()->all();
                    ?>
                    <div id="available_for_sale_units">
                    <h4 class="property-details-title"><i class="ra ra-property-features"><div></div></i> Available Units For Sale at <?= $property->building_name?></h4>
                    <div class="average-price-table-listing">
                        <div class="rTable">
                            <div class="rTableRow">
                                <div class="rTableHead"><strong>Unit #</strong></div>
                                <div class="rTableHead"><strong>Price</strong></div>
                                <div class="rTableHead"><strong>Bedroom</strong></div>
                                <div class="rTableHead"><strong>Bathroom</strong></div>
                                <div class="rTableHead"><strong>Toilet</strong></div>
                                <div class="rTableHead"><strong>Garage</strong></div>
                                <div class="rTableHead"><strong>Unit Size</strong></div>
                                <div class="rTableHead"><strong>Price Per Sqm</strong></div>
                                <div class="rTableHead"><strong>Property ID</strong></div>
                            </div>
                            <?php
                                if (!empty($availableUnitsForSale)) {
                                    foreach ($availableUnitsForSale as $unit) {
                            ?>
                            <a class="rTableRow table_body" href="<?= Url::to(['property/view', 'slug' => $unit->slug])?>" data-toggle="popover" data-placement="top" data-html="true" data-content="<img src='<?= $unit->featureThumbImage?>'>">
                                <div class="rTableCell"><?= $unit->appartment_unit ?></div>
                                <div class="rTableCell"><?= Yii::$app->formatter->asCurrency($unit->price) ?></div>
                                <div class="rTableCell"><?= $unit->no_of_room ?></div>
                                <div class="rTableCell"><?= $unit->no_of_bathroom ?></div>
                                <div class="rTableCell"><?= $unit->no_of_toilet ?></div>
                                <div class="rTableCell"><?= $unit->no_of_garage ?></div>
                                <div class="rTableCell"><?= $unit->house_size ?></div>
                                <div class="rTableCell"><?= $unit->pricePerUnit?></div>
                                <div class="rTableCell"><?= $unit->reference_id?></div>
                            </a>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    </div>
                    <div id="available_for_rent_units">
                    <h4 class="property-details-title"><i class="ra ra-property-features"><div></div></i> Available Units For Rent at <?= $property->building_name?></h4>
                    <div class="average-price-table-listing">
                        <div class="rTable">
                            <div class="rTableRow">
                                <div class="rTableHead"><strong>Unit #</strong></div>
                                <div class="rTableHead"><strong>Price</strong></div>
                                <div class="rTableHead"><strong>Bedroom</strong></div>
                                <div class="rTableHead"><strong>Bathroom</strong></div>
                                <div class="rTableHead"><strong>Toilet</strong></div>
                                <div class="rTableHead"><strong>Garage</strong></div>
                                <div class="rTableHead"><strong>Unit Size</strong></div>
                                <div class="rTableHead"><strong>Price Per Sqm</strong></div>
                                <div class="rTableHead"><strong>Property ID</strong></div>
                            </div>
                            <?php
                                if (!empty($availableUnitsForRent)) {
                                    foreach ($availableUnitsForRent as $unit) {
                            ?>
                            <a class="rTableRow table_body" href="<?= Url::to(['property/view', 'slug' => $unit->slug])?>" data-toggle="popover" data-placement="top" data-html="true" data-content="<img src='<?= $unit->featureThumbImage?>'>">
                                <div class="rTableCell"><?= $unit->appartment_unit ?></div>
                                <div class="rTableCell"><?= Yii::$app->formatter->asCurrency($unit->price) ?></div>
                                <div class="rTableCell"><?= $unit->no_of_room ?></div>
                                <div class="rTableCell"><?= $unit->no_of_bathroom ?></div>
                                <div class="rTableCell"><?= $unit->no_of_toilet ?></div>
                                <div class="rTableCell"><?= $unit->no_of_garage ?></div>
                                <div class="rTableCell"><?= $unit->house_size ?></div>
                                <div class="rTableCell"><?= $unit->pricePerUnit?></div>
                                <div class="rTableCell"><?= $unit->reference_id?></div>
                            </a>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    </div>
                    <div id="sold_units">
                    <h4 class="property-details-title"><i class="ra ra-property-features"><div></div></i> Sold Units at <?= $property->building_name?></h4>
                    <div class="average-price-table-listing">
                        <div class="rTable">
                            <div class="rTableRow">
                                <div class="rTableHead"><strong>Unit #</strong></div>
                                <div class="rTableHead"><strong>Price</strong></div>
                                <div class="rTableHead"><strong>Bedroom</strong></div>
                                <div class="rTableHead"><strong>Bathroom</strong></div>
                                <div class="rTableHead"><strong>Toilet</strong></div>
                                <div class="rTableHead"><strong>Garage</strong></div>
                                <div class="rTableHead"><strong>Unit Size</strong></div>
                                <div class="rTableHead"><strong>Price Per Sqm</strong></div>
                                <div class="rTableHead"><strong>Property ID</strong></div>
                            </div>
                            <?php
                                if (!empty($soldUnits)) {
                                    foreach ($soldUnits as $unit) {
                            ?>
                            <a class="rTableRow table_body" href="<?= Url::to(['property/view', 'slug' => $unit->slug])?>" data-toggle="popover" data-placement="top" data-html="true" data-content="<img src='<?= $unit->featureThumbImage?>'>">
                                <div class="rTableCell"><?= $unit->appartment_unit ?></div>
                                <div class="rTableCell"><?= Yii::$app->formatter->asCurrency($unit->sold_price) ?></div>
                                <div class="rTableCell"><?= $unit->no_of_room ?></div>
                                <div class="rTableCell"><?= $unit->no_of_bathroom ?></div>
                                <div class="rTableCell"><?= $unit->no_of_toilet ?></div>
                                <div class="rTableCell"><?= $unit->no_of_garage ?></div>
                                <div class="rTableCell"><?= $unit->house_size ?></div>
                                <div class="rTableCell"><?= $unit->pricePerUnit?></div>
                                <div class="rTableCell"><?= $unit->reference_id?></div>
                            </a>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    </div>
                    <div id="property-nearby-google-map">
                        <h4 class="property-details-title"><i class="ra ra-homes-around"></i> Explore Schools, Safety & Lifestyle Nearby <?= $property->shortAddress?></h4>
                        <iframe
                            height="400"
                            frameborder="0" style="border:0; width: 100%;"
                            src="https://www.google.com/maps/embed/v1/place?key=<?= Yii::$app->params['googleMapKey'] ?>
                            &q=<?= $property->formattedGmapAddress ?>" allowfullscreen>
                        </iframe>
                    </div>
                    <div id="photos-of-area">
                    <?php if(!empty($place_photos)){?>
                    <div class="property-details-left-con photo-area-listing photopopupslider">
                        <h4 class="property-details-title"><i class="fa fa-image"></i> Photos of the Area</h4>
                      <ul>
                        <?php
                        foreach($place_photos as $i => $photo){?>
                        <li style="<?php if($i > 9) echo  'display:none'?>">
                          <a href="javascript:void(0)"><img src="<?= $photo?>" alt="" class="areaphoto">
                            <?php if($i == 9){
                               echo '<span class="total-photo-no areaphoto">+'.(count($place_photos)-10).'</span>'; 
                            }?>
                          </a>
                        </li>
                        <?php }
                        ?>
<!--                        <li><a href="javascript:void(0)"><img src="images/property-listing-img4.jpg" alt="" class="areaphoto"> <span class="total-photo-no areaphoto">+5</span></a></li>-->
                      </ul>
                    </div>
                    <?php }?>
                    </div>
                </div>
                <!-- Property Details Left -->

                <!-- Property Details Right -->
                <div class="col-sm-3 property-details-right">
                    <!-- Property Details Save This Property -->
                    <div class="save-property-box">
                        <h5>
                            <?= Html::a('Tell me More about this property', 
                                'javascript:void(0);',
                                ['class' => 'contact-agent-btn request-details-btn','data-href' => Url::to(['/site/check-login'])]
                            ); ?>
                        </h5>
                        <h5><a href="javascript:void(0)" class="heart-btn save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i> Save This Property</a></h5>
                        <a href="<?= Url::to(['/property/print','slug' => $property->slug]) ?>" target="_blank" class="text-center"><i class="fa fa-print"></i> Print</a>
                    </div>
                    <!-- Property Details Save This Property -->

                    <!-- Property Details AD -->
                    <?php 
                    foreach($ads as $ad){
                        if($ad->status == 'active'){
                        ?>
                            <div class="property-details-right-ad">
                                <div id="ad_my_carousel_<?= $ad->id?>" class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <?php 
                                        foreach($ad->advertisementBanners as $key => $banner){
                                            if($banner->status == 'active'){?>
                                                <div class="item <?php if($key == 0)echo 'active'?>">
                                                    <a href="<?= Url::to(['advertisement/redirect', 'id' => $ad->id])?>" target="_blank">
                                                        <img src="<?= $banner->photo->getImageUrl()?>" alt="">
                                                    </a>
                                                </div>
                                        <?php 
                                            }
                                        }?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        } 
                    }?>
                    <!-- Property Details AD -->

                    <!-- Property Details Social Icon -->
                    <div class="property-details-right-social">
                        <h4>Share On Social Media</h4>
                        <div class="social-share-items">    
                            <?= FacebookPlugin::widget(['type'=>FacebookPlugin::SHARE, 'settings' => ['size'=>'small', 'layout'=>'button_count', 'mobile_iframe'=>'false']]); ?>
                            <?= TwitterPlugin::widget(['type'=>TwitterPlugin::SHARE, 'settings' => ['size'=>'default']]) ?>
                            <?= GooglePlugin::widget(['type'=>GooglePlugin::SHARE, 'settings' => ['size'=>'small']]) ?>
                        </div>
                        
                    </div>
                    <!-- Property Details Social Icon -->

                    <!-- Property Details Similar Property -->
                    
                    <!-- Property Details Similar Property -->
                </div>
                <!-- Property Details Right -->
            </div>
        </div>
    </div>
    <!-- Property Details Bottom -->
    <!-- Property Details Bottom -->
    <?php //echo Html::a('Contact Agent', 'javascript:void(0);',['class' => 'btn btn-primary contact-agent-btn','data-href' => Url::to(['/site/check-login'])]); ?>
</section>
<?php

$js = "$(function(){
                $('.table_body').hover(function(){
                    $(this).find('.unit_thumbnail').show();
                }, function(){
                    $(this).find('.unit_thumbnail').hide();
                });
                
            $('[data-toggle=\"popover\"]').popover({
                placement : 'top',
                trigger : 'hover'
            });

            });";
$this->registerJs($js, View::POS_END);  