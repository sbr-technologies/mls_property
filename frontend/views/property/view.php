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


$this->title = $property->formattedAddress;
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

$commonWhere = "WHERE property_category_id='".$property->property_category_id."' AND town='".$property->town."' AND state='".$property->state."' ". $typesWhere.$areaWhere. " AND (is_multi_units_apt=0 OR (is_multi_units_apt=1 AND parent_id IS NOT NULL))";

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
if(isset($activeProperty) && !empty($activeProperty)){
    foreach($soldProperty as $listing){
        $soldItems[$listing->id] = ['id' => $listing->id, 'lat' => $listing->lat, 'lng' => $listing->lng, 'price' => $listing->price, 'price_as' => Yii::$app->formatter->asCurrency($listing->price),
            'bedroom' => $listing->no_of_room, 'bathroom' => $listing->no_of_bathroom, 'lot_size' => round($listing->lot_size). ' sq ft',
            'feature_image' => $listing->getFeatureImage(PhotoGallery::THUMBNAIL), 'detail_url' => Url::to(['property/view', 'slug' => $listing->slug]), 'address' => substr($listing->formattedAddress, 0, 20). '...',
            'city' => $listing->town, 'state' => $listing->state
            ];
    }
}

$activeItems = [];
if(isset($activeProperty) && !empty($activeProperty)){
    foreach($activeProperty as $listing){
        $activeItems[$listing->id] = ['id' => $listing->id, 'lat' => $listing->lat, 'lng' => $listing->lng, 'price' => $listing->price, 'price_as' => Yii::$app->formatter->asCurrency($listing->price),
            'bedroom' => $listing->no_of_room, 'bathroom' => $listing->no_of_bathroom, 'lot_size' => round($listing->lot_size). ' sq ft',
            'feature_image' => $listing->getFeatureImage(PhotoGallery::THUMBNAIL), 'detail_url' => Url::to(['property/view', 'slug' => $listing->slug]), 'address' => substr($listing->formattedAddress, 0, 20). '...',
            'city' => $listing->town, 'state' => $listing->state
            ];
    }
}
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
                        <?= Html::a('Request details', 
                            'javascript:void(0);',
                            ['class' => 'contact-agent-btn request-details-btn','data-href' => Url::to(['/site/check-login'])]
                        ); ?>
                        <!--<a href="javascript:void(0)" class="heart-btn"><i class="fa fa-heart-o" aria-hidden="true"></i></a>-->
                        
                        <a href="javascript:void(0)" class="heart-btn save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i></a>
                        
                        <ul>
                            <li><?= $property->no_of_room ?>  Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_toilet ?> Balcony<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_bathroom ?> Bath <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_toilet ?> Toilet <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_garage ?> Garage <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->lot_size ?> acres lot<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->house_size  ?> Sq. Ft.</li>
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
                                    <li><a href="#property-details" class="active smoothscrollproperty">Property Details</a></li>
                                    <?php
                                    if(isset($property->propertyLocationLocalInfo) && !empty($property->propertyLocationLocalInfo)){
                                    ?>
                                    <li><a href="#property-location" class="smoothscrollproperty">Schools & Neighborhood</a></li>
                                    <?php 
                                    } 
                                    if($property->property_category_id == 2){
                                    ?>
                                    <li><a href="#payment-options" class="smoothscrollproperty">Payment Options</a></li>
                                    <?php 
                                    }
                                    ?>
                                    <li><a href="#property-history" class="smoothscrollproperty">Property History</a></li>
                                    <li><a href="#nearby-properties" class="smoothscrollproperty">Nearby Properties</a></li>
                                    <li><a href="#avg-price-nearby-properties" class="smoothscrollproperty">Average Prices Nearby</a></li>
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
            <?php if($navLinks && $listUrl){?>
            <div class="row">
                <div class="col-sm-12 property-nam-pagination">
                    <div class="pull-left"><a href="<?= $listUrl?>"><i class="fa fa-angle-double-left"></i> Back</a></div>
                    <div class="pull-right">
                        <?php if(isset($navLinks[$property->id]['prev'])){?>
                        <a href="<?= Url::to(['property/view', 'slug' => $navLinks[$property->id]['prev']])?>"><i class="fa fa-angle-left"></i> Previous</a> 
                        <?php }else{?>
                        <span><i class="fa fa-angle-left"></i> Previous</span>     
                        <?php }?>
                        <span>|</span> 
                        <?php if(isset($navLinks[$property->id]['next'])){?>
                        <a href="<?= Url::to(['property/view', 'slug' => $navLinks[$property->id]['next']])?>"><i class="fa fa-angle-right"></i> Next</a> 
                        <?php }else{?>
                        <span>Next <i class="fa fa-angle-right"></i></span>     
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="row">
                <?php
                if($property->user->profile->title == 'Agent' || $property->user->profile->title == 'Seller'){
                ?>
                    <div class="property-details-user-top">
                        <div class="property-details-user-top-inner">
                            <div class="col-sm-12">
                                <div class="col-sm-5">
                                    <?php
                                    //\yii\helpers\VarDumper::dump($property->isSellerInformationShow); 
                                    if($property->user->profile->title == 'Seller'){
                                        if($property->isSellerInformationShow == "No"){
                                            if(!empty($property->user->getImageUrl(User::THUMBNAIL))){
                                                echo Html::img($property->user->getImageUrl(User::THUMBNAIL), [
                                                      'class'=>'', 
                                                  ]);
                                            }else{
                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/add-photo-img.jpg'), [
                                                      'class'=>'', 
                                                  ]);
                                            }

                                            ?>
                                            <p><span>Listed by:</span> <?= $property->user->fullName ? $property->user->fullName : "" ?> <?= $property->user->PhoneNumber ? $property->user->PhoneNumber : "" ?></p>  
                                            <?php
                                        }else{
                                            $agentId = common\models\SiteConfig::item('agentId');
                                            $adminUserData      = User::findOne($agentId);
                                           // \yii\helpers\VarDumper::dump($adminUserData,4,12); 
                                            if(!empty($adminUserData->getImageUrl(User::THUMBNAIL))){
                                                echo Html::img($adminUserData->getImageUrl(User::THUMBNAIL), [
                                                      'class'=>'', 
                                                ]);
                                            }else{
                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/add-photo-img.jpg'), [
                                                      'class'=>'', 
                                                ]);
                                            }
                                            ?>
                                            <p><span>Listed by:</span> <?= $adminUserData->fullName ? $adminUserData->fullName : "" ?> <?= $adminUserData->PhoneNumber ? $adminUserData->PhoneNumber : "" ?></p>
                                        <?php
                                        }
                                    }else if($property->user->profile->title == 'Agent'){
                                        if(!empty($property->user->getImageUrl(User::THUMBNAIL))){
                                            echo Html::img($property->user->getImageUrl(User::THUMBNAIL), [
                                                  'class'=>'', 
                                            ]);
                                        }else{
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/add-photo-img.jpg'), [
                                                  'class'=>'', 
                                            ]);
                                        }
                                        ?>
                                        <p><span>Listed by:</span> <?= $property->user->nameLink ?> <?= $property->user->PhoneNumber ? $property->user->PhoneNumber : "" ?></p>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php 
                                if($property->user->profile->title == 'Seller' && $property->isSellerInformationShow != "No"){
                                    $agencyId = common\models\SiteConfig::item('agencyId');
                                    $agency = Agency::findOne($agencyId);
                                }else{
                                    $agency = $property->user->agency;
                                }
                                if(!empty($agency)){
                                ?>
                                <div class="col-sm-7">
                                    <?php 
                                        if(isset($agency->photos[0]) && !empty($agency->photos[0])){ 
                                        ?>
                                            <img src="<?= $agency->photos[0]->imageUrl ?>" alt="" >
                                        <?php
                                        }else{
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg'), [
                                                'class'=>'', 
                                            ]);
                                        }
                                    ?>
                                            <p><span>Brokered by:</span> <?= $agency->nameLink ?> <?= $agency->getOffice1()?></p>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <!-- Property Details Left -->
                <div class="col-sm-9 property-details-left gallerypopupslider">
                    <!-- Property Details Slider Sec -->
                    <div class="property-details-slider-sec">
                        <?php
                        $photos                 =   $property->photos; 
                        $active                 =   '';
                        $featureImage = Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png');
                        if(!empty($photos)){
                        ?>
                        <div id="slider" class="carousel slide" data-ride="carousel" data-interval="6000"> 
                            <div class="carousel-inner" role="listbox">
                                <?php
                                foreach ($photos as $key => $photo) {
                                    if($key == 0){
                                        $active     =   'active';
                                        $featureImage = $photo->getImageUrl(PhotoGallery::LANDSCAPE);
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
                        <h3 class="property-details-price"><?= substr(Yii::$app->formatter->asCurrency($property->price), 0, -3)?></h3>
                        <ul>
                            <li><?= $property->formattedAddress ?> </li>
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
                                    $types = '';
                                    if (!empty($property->propertyTypeIds)) {
                                        foreach ($property->propertyTypeIds as $propertyType) { //echo $propertyType;
                                            $types .= $propertyType->title . ",";
                                        }
                                    }
                                    echo trim($types, ',');
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
                            <?php
                            if ($property->market_status == "Sold") {
                                ?>
                                <li>
                                    Sold Price: <?= $property->sold_price ?> <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                                </li>
                                <li>
                                    Sold Date: <?= date("d-m-Y", strtotime($property->sold_date)) ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <ul>
                            <li><i class="fa fa-home" aria-hidden="true"></i> <?= $property->no_of_room ?> Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-trello" aria-hidden="true"></i> <?= $property->no_of_toilet ?> Balcony<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-bath" aria-hidden="true"></i> <?= $property->no_of_bathroom ?> Bath <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-trello" aria-hidden="true"></i> <?= $property->no_of_toilet ?> Toilet <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-glide-g" aria-hidden="true"></i> <?= $property->no_of_garage ?> Garage <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-map-pin" aria-hidden="true"></i> <?= $property->lot_size ?> acres lot<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><i class="fa fa-square" aria-hidden="true"></i> <?= $property->house_size  ?> Sq. Ft.</li>
                        </ul>
                    </div>

                    <div class="property-details-left-con">
                        <p class="pull-right">
                            <?=
                            Html::a('<i class="fa fa-commenting"></i> Request a Private Showing', 'javascript:void(0);', ['class' => 'bnt_showing_request_login red-btn', 'data-href' => Url::to(['/site/check-login'])]
                            );
                            ?>
                        </p>
                        <h4 class="property-details-title"><i class="ra ra-open-house icon-space-right"></i> Open House</h4>
                        
                        <?php 
                        if(isset($property->openHouse->start_date) && !empty($property->openHouse->start_date)){
                            $openData = $property->openHouse;
                        ?>
                        <p>
                            <i class="fa fa-calendar" aria-hidden="true"></i> 
                            <strong>Date Range : </strong> <?= date('F jS, Y', strtotime($openData->start_date)); ?> - <?= date('F jS, Y', strtotime($openData->end_date)); ?>
                        </p>
                        <?php if(!empty($openData->starttime)){?>
                        <p>
                            <i class="fa fa-clock-o" aria-hidden="true"></i> 
                            <strong>Time Range : </strong><?= $openData->starttime ?> - <?= $openData->endtime ?>
                        </p>
                        <?php }?>
                        <?php
                        }else{
                        ?>
                          <p>None at this time</p>      
                        <?php
                        }
                        ?>
                        
                        
                        
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
                                <p>₦<?= $property->pricePerUnit?></p>
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
                    if($property->property_category_id == 2){
                    ?>

                    <div class="property-details-left-con payment-options-sec" id="payment-options">
                        <h4 class="property-details-title"><i class="ra ra-payment-options icon-space-right"></i> Payment Options</h4>
                        <!--<h5 class="blackTitle">Monthly Payment</h5>-->
                        <div class="row">
                          <form action="<?= Url::to(['/property/calculate-payment']);?>" method="post" class="frm_payment_calculator">
                            <div class="col-sm-6">
<!--                                <p class="mbottom10">Have you or your spouse served in the military?</p>
                                <p class="mbottom10">Veterans may be entitled to:</p>
                                <ul>
                                    <li>Down payment of 0%</li>
                                    <li>No mortgage insurance</li>
                                    <li>Lower interest rate</li>
                                </ul>-->
                                  <input type="hidden" class="hid_field_name" name="Calc[field_name]">
                                <div class="calculate-form">
                                    <div class="form-group">
                                        <label for="">Home Price</label>
                                        <input name="Calc[property_price]" data-field="property_price" class="form-control calc_property_price" value="<?= Yii::$app->formatter->asCurrency($property->price) ?>" type="text">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Down Payment</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                              <input name="Calc[down_payment_percent]" data-field="down_payment_percent" class="form-control calc_down_payment_percent" value="20%" type="text">
                                            </div>
                                            <div class="col-sm-6">
                                              <input name="Calc[down_payment_amount]" data-field="down_payment_amount" class="form-control calc_down_payment_amount" value="<?php echo Yii::$app->formatter->asCurrency($property->price*20/100)?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Mortgage Loan Type</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select name="Calc[mortgage_loan_type]" class="selectpicker" id="mortgage_loan_type">
                                                    <option value="25">25 Year Fixed</option>
                                                    <option value="20">20 Year Fixed</option>
                                                    <option value="15">15 Year Fixed</option>
                                                    <option value="10">10 Year Fixed</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                              <input name="Calc[mortgage_loan_type_percentage]" class="form-control calc_mortgage_loan_type_percentage" type="text" value="4%">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button name="" type="submit" class="btn btn-primary red-btn">Calculate</button>
                                    </div>
                                </div>
         
                            </div>

                            <div class="col-sm-6">
                              <h2 class="payment-options-priceTxt"><span class="total_monthly_installment"></span><span>/month</span></h2>
                                <div class="table-responsive">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table porperty-details-progress-bar">
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Principal & Interest</td>
                                                        <td class="text-right"><input type="text" class="calc_pay_monthly_value readonly_textbox text-right" readonly="" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-orange calc_pay_value_percent" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Property Tax</td>
                                                        <td class="text-right"><input type="text" name="CalcV[tax]" class="readonly_textbox text-right" readonly="" value="<?= Yii::$app->formatter->asCurrency($property->tax ?: 0)?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-green calc_tax_percent" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Home Insurance</td>
                                                        <td class="text-right"><input type="text" name="CalcV[insurance]" class="readonly_textbox text-right" readonly="" value="<?= Yii::$app->formatter->asCurrency($property->insurance ?: 0)?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-parpul calc_insurance_percent" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>HOA Fees</td>
                                                        <td class="text-right"><input type="text" name="CalcV[hoa_fees]" class="readonly_textbox text-right" readonly="" value="<?= Yii::$app->formatter->asCurrency($property->hoa_fees ?: 0)?>" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-blue calc_hoa_fees_percent" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Mortgage Insurance</td>
                                                        <td class="text-right"><input type="text" name="CalcV[mortgage_insurance]" value="<?= Yii::$app->formatter->asCurrency($property->price*Property::MORTGAGE_INSURANCE / 100)?>" class="mortgage_insurance_amount readonly_textbox text-right" readonly=""/></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-black calc_mortgage_insurance_percent" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                          </form>
                        </div>
                    </div>
                    <?php 
                    }
                    ?>
                    <div class="property-details-left-con" id="property-history">
                        <h4 class="property-details-title"><i class="ra ra-property-history"></i> Property History for <?= $property->shortAddress ?></h4>
                        <div class="average-price-listing">
                            <?php
                            if(!empty($property->propertyPriceHistories)){
                                $i = 1;
                                //yii\helpers\VarDumper::dump($property->propertyPriceHistories,4,12); exit;
                            ?>
                                <div class="col-sm-12">
                                    <p><strong>Property Price</strong></p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <th class="text-center">Sl No.</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Price</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($property->propertyPriceHistories as $history){
                                                ?>
                                                <tr class="property_price_row" style="<?php if($i>10)echo 'display:none;' ?>">
                                                    <td><?= $i?></td>
                                                    <td><?= date("d-m-Y",  strtotime($history->date)) ?></td>
                                                    <td><?= $history->status ?></td>
                                                    <td><?= $history->price ?></td>
                                                </tr>
                                                <?php $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php
                            }
                            if(!empty($property->propertyTaxHistories)){
                            ?>
                                <div class="property-history-listing-border"></div>

                                <div class="col-sm-12">
                                    <p><strong>Property Tax</strong></p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <?= \nullref\datatable\DataTable::widget([
                                            'scrollY' => '200px',
                                            'scrollCollapse' => true,
                                            'paging' => false,
                                            "searching"=> false,
                                           // "infoCallback" => false,
                                            'data' => $property->propertyTaxHistories,
                                            'columns' => [
                                                'year',
                                                'taxes',
//                                                'land',
//                                                'addition',
//                                                'total_assesment'
                                            ],
                                        ]) ?>

                                    </div>
                                    <?php //echo Html::a('Contact Agent', ['/property/contact-agent','id' => $property->id],['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal','class' => 'btn btn-default red-btn']); ?>
                                </div>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>

                    <div class="property-details-left-con active-sold-listing" id="nearby-properties" style="position: relative;">
                        <ul class="nav nav-tabs location-tabbar" role="tablist">
                            <li role="presentation" class="active"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">Active</a></li>
                            <li role="presentation"><a href="#sold" aria-controls="sold" role="tab" data-toggle="tab"> Sold</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="active">
                                <h4 class="property-details-title"><i class="ra-comparable-homes ra"></i> List of properties Nearby <?= $property->shortAddress ?>: Active</h4>
                                <div class="active-sold-table-listing">
                                    <div class="table-responsive">
                                        <?php
//                                                                    yii\helpers\VarDumper::dump($activeProperty, 11,1);die();
                                        if (!empty($activeProperty)) {
                                            $finalActiveData[] = [
                                                'address' => 'This Home : ' . $property->formattedAddress,
                                                'no_of_room' => $property->no_of_room,
                                                'no_of_bathroom' => $property->no_of_bathroom,
                                                'price' => $property->price,
                                                //'size'              =>  $property->size,
                                                'lot_size' => $property->lot_size,
                                                'distance' => 0
                                            ];
                                            foreach ($activeProperty as $active) {
                                                $finalActiveData[] = [
                                                    'address' => Html::a($active->formattedAddress, ['/property/view', 'slug' => $active->slug]),
                                                    'no_of_room' => $active->no_of_room,
                                                    'no_of_bathroom' => $active->no_of_bathroom,
                                                    'price' => $active->price,
                                                    //'size'          =>  $active->size,
                                                    'lot_size' => $active->lot_size,
                                                    'distance' => round($active->distance, 1) . 'Km'
                                                ];
                                            }
                                            //yii\helpers\VarDumper::dump($finalActiveData,4,12); exit;
                                            if (!empty($finalActiveData)) {
                                                //foreach ($finalActiveData as $activeProperty){
                                                ?>
                                                <?=
                                                \nullref\datatable\DataTable::widget([
                                                    'scrollY' => '200px',
                                                    'scrollCollapse' => true,
                                                    'paging' => true,
                                                    "searching" => false,
                                                    'aaSorting' => [],
                                                    //"infoCallback" => false,
                                                    'data' => $finalActiveData,
                                                    'columns' => [
                                                        'address',
                                                        'no_of_room',
                                                        'no_of_bathroom',
                                                        'price',
                                                        //'size',
                                                        'lot_size',
                                                        'distance'
                                                    ],
                                                ]);
                                            }
                                            //}
                                        } else {
                                            echo 'No Records Found';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php if(!empty($activeProperty)){?>
                                <div class="property-details-left-con recently-sold-sec">
                                    <h4 class="property-details-title"><i class="fa fa-map-o"></i> Map view of properties Nearby <?= $property->shortAddress ?>: Active</h4>
                                    <div id="xPopup" class="map-popup-box-sold"></div>
                                    <div id="realestate_view_active_container" class="realestate_view_sold_container" style="height:330px;"></div>
                                    <h4 class="property-details-title"><i class="fa fa-table"></i> Properties Nearby <?= $property->shortAddress ?>: Active</h4>
                                    <div class="recently-sold-listing-sec">
                                        <div class="row">
                                          <?php for($i = 0; $i < count($activeProperty); $i++){ if(!isset($activeProperty[$i])) break;?>
                                            <div class="col-sm-4">
                                                <a href="javascript:void(0)" class="recently-sold-listing">
                                                    <?php if(isset($activeProperty[$i]->photos[0])){
                                                       echo Html::img($activeProperty[$i]->photos[0]->getImageUrl(PhotoGallery::THUMBNAIL)); 
                                                    }else{
                                                        echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                    }?>
                                                    <div class="recently-sold-con">
                                                        <p><span><?= Yii::$app->formatter->asCurrency($activeProperty[$i]->price)?></span> <?= $activeProperty[$i]->no_of_room?> BD  -  <?= $activeProperty[$i]->no_of_bathroom?> Ba  -  <?=  $activeProperty[$i]->no_of_toilet?> Balcony</p>
                                                        <p><?= $activeProperty[$i]->formattedAddress?></p>
                                                    </div>
                                                </a>
                                            </div>
                                          <?php }?>
                                        </div>

            <!--                            <a href="javascript:void(0)" class="show-more-recently-sold">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" class="less-more-recently-sold">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>-->
                                    </div>
                                </div>
                                <?php }?>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="sold">
                                <h4 class="property-details-title"><i class="ra-comparable-homes ra"></i> List of properties Nearby <?= $property->shortAddress ?>: Sold</h4>
                                <div class="active-sold-table-listing">
                                    <div class="table-responsive">
                                        <?php
//                                        \yii\helpers\VarDumper::dump($soldProperty,4,12); exit;
                                        if (!empty($soldProperty)) {
                                            $finalSoldData = [];
                                            foreach ($soldProperty as $sold) {
                                                //\yii\helpers\VarDumper::dump($sold); exit;
                                                $finalSoldData[] = [
                                                    'address' => $sold->formattedAddress,
                                                    'no_of_room' => $sold->no_of_room,
                                                    'no_of_bathroom' => $sold->no_of_bathroom,
                                                    'price' => $sold->price,
                                                    // 'size'              =>  $sold->size,
                                                    'lot_size' => $sold->lot_size,
                                                    'distance' => round($sold->distance) . 'Km'
                                                ];
                                            }
                                            //\yii\helpers\VarDumper::dump($finalSoldData,4,12); exit;
                                            if (!empty($finalSoldData)) {
                                                ?>
                                                <?=
                                                \nullref\datatable\DataTable::widget([
                                                    'scrollY' => '200px',
                                                    'scrollCollapse' => true,
                                                    'paging' => true,
                                                    "searching" => false,
                                                    //"infoCallback" => false,
                                                    'data' => $finalSoldData,
                                                    'columns' => [
                                                        'address',
                                                        'no_of_room',
                                                        'no_of_bathroom',
                                                        'price',
                                                        // 'size',
                                                        'lot_size',
                                                        'distance'
                                                    ],
                                                ]);
                                            } else {
                                                echo 'No Records Found';
                                            }
                                        } else {
                                            echo 'No Records Found';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php if(!empty($soldProperty)){?>
                                <div class="property-details-left-con recently-sold-sec">
                                    <h4 class="property-details-title"><i class="fa fa-map-o"></i> Map view of properties Nearby <?= $property->shortAddress ?>: Sold</h4>
                                    <div id="xPopupSold" class="map-popup-box-sold"></div>
                                    <div id="realestate_view_sold_container" class="realestate_view_sold_container" style="height:330px;"></div>
                                    <h4 class="property-details-title"><i class="fa fa-table"></i> Properties Nearby <?= $property->shortAddress ?>: Sold</h4>
                                    <div class="recently-sold-listing-sec">
                                        <div class="row">
                                          <?php for($i = 0; $i < count($soldProperty); $i++){ if(!isset($soldProperty[$i])) break;?>
                                            <div class="col-sm-4">
                                                <a href="javascript:void(0)" class="recently-sold-listing">
                                                    <?php if(isset($soldProperty[$i]->photos[0])){
                                                       echo Html::img($soldProperty[$i]->photos[0]->getImageUrl(PhotoGallery::THUMBNAIL)); 
                                                    }else{
                                                        echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                    }?>
                                                    <div class="recently-sold-con">
                                                        <p><span><?= Yii::$app->formatter->asCurrency($soldProperty[$i]->price)?></span> <?= $soldProperty[$i]->no_of_room?> BD  -  <?= $soldProperty[$i]->no_of_bathroom?> Ba  -  <?=  $soldProperty[$i]->no_of_toilet?> Balcony</p>
                                                        <p><?= $soldProperty[$i]->formattedAddress?></p>
                                                    </div>
                                                </a>
                                            </div>
                                          <?php }?>
                                        </div>

            <!--                            <a href="javascript:void(0)" class="show-more-recently-sold">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" class="less-more-recently-sold">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>-->
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $monthWiseProperty = [];
                    if($property->lat && $property->lng){
                        $addressList= Yii::$app->db->createCommand("SELECT count(id) as totalProperty,AVG(price) as avragePrice,MAX(price) as maxPrice,MIN(price) as minPrice, "
                                . "MONTH(FROM_UNIXTIME(created_at)) AS selectMonth,street_address,area,town,state,country,zip_code, lat, lng, "
                                . "( 6371 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians(".$property->lat.") ) * sin( radians( lat ) ) ) ) AS distance "
                                . "FROM mls_property $commonWhere $activeWhere GROUP BY selectMonth HAVING distance < $radius order by distance asc LIMIT 0 , 100")->queryAll();
    //                    yii\helpers\VarDumper::dump($addressList, 11,1);die();
                        if(!empty($addressList)){
                            foreach($addressList as $address){
                                $monthWiseProperty[$address['selectMonth']] =   $address;
                            } 
                        }
                    }
                    $monthWiseSoldProperty = [];
                    if($property->lat && $property->lng){
                        $addressSoldList= Yii::$app->db->createCommand("SELECT count(id) as totalProperty,AVG(price) as avragePrice,MAX(price) as maxPrice,MIN(price) as minPrice, "
                                . "MONTH(FROM_UNIXTIME(created_at)) AS selectMonth,street_address,area,town,state,country,zip_code, lat, lng, "
                                . "( 6371 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians(".$property->lat.") ) * sin( radians( lat ) ) ) ) AS distance "
                                . "FROM mls_property $commonWhere $soldWhere GROUP BY selectMonth HAVING distance < $radius order by distance asc LIMIT 0 , 100")->queryAll();
    //                    yii\helpers\VarDumper::dump($addressList, 11,1);die();
                        if(!empty($addressSoldList)){
                            foreach($addressSoldList as $address){
                                $monthWiseSoldProperty[$address['selectMonth']] =   $address;
                            } 
                        }
                    }
                    ?>
                    <div class="property-details-left-con average-price-listing" id="avg-price-nearby-properties" style="position: relative;">
                            <ul class="nav nav-tabs location-tabbar" role="tablist">
                                <li role="presentation" class="active"><a href="#average_price_active" aria-controls="agerage_price_active" role="tab" data-toggle="tab">Active</a></li>
                                <li role="presentation"><a href="#average_price_sold" aria-controls="agerage_price_sold" role="tab" data-toggle="tab"> Sold</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="average_price_active">
                                    <h4 class="property-details-title"><i class="ra-comparable-homes ra"><div></div></i> Average Prices Nearby <?= $property->shortAddress ?>: Active</h4>
                                    <div class="average-price-table-listing">
                                        <div class="table-responsive">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Average Price</th>
                                                    <th>Maximum Price</th>
                                                    <th>Minimum Price</th>
                                                    <th>Total No of Properties</th>
                                                    <!--<th>Total No of New Properties</th>-->
                                                </tr>
                                                <?php
                                                if (is_array($monthWiseProperty) && count($monthWiseProperty) > 0) {
                                                    foreach ($addressList as $monthName => $monthVal) {
                                                        $monthNum = sprintf("%02s", $monthVal["selectMonth"]);
                                                        //echo $monthNum;
                                                        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                                                        //echo $monthName;
                                                        ?>
                                                        <tr>
                                                            <td><?= $monthName ?></td>
                                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['avragePrice']) ?></td>
                                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['maxPrice']) ?></td>
                                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['minPrice']) ?></td>
                                                            <td><?= $monthVal['totalProperty'] ?></td>

                                                        </tr>
                                                        <?php
                                                    }
                                                }else{?>
                                                        <tr><td colspan="5">No Records Found</td></tr>
                                               <?php }?>
                                            </table>
                                        </div>
                                    </div>

                                    <?php
                                    if (count($monthWiseProperty) > 10) {
                                        ?>
                                        <a href="javascript:void(0)" class="show-more-Price">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" class="less-more-Price">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <div class="property-details-left-con property-details-chart">
                                        <?php
                                        $finalChartVal = [];
                                        //$monthArr = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];
                                        //yii\helpers\VarDumper::dump($monthArr); exit;
                                        for ($m = 1; $m <= 12; $m++) {
                                            $chartVal[$m] = 0;
                                        }
                                        foreach ($monthWiseProperty as $key => $val) { //echo $key;
                                            $chartVal[$key] = round($val['avragePrice']);
                                        }
                                        foreach ($chartVal as $val) {
                                            $finalChartVal[] = $val;
                                        }
                                        //yii\helpers\VarDumper::dump($finalChartVal);exit;
                                        //yii\helpers\VarDumper::dump([0,1,2,3,4,5,9,8,6,4,56,47])exit;
                                        echo Highcharts::widget([
                                            'scripts' => [
                                                'modules/exporting',
                                                'themes/grid-light',
                                            ],
                                            'options' => [
                                                'title' => [
                                                    'text' => 'Combination chart',
                                                ],
                                                'xAxis' => [
                                                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                                                ],
                                                'labels' => [
                                                    'items' => [
                                                        [
                                                            'html' => 'Average Price in this Area',
                                                            'style' => [
                                                                'left' => '50px',
                                                                'top' => '18px',
                                                                'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                                'series' => [
                                                    [
                                                        'type' => 'column',
                                                        'name' => 'Name of Months',
                                                        'data' => $finalChartVal,
                                                    ],
                                                ],
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            <div role="tabpanel" class="tab-pane" id="average_price_sold">
                                
                                <h4 class="property-details-title"><i class="ra-comparable-homes ra"><div></div></i> Average Prices Nearby <?= $property->shortAddress ?> Sold</h4>
                                    <div class="average-price-table-listing">
                                        <div class="table-responsive">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Average Price</th>
                                                    <th>Maximum Price</th>
                                                    <th>Minimum Price</th>
                                                    <th>Total No of Properties</th>
                                                    <!--<th>Total No of New Properties</th>-->
                                                </tr>
                                                <?php
                                                if (is_array($monthWiseSoldProperty) && count($monthWiseSoldProperty) > 0) {
                                                    foreach ($addressSoldList as $monthName => $monthVal) {
                                                        $monthNum = sprintf("%02s", $monthVal["selectMonth"]);
                                                        //echo $monthNum;
                                                        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                                                        //echo $monthName;
                                                        ?>
                                                        <tr>
                                                            <td><?= $monthName ?></td>
                                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['avragePrice']) ?></td>
                                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['maxPrice']) ?></td>
                                                            <td><?= Yii::$app->formatter->asCurrency($monthVal['minPrice']) ?></td>
                                                            <td><?= $monthVal['totalProperty'] ?></td>

                                                        </tr>
                                                        <?php
                                                    }
                                                }else{?>
                                                        <tr><td colspan="5">No Records Found</td></tr>
                                               <?php }
                                                ?>
                                            </table>
                                        </div>
                                    </div>

                                    <?php
                                    if (count($monthWiseSoldProperty) > 10) {
                                        ?>
                                        <a href="javascript:void(0)" class="show-more-Price">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" class="less-more-Price">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <div class="property-details-left-con property-details-chart">
                                        <?php
                                        $finalChartVal = [];
                                        //$monthArr = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];
                                        //yii\helpers\VarDumper::dump($monthArr); exit;
                                        for ($m = 1; $m <= 12; $m++) {
                                            $chartVal[$m] = 0;
                                        }
                                        foreach ($monthWiseSoldProperty as $key => $val) { //echo $key;
                                            $chartVal[$key] = round($val['avragePrice']);
                                        }
                                        foreach ($chartVal as $val) {
                                            $finalChartVal[] = $val;
                                        }
                                        //yii\helpers\VarDumper::dump($finalChartVal);exit;
                                        //yii\helpers\VarDumper::dump([0,1,2,3,4,5,9,8,6,4,56,47])exit;
                                        echo Highcharts::widget([
                                            'scripts' => [
                                                'modules/exporting',
                                                'themes/grid-light',
                                            ],
                                            'options' => [
                                                'title' => [
                                                    'text' => 'Combination chart',
                                                ],
                                                'xAxis' => [
                                                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                                                ],
                                                'labels' => [
                                                    'items' => [
                                                        [
                                                            'html' => 'Average Price in this Area',
                                                            'style' => [
                                                                'left' => '50px',
                                                                'top' => '18px',
                                                                'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                                'series' => [
                                                    [
                                                        'type' => 'column',
                                                        'name' => 'Name of Months',
                                                        'data' => $finalChartVal,
                                                    ],
                                                ],
                                            ]
                                        ]);
                                        ?>
                                    </div>
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
                    <?php if(!empty($place_photos)){?>
                    <div class="property-details-left-con photo-area-listing photopopupslider" id="photos-of-area">
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
                    
                    <div class="property-details-bottom-sec">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="property-details-bottom-left-list">
                                                    <div class="property-details-bottom-left-img">
                                                        <?php echo Html::img($property->listedBy->getImageUrl(User::THUMBNAIL), [
                                                              'class'=>'', 
                                                          ]);?>
                                                    </div>
                                                    <p>Listed by:<br> 
                                                    MLS® <a href="<?= Url::to(['user/view-profile', 'slug' => $property->listedBy->slug])?>" target="_blank"><span class="redTxt"><?= $property->listedBy->fullName?></span></a><br>
                                                    <?= $property->listedBy->PhoneNumber ?> 
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php
                                                if($property->listedBy->agency_id){
                                                    $agency = Agency::findOne($property->listedBy->agency_id);
                                                    if(!empty($agency)){
                                                ?>
                                                <div class="property-details-bottom-left-list">
                                                    <div class="property-details-bottom-left-img">
                                                        <img src="<?= $agency->photos[0]->imageUrl ?>" alt="" >
                                                    </div>
                                                    <p>Brokered by:<br>
                                                        <a href="<?= Url::to(['/agency/view', 'slug' => $agency->slug]) ?>" target="_blank"><span class="redTxt"><?= $agency->name ?></span></a><br>
                                                        <?= $agency->formattedAddress ?>
                                                    </p>
                                                </div>
                                                <?php 
                                                }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                </div>
                                <?php if($property->market_status == 'Sold' && !empty($contactModels)){
                                foreach($contactModels as $contact){
                                    $buyerAgentModel = common\models\Agent::find()->select(['id', 'agency_id', 'profile_id', 'slug', 'profile_image_file_name', 'profile_image_extension'])->where(['agentID' => $contact->agentID])->one();
                                ?>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="property-details-bottom-left-list">
                                                <div class="property-details-bottom-left-img">
                                                    <?php echo Html::img($buyerAgentModel->getImageUrl(User::THUMBNAIL), [
                                                              'class'=>'', 
                                                          ]);?>
                                                </div>
                                                <p>Sold by:<br> 
                                                        MLS® 
                                                        <span class="redTxt">
                                                            <a href="<?= Url::to(['user/view-profile', 'slug' => $buyerAgentModel->slug])?>" target="_blank">
                                                                <?php echo $contact->fullName;?>
                                                            </a>
                                                        </span>
                                                        <br>
                                                        <?php echo $contact->getMobile1() ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                                if($buyerAgentModel->agency_id){
                                                    $agency = Agency::findOne($buyerAgentModel->agency_id);
                                                    if(!empty($agency)){
                                                ?>
                                                <div class="property-details-bottom-left-list">
                                                    <div class="property-details-bottom-left-img">
                                                        <img src="<?= $agency->photos[0]->imageUrl ?>" alt="" >
                                                    </div>
                                                    <p>Brokered by:<br>
                                                        <a href="<?= Url::to(['/agency/view', 'slug' => $agency->slug]) ?>" target="_blank"><span class="redTxt"><?= $agency->name ?></span></a><br>
                                                        <?= $agency->formattedAddress ?>
                                                    </p>
                                                </div>
                                                <?php 
                                                }
                                                }
                                                ?>
                                        </div>
                                    </div>
                                </div>
                                <?php }}?>
                            </div>
                        </div>
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
                        <?= Html::a('<i class="fa fa-share-alt"></i> Share', 
                            ['/property/share-property','slug' => $property->slug,'propertyUrl' => $propertyUrl],
                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal']
                        ); ?>
                        <a href="<?= Url::to(['/property/print','slug' => $property->slug]) ?>" target="_blank" class="text-center"><i class="fa fa-print"></i> Print</a>
                    </div>
                    <!-- Property Details Save This Property -->

                    <!-- Property Details Social Icon -->
                    <div class="property-details-right-social">
                        <h4>Share On Social Media</h4>
                        <div class="social-share-items">  
                            <div class="pull-left">
                            <?= FacebookPlugin::widget(['type'=>FacebookPlugin::SHARE, 'settings' => ['size'=>'small', 'layout'=>'button_count', 'mobile_iframe'=>'false']]); ?>
                            <?= TwitterPlugin::widget(['type'=>TwitterPlugin::SHARE, 'settings' => ['size'=>'default']]) ?>
                            <?= GooglePlugin::widget(['type'=>GooglePlugin::SHARE, 'settings' => ['size'=>'small']]) ?>
                            </div>
                            
                            <a href="http://pinterest.com/pin/create/button/?description=Check+out+this+home+I+found+on+NaijaHouses.com.+&url=<?= Url::to(['property/view', 'slug' => $property->slug], true)?>" class="pinterest" target="_blank" style="color: #fff; padding: 2px 6px; float: left; margin-left: 6px;"><i class="fa fa-pinterest-square"></i></a>
                        </div>
                        
                    </div>
                    <!-- Property Details Social Icon -->
                    
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

                    <!-- Property Details Similar Property -->
                    <div class="property-details-right-similar-property">
                        <h4><i class="ra ra-similar-homes icon-space-right"></i> Similar Active Properties</h4>
                        <?php 
                        $cnt = 1;
                        if(!empty($activeProperty)){
                        ?>
                        <div class="similar-property-listing-right">
                        <?php
                            foreach($activeProperty as $similar){
                                if($cnt <= 10){
                            ?>
                                    <a href="<?php echo Url::to(['property/view', 'slug' => $similar->slug]) ?>" class="similar-property-listing">
                                        <?php
                                        $photosArr = $similar->photos;
                                        if(is_array($photosArr) && count($photosArr) > 0){
                                            foreach($photosArr as $photoKey => $photoVal){
                                                if($photoKey == 0){
                                                    if(isset($photoVal) && $photoVal != ''){
                                                        $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                        echo Html::img($alias);
                                                    }else{
                                                        Html::img(Yii::getAlias('@backend/web/images/banner_image/no-preview.jpg'));
                                                    }
                                                }
                                            }
                                        }else{
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['height' => '225px','width' => '100%','class' => 'galleryimg']);
                                        }
                                        ?>
                                        <div class="similar-property-content">
                                            <p class="btn btn-primary red-btn">View Details</p>
                                            <p class="similar-property-content-txt"><?= $similar->formattedAddress ?></p>
                                        </div>
                                    </a>
                            <?php 
                                }
                            $cnt++;
                            }
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                        
                    </div>
                    <!-- Property Details Similar Property -->
                    <?php 
                    if(!empty($soldProperty)){
                    ?>
                    <!-- Property Details Similar Property -->
                    <div class="property-details-right-similar-property">
                        <h4><i class="ra ra-similar-homes icon-space-right"></i> Similar Sold Properties</h4>
                        <div class="similar-property-listing-right">
                        <?php    
                            foreach($soldProperty as $sold){// echo 11;
                            ?>
                            <a href="<?php echo Url::to(['property/view', 'slug' => $sold->slug]) ?>" class="similar-property-listing">
                                <?php
                                $photosArr = $sold->photos;
                                if(is_array($photosArr) && count($photosArr) > 0){
                                    foreach($photosArr as $photoKey => $photoVal){
                                        if($photoKey == 0){
                                            if(isset($photoVal) && $photoVal != ''){
                                                $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                echo Html::img($alias);
                                            }else{
                                                Html::img(Yii::getAlias('@backend/web/images/banner_image/no-preview.jpg'));
                                            }
                                        }
                                    }
                                }else{
                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['height' => '350px','width' => '100%','class' => 'galleryimg']);
                                }
                                ?>
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt"><?= substr(Yii::$app->formatter->asCurrency($sold->price), 0, -3)?></p>
                                    <p class="similar-property-content-txt"><?= StringHelper::truncate($sold->formattedAddress, 40) ?></p>
                                </div>
                            </a>
                             <?php 
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- Property Details Right -->
            </div>
        </div>
    </div>
    <!-- Property Details Bottom -->
    <!-- Property Details Bottom -->
    <?php //echo Html::a('Contact Agent', 'javascript:void(0);',['class' => 'btn btn-primary contact-agent-btn','data-href' => Url::to(['/site/check-login'])]); ?>
</section>

<script type="foo/bar" id='usageList'>
    <div class="map-popup-box-list">
    <a href="<%= detail_url %>">
            <img src="<%= feature_image %>" alt="">
            <div class="map-popup-box-list-content">
                    <p class="map-popup-box-list-content-txt"><%= address %></p>
                    <p class="map-popup-box-list-content-txt"><span><%= price%></span> <strong><%= bedroom%> bd <i class="fa fa-circle" aria-hidden="true"></i> <%= bathroom %> ba</strong></p>


            </div>
    </a>
    </div>
</script>
<?php 

$js = "var soldItems = ". json_encode($soldItems). "
       var activeItems = ". json_encode($activeItems);

$this->registerJs($js, View::POS_HEAD);

//    $js = "$(function(){
//                $(document).on('click', '.contact-agent-btn', function(){ 
//                    var thisBtn = $(this);
//                    $.get(thisBtn.data('href'), function(response){ 
//                        if(response.status === false){ 
//                            $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
//                            $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
//                                $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
//                            });
//                        }else{ 
//                            $('#mls_bs_modal_one').modal({remote: '".Url::to(['/property/contact-agent','id' => $property->id])."'});
//                        }
//                    }, 'json');
//                    return false;
//                });
//            });";
//    $this->registerJs($js, View::POS_END);  

$js =   "$(function(){
            $(document).on('click', '.contact-agent-btn', function(){ 
                var thisBtn = $(this);
                $.get(thisBtn.data('href'), function(response){ 
                    if(response.status === false){ 
                        $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
                        $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                            $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                        });
                    }else{ 
                        $('#mls_bs_modal_one').modal({remote: '".Url::to(['/property/contact-agent','id' => $property->id,'propertyUrl' => Url::to(['property/view', 'slug' => $property->slug])])."'});
                    }
                }, 'json');
                return false;
            });
        });";
    $this->registerJs($js, View::POS_END); 
$js = "$(function(){
            $(document).on('click', '.bnt_showing_request_login', function(){ 
                var thisBtn = $(this);
                $.get(thisBtn.data('href'), function(response){ 
                    if(response.status === false){ 
                        $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
                        $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                            $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                        });
                    }else{ 
                        $('#mls_bs_modal_one').modal({remote: '".Url::to(['/property/request-showing','id' => $property->id,'propertyUrl' => $propertyUrl])."'});
                    }
                }, 'json');
                return false;
            });
            
        ". (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rs'?"$('.bnt_showing_request_login').trigger('click');":"")."

        });";
$this->registerJs($js, View::POS_END);  

$js = "$(function(){
            $(document).on('click', '.bnt_check_login', function(){ 
                var thisBtn = $(this);
                $.get(thisBtn.attr('href'), function(response){ 
                    if(response.status === false){ 
                        $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
                        $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                            $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                        });
                    }
                }, 'json');
                return false;
            });
            if(activeItems){
                initializeSold(activeItems, 'active');
            }
            $('a[data-toggle=tab]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr('href')
                if(target == '#sold' && soldItems){
                    initializeSold(soldItems, 'sold');
                }else if(target == '#active' && activeItems){
                    initializeSold(activeItems, 'active');
                }
            });
        });";
$this->registerJs($js, View::POS_END);  

$js = "$(function(){
        $('.frm_payment_calculator').submit();
        $('.areaphoto').gallerybox();
        $(document).on('click', '.save_as_favorite', function(){
        var thisBtn = $(this);
        $.get(thisBtn.data('href'), function(response){
            if(response.status === true){
                var markers = $('.realestate_map_view_container').find('.html_marker');
                if(response.insert === true){
                    thisBtn.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                    markers.each(function(){
                        if($(this).data('id') == response.id){
                            $(this).addClass('favorite');
                        }
                    });
                }else{
                    thisBtn.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                    markers.each(function(){
                        if($(this).data('id') == response.id){
                            $(this).removeClass('favorite');
                        }
                    });
                }
            }else{
                $('#mls_bs_modal_one').modal({remote: '".Url::to(['site/login', 'popup' => 1])."'});
                $('#mls_bs_modal_one').on('shown.bs.modal', function (e) {
                    $('#mls_bs_modal_one').find('.login_redirect_url').val(location.href);
                });
                
            }
        });
    });
    
    ".(!empty($LocalInfoItems)?"initializeLocalInfo(".$propMapJson.", ".  json_encode($LocalInfoItems).");":'')."
        
    ".(!empty($LocalInfoItems)?"$(document).on('click', '.local_info_filter_by_type', function(){
        var typeId = $(this).data('local_info_type_id');
        initializeLocalInfo(".$propMapJson.", ".  json_encode($LocalInfoItems).", typeId);
    });":'')."
    });";

$this->registerJs($js, View::POS_END);

$this->registerMetaTag(['property' => 'og:image', 'content' => $featureImage]);