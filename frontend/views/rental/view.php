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


$this->title = $property->formattedAddress;
$activeProperty     =   Property::find()->where(['city' => $property->city, 'state' => $property->state])->andWhere(['<>', 'id', $property->id])->orderBy(['id' => SORT_ASC])->active()->limit(5)->all();
$soldProperty       =   Property::find()->where(['city' => $property->city, 'state' => $property->state])->andWhere(['<>', 'id', $property->id])->orderBy(['id' => SORT_ASC])->sold()->limit(5)->all();


$soldItems = [];
foreach($soldProperty as $listing){
    $soldItems[$listing->id] = ['id' => $listing->id, 'lat' => $listing->lat, 'lng' => $listing->lng, 'price' => $listing->price, 'price_as' => Yii::$app->formatter->asCurrency($listing->price),
        'bedroom' => $listing->no_of_room, 'bathroom' => $listing->no_of_bathroom, 'size' => round($listing->size). ' sq ft',
        'feature_image' => $listing->getFeatureImage(PhotoGallery::THUMBNAIL), 'detail_url' => Url::to(['property/view', 'slug' => $listing->slug]), 'address' => substr($listing->formattedAddress, 0, 20). '...',
        'city' => $listing->city, 'state' => $listing->state
        ];
}

$LocalInfoItems = [];
foreach ($property->rentalLocationLocalInfo as $localInfo){
    $LocalInfoItems[] = ['id' => $localInfo->id, 'info_type' =>  $localInfo->localInfoType->title, 'info_type_id' => $localInfo->local_info_type_id, 'title' => $localInfo->title, 'description' => $localInfo->description, 'lat' => $localInfo->lat, 'lng' => $localInfo->lng];
}

$propMapJson = json_encode(['title' => $property->formattedAddress, 'description' => $property->description, 'lat' => $property->lat, 'lng' => $property->lng]);

//\yii\helpers\VarDumper::dump($activeProperty); exit;
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

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
$location = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$property->lat},{$property->lng}&radius=5000&key=". Yii::$app->params['googlePhotoKey']);
$locationObj = json_decode($location);
foreach($locationObj->results as $result){
    if(isset($result->photos)){
        foreach($result->photos as $photo){
            $photo_reference = $photo->photo_reference;
            if($photo_reference){
                $place_photos[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photo_reference&key=". Yii::$app->params['googlePhotoKey'];
            }
        }
    }
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
                        <a href="javascript:void(0)" class="request-details-btn">Request details</a>
                        <!--<a href="javascript:void(0)" class="heart-btn"><i class="fa fa-heart-o" aria-hidden="true"></i></a>-->
                        <a href="javascript:void(0)" class="heart-btn save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i></a>
                        <ul>
                            <li><?= $property->formattedAddress ?> </li>
                            
                        </ul>
                        <ul>
                            <li><?= $property->no_of_room ?>  Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_balcony ?> Balcony<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_bathroom ?> Bath <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->lot_area ?> acres lot<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->size  ?> Sq. Ft.</li>
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
                            <div id="rental-menu-center">
                                <ul>
                                    <li><a href="#property-details" class="active smoothscrollproperty">Property Details</a></li>
                                    <?php
                                    if(isset($property->rentalLocationLocalInfo) && !empty($property->rentalLocationLocalInfo)){
                                    ?>
                                    <li><a href="#property-location" class="smoothscrollproperty">Property Location</a></li>
                                    <?php 
                                    } ?>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- On Scroll Top bar -->
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <?php
                if($property->user->profile->title == 'Agent'){
                ?>
                    <div class="property-details-user-top">
                        <div class="property-details-user-top-inner">
                            <div class="col-sm-12">
                                <div class="col-sm-5">
                                    <?php
                                    if(!empty($property->user->getImageUrl(User::THUMBNAIL))){
                                        echo Html::img($property->user->getImageUrl(User::THUMBNAIL), [
                                            'class'=>'', 
                                        ]);
                                    }else{
                                        echo Html::img(Yii::getAlias('@web/public_main/images/icon-user.png'), [
                                            'class'=>'', 
                                        ]);
                                    }
                                    
                                    ?>
                                    <p><span>Presented by:</span> <?= $property->user->fullName ? $property->user->fullName : "" ?> <?= $property->user->PhoneNumber ? $property->user->PhoneNumber : "" ?></p>
                                </div>
                                <?php 
                                $agency = $property->user->agency;
                                if(!empty($agency)){
                                ?>
                                <div class="col-sm-7">
                                    <?php 
                                        if(!empty($agency->photos[0])){ 
                                        ?>
                                            <img src="<?= $property->user->agency->photos[0]->imageUrl ?>" alt="" >
                                        <?php
                                        }else{
                                            echo Html::img(Yii::getAlias('@web/public_main/images/icon-user.png'), [
                                                'class'=>'', 
                                            ]);
                                        }
                                    ?>
                                    <p><span>Brokered by:</span> <?= $agency->name ? $agency->name : "" ?> ,<?= $agency->shortAddress  ? $agency->shortAddress : "" ?></p>
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
                        if(!empty($photos)){
                        ?>
                        <div id="slider" class="carousel slide" data-ride="carousel"> 
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
                                            $alias = $photo->getImageUrl($photo::LARGE);
                                            echo Html::img($alias,['height' => '350px','class' => 'galleryimg']);
                                        }else{
                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/add-photo-img.jpg'), [
                                            'class'=>'', 
                                        ]);
                                    
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
                        <div class="property-details-slider-bottom">
                            <div class="container">
                                <div class="row">
                                    <ul>
                                        <li>Type of Property: <span><?= $property->property_type_id ? $property->propertyType->title : "" ?></span></li>
                                        <li>Status of The Property: <span><?= $property->construction_status_id ? $property->constructionStatus->title : "" ?></span></li>
                                        <li>Categories: <span><?= $property->property_category_id ? $property->propertyCategory->title : "" ?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Property Details Slider Sec -->

                    <div class="property-details-left-titlePart">
                      <h3 class="property-details-price"><?= Yii::$app->formatter->asCurrency($property->price)?></h3>
                        <ul>
                            <li><?= $property->formattedAddress ?> </li>
                        </ul>
                        <ul>
                            <li><?= $property->no_of_room ?> Room<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_balcony ?> Balcony<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->no_of_bathroom ?> Bath <span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->lot_area ?> acres lot<span><i class="fa fa-circle" aria-hidden="true"></i></span></li>
                            <li><?= $property->size  ?> Sq. Ft.</li>
                        </ul>
                    </div>

                    <div class="property-details-left-con" id="property-details">
                        <h4 class="property-details-title">Property Details for <?= $property->formattedAddress ?></h4>
                        
                        <?php 
                        if(isset($property->rentalPlans) && !empty($property->rentalPlans)){ ?>
                            <h5 class="blackTitle">Floor Plan</h5>
                        <?php
                            foreach($property->rentalPlans as $rentalPlan){
                        ?>
                            <p><strong><?= $rentalPlan->rentalPlan->name ?> <strong></p>
                        <table class="table">
                            <tr>
                                <td>
                                    <?= $rentalPlan->name ?>
                                </td>
                                <td>
                                    <?= $rentalPlan->bed ?>
                                </td>
                                <td>
                                    <?= $rentalPlan->bath ?>
                                </td>
                                <td>
                                    <?= $rentalPlan->size ?>
                                </td>
                                <td>
                                    <?= $rentalPlan->price ?>
                                </td>
                            </tr>
                        </table>
                            <?php
                            }
                            
                        }
                        ?>
                         <p>
                            <?= Html::a('Request a Private Showing', 
                                ['/rental/request-showing','id' => $property->id],
                                ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal','class' => 'btn btn-default red-btn']
                            ); ?>
                        </p> 
                        <h5 class="blackTitle">Overview</h5>

                        <p><?= $property->description ?></p>
                        
                        <h6><span>Key Facts</span></h6>
                        <ul>

                            <li>Lift: <span><?= $property->lift ? $property->isLift : "" ?></span></li>
                            <li>Furnished: <span><?= $property->furnished ? $property->isFurnished : ""?></span></li>
                            <li>Water Availability : <?= $property->water_availability ? $property->isWaterAvailability : "" ?></li>
                            <li>Electricity Status : 
                                <?php if(!empty($property->electricityTypes)){
                                    foreach($property->electricityTypes as $electricity){
                                        echo $electricity->name.", ";
                                    }
                                }?>
                            </li>
                            <li>Status: <span><?= $property->status ?></span></li>
                        </ul>
                        <?php
                        //yii\helpers\VarDumper::dump($property->propertyFeatures,4,12);
                        if(isset($property->propertyFeatures) && !empty($property->propertyFeatures)){
                        ?>
                        <h6><span>Features</span></h6>

                        <div class="features-listing-sec">
                            <div class="row">
                                <?php
                                foreach($property->propertyFeatures as $feature){ 
                                $photos = $feature->photos;
                                ?>
                                <div class="col-sm-3 features-listing">
                                    <h4><?= $feature->featureMaster->name  ?></h4>
                                    <a href="javascript:void(0)">
                                        <div class="item <?= $active ?>">
                                        <?php
                                        foreach ($photos as $key => $photo) {
                                            if($key == 0){
                                                $active     =   'active';
                                            }else{
                                                $active     =   '';
                                            }
                                            ?>

                                            <?php
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
                                            if(count($itemListArr) <= 3){
                                                foreach($itemListArr as $key => $item){     
                                        ?>  
                                                    <li><?= $item->name ?></li>
                                                <?php
                                                }
                                            }else{
                                                foreach($itemListArr as $key => $item){ 
                                                    if($key <= 2){
                                                    ?>  
                                                    <li><?= $item->name ?></li>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <li class="features-listing-sub">
                                                    <ul>
                                                        <?php
                                                        foreach($itemListArr as $key => $menu){
                                                            if($key > 2){
                                                        ?>   
                                                            <li><?= $item->name ?></li>
                                                        <?php
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
                                </div>
                                <?php
                                
                                $js = "$(function(){
                                        $('.featuresimg_$feature->id').gallerybox();
                                    });";
                                    $this->registerjs($js, View::POS_END);
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
                    if(isset($property->rentalLocationLocalInfo) && !empty($property->rentalLocationLocalInfo)){
                    ?>
                        <div class="property-location-sec" id="property-location">
                            <h4 class="property-details-title">Local Information to a Property Location</h4>
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
                                                        if(isset($property->rentalLocationLocalInfo) && !empty($property->rentalLocationLocalInfo)){?>
                                                        <li class=""><a href="javascript:void(0)" class="local_info_filter_by_type" data-local_info_type_id="0"><span class="property-location-icons icon-bank"></span> All</a></li>
                                                        <?php    
                                                            $localLocationDataArr = $property->rentalLocationLocalInfo;
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
                                                if(isset($property->rentalLocationLocalInfo) && !empty($property->rentalLocationLocalInfo)){
                                                    foreach($property->rentalLocationLocalInfo as $key => $locationData){
                                                ?>
                                                <tr>
                                                    <td><span class="property-location-icons icon-bank"></span> <?= $locationData->localInfoType->title ?></td>
                                                    <td><?= $locationData->title  ?></td>
                                                    <td><?= $locationData->distance ?> Km</td>
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
                    
                    <div class="property-details-left-con active-sold-listing">
                        <ul class="nav nav-tabs location-tabbar" role="tablist">
                            <li role="presentation" class="active"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">Active</a></li>
                            <li role="presentation"><a href="#sold" aria-controls="sold" role="tab" data-toggle="tab"> Sold</a></li>
                        </ul>
                        
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="active">
                                <h4 class="property-details-title">Properties Nearby <?= $property->formattedAddress ?> Active</h4>
                                <div class="active-sold-table-listing">
                                    <div class="table-responsive">
                                        <?php
                                        // \yii\helpers\VarDumper::dump($activeProperty,4,12); exit;
                                        
                                            $finalActiveData[]  =   [
                                                       'address' => 'This Home : '. $property->formattedAddress,
                                                       'no_of_room' => $property->no_of_room,
                                                       'no_of_bathroom'    =>  $property->no_of_bathroom,
                                                       'price'    =>  $property->price,
                                                       'size'    =>  $property->size,
                                                       'lot_area'    =>  $property->lot_area,
                                                   ];
                                         foreach($activeProperty as $active){
                                            $finalActiveData[]  =   [
                                                                        'address' => Html::a($active->formattedAddress, ['/property/view', 'slug' => $active->slug]),
                                                                        'no_of_room' => $active->no_of_room,
                                                                        'no_of_bathroom'    =>  $active->no_of_bathroom,
                                                                        'price'    =>  $active->price,
                                                                        'size'    =>  $active->size,
                                                                        'lot_area'    =>  $active->lot_area,
                                                                    ];
                                         }
                                         
                    
                                        ?>
                                        <?= \nullref\datatable\DataTable::widget([
                                            'scrollY' => '200px',
                                            'scrollCollapse' => true,
                                            'paging' => false,
                                            "searching"=> false,
                                            'aaSorting' => [],
                                            //"infoCallback" => false,
                                            'data' => $finalActiveData,
                                            'columns' => [
                                                'address',
                                                'no_of_room',
                                                'no_of_bathroom',
                                                'price',
                                                'size',
                                                'lot_area',
                                            ],
                                        ]) ?>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="sold">
                                <h4 class="property-details-title">Properties Nearby <?= $property->formattedAddress ?> Sold</h4>
                                <div class="active-sold-table-listing">
                                    <div class="table-responsive">
                                        <?php
                                        // \yii\helpers\VarDumper::dump($activeProperty,4,12); exit;
                                        $finalSoldData    =   [];
                                        foreach($soldProperty as $sold){
                                            $finalSoldData[]    =   [
                                                                    'address'          => $sold->formattedAddress,
                                                                    'no_of_room'        => $sold->no_of_room,
                                                                    'no_of_bathroom'    =>  $sold->no_of_bathroom,
                                                                    'price'             =>  $sold->price,
                                                                    'size'              =>  $sold->size,
                                                                    'lot_area'          =>  $sold->lot_area,
                                                                ];
                                        }
                                        ?>
                                        <?= \nullref\datatable\DataTable::widget([
                                            'scrollY' => '200px',
                                            'scrollCollapse' => true,
                                            'paging' => false,
                                            "searching"=> false,
                                            //"infoCallback" => false,
                                            'data' => $finalSoldData,
                                            'columns' => [
                                                'address',
                                                'no_of_room',
                                                'no_of_bathroom',
                                                'price',
                                                'size',
                                                'lot_area',
                                            ],
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $monthWiseProperty = [];
                    $addressList= Yii::$app->db->createCommand("SELECT id,count(id) as totalProperty,AVG(price) as avragePrice,MAX(price) as maxPrice,MIN(price) as minPrice, MONTH(FROM_UNIXTIME(created_at)) AS selectMonth,address1,address2,city,state,country,zip_code, lat, lng, ( 3959 * acos( cos( radians(".$property->lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$property->lng.") ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM mls_property GROUP BY selectMonth HAVING distance < 100000 LIMIT 0 , 20")->queryAll();
                    if(is_array($addressList) && count($addressList)){
                        foreach($addressList as $address){
                            $monthWiseProperty[$address['selectMonth']] =   $address;
                        } 
                        
                    ?>
                        <div class="property-details-left-con average-price-listing">
                            <h4 class="property-details-title">Average Price Nearby <?= $property->formattedAddress ?></h4>
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
                                        if(is_array($monthWiseProperty) && count($monthWiseProperty) > 0){
                                            foreach($addressList as $monthName => $monthVal){
                                                $monthNum = sprintf("%02s", $monthVal["selectMonth"]);
                                                //echo $monthNum;
                                                $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                                                //echo $monthName;
                                            ?>
                                                <tr>
                                                    <td><?= $monthName ?></td>
                                                    <td>$<?= $monthVal['avragePrice'] ?></td>
                                                    <td>$<?= $monthVal['maxPrice'] ?></td>
                                                    <td>$<?= $monthVal['minPrice'] ?></td>
                                                    <td><?= $monthVal['totalProperty'] ?></td>

                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                            if(count($monthWiseProperty) > 10){
                            ?>
                                <a href="javascript:void(0)" class="show-more-Price">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" class="less-more-Price">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>
                            <?php 
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="property-details-left-con property-details-chart">
                        <?php
                        //$monthArr = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];
                        
                        //yii\helpers\VarDumper::dump($monthArr); exit;
                        for($m=1; $m <= 12; $m++){
                            $chartVal[$m]   =   0;
                        }
                        foreach($monthWiseProperty as $key => $val){ //echo $key;
                            $chartVal[$key] = round($val['avragePrice']);  
                        }
                        foreach($chartVal as $val){
                            $finalChartVal[]    =   $val;
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
                                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'],
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
                    <?php if(!empty($place_photos)){?>
                    <div class="property-details-left-con photo-area-listing photopopupslider">
                      <h4 class="property-details-title">Photo of the area</h4>
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
                    <div class="property-details-left-con recently-sold-sec">
                        <h4 class="property-details-title">Recently Sold Homes Near <?= $property->formattedAddress ?></h4>
                        <div id="xPopup" class="map-popup-box-sold"></div>
                        <div id="realestate_view_sold_container" class="realestate_view_sold_container" style="height:330px;"></div>
                        
                        <div class="recently-sold-listing-sec">
                            <div class="row">
                              <?php for($i = 0; $i < 3; $i++){ if(!isset($soldProperty[$i])) break;?>
                                <div class="col-sm-4">
                                    <a href="javascript:void(0)" class="recently-sold-listing">
                                      <img src="<?= $soldProperty[$i]->photos[0]->getImageUrl(PhotoGallery::THUMBNAIL)?>" alt="">
                                        <div class="recently-sold-con">
                                            <p><span><?= Yii::$app->formatter->asCurrency($soldProperty[$i]->price)?></span> <?= $soldProperty[$i]->no_of_room?> BD  -  <?= $soldProperty[$i]->no_of_bathroom?> Ba  -  <?=  $soldProperty[$i]->no_of_balcony?> Balcony</p>
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
                    
                    <?php
                        if($property->user->profile->title == 'Agent'){
                    ?>
                    <div class="property-details-bottom-sec">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6 property-details-bottom-left">
                                    <div class="property-details-bottom-left-list">
                                        <div class="property-details-bottom-left-img">
                                            <?php
                                            echo Html::img($property->user->getImageUrl(User::THUMBNAIL), [
                                                'class'=>'img-thumbnail', 
                                            ]);
                                            ?>
                                        </div>
                                        <p>Presented by:<br>
                                            MLS® <span class="redTxt"><?= $property->user->fullName ? $property->user->fullName : "" ?></span><br>
                                            <?= $property->user->PhoneNumber ? $property->user->PhoneNumber : "" ?> 	
                                        </p>
                                    </div>
                                </div>

                                <div class="col-sm-6 property-details-bottom-right">
                                    <?php 
                                    $agency = $property->user->agency;
                                    if(!empty($agency)){
                                    ?>
                                        <div class="property-details-bottom-left-list">
                                            <div class="property-details-bottom-left-img">
                                                <?php 
                                                    if(!empty($agency->photos[0])){ 
                                                    ?>
                                                        <img src="<?= $property->user->agency->photos[0]->imageUrl ?>" alt="" >
                                                    <?php
                                                    }
                                                ?>

                                            </div>
                                            <p>Brokered by:<br>
                                                <span class="redTxt"><?= $agency->name ? $agency->name : "" ?></span><br>
                                                <?= $agency->formattedAddress ? $agency->formattedAddress : "" ?></p>
                                        </div>
                                    <?php
                                    }
                                    ?>
<!--                                    <div class="table-responsive">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                                            <tr>
                                                <td width="40%">Broker Location:</td>
                                                <td width="60%"><?= $property->user->formattedAddress ?></td>
                                            </tr>
                                        </table>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    ?>
                </div>
                <!-- Property Details Left -->

                <!-- Property Details Right -->
                <div class="col-sm-3 property-details-right">
                    <!-- Property Details Form -->
                    <?php
                    if(Yii::$app->user->isGuest){
                    ?>
                        <p style="text-align:center;">
                           <?= Html::a(Yii::t('app', 'Please login to get this property services'), ['property/enquiery'], ['class' => 'btn btn-default red-btn bnt_check_login']) ?>
                        </p>
                    <?php
                    }else{
                    ?>
                        <div class="property-details-form">
                            <h3>Tell Me About This Property</h3>
                            <div class="property-details-form-inner">
                                <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                                    <!--<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>-->
                                    <span class="sucmsgdiv"></span>
                                </div>
                                <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                                    <!--<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>-->
                                    <span class="failmsgdiv"></span>
                                </div>
                                <?php 
                                $propertyEnquiry->model_id  = $property->id;
                                $propertyEnquiry->model     = "Property";
                                ?>
                                <?php $form = ActiveForm::begin(['method' => 'post','action' => ['rental/enquiery'],'options' => ['id' => 'frm_property_enquiery']]); ?>
                                    <?= $form->field($propertyEnquiry, 'model_id')->hiddenInput()->label(false) ?>
                                    <?= $form->field($propertyEnquiry, 'model')->hiddenInput()->label(false) ?>
                                    <?= $form->field($propertyEnquiry, 'property_url')->hiddenInput(['value' => $propertyUrl])->label(false) ?>

                                    <div class="form-group">
                                        <?= $form->field($propertyEnquiry, 'name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Full Name','value' => $userModel->fullName])->label(false) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($propertyEnquiry, 'email')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Email Address','value' => $userModel->email])->label(false) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($propertyEnquiry, 'phone')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Phone','value' => $userModel->mobile1])->label(false) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($propertyEnquiry, 'message')->textArea(['maxlength' => true,'class'=>'form-control','placeholder'=>'Im interested in','rows' => '3','style' => 'resize:none;'])->label(false) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= Html::submitButton($propertyEnquiry->isNewRecord ? Yii::t('app', 'Property Enquiry') : Yii::t('app', 'Update'), ['class' => $propertyEnquiry->isNewRecord ? 'btn btn-primary red-btn bnt_property_enquery' : 'btn btn-primary gray-btn']) ?>
                                    </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    <?php 
                    }
                    ?>
                    <!-- Property Details Form -->

                    <!-- Property Details Save This Property -->
                    <div class="save-property-box">
                        <h5><a href="javascript:void(0)" class="heart-btn save_as_favorite" data-href="<?= Url::to(['property/save-favorite', 'id' => $property->id]);?>"><i class="fa <?= PropertyHelper::isFavorite($property->id)? 'fa-heart':'fa-heart-o'?>" aria-hidden="true"></i> Save This Property</a></h5>
                        <a href="javascript:void(0)">Share</a>
                        <a href="javascript:void(0)">Print</a>
                    </div>
                    <!-- Property Details Save This Property -->

                    <!-- Property Details AD -->
                    <div class="property-details-right-ad">
                        <a href="javascript:void(0)">
                            <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/prpperty-details-ad.png" alt="">
                        </a>
                    </div>
                    <!-- Property Details AD -->

                    <!-- Property Details Social Icon -->
                    <div class="property-details-right-social">
                        <h4>Share This Property On Your Social Media</h4>
                        <a href="javascript:void(0)" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="rss"><i class="fa fa-rss" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    </div>
                    <!-- Property Details Social Icon -->

                    <!-- Property Details Similar Property -->
                    <div class="property-details-right-similar-property">
                        <h4>Similar Property</h4>
                        <?php 
                        if(!empty($activeProperty)){
                        ?>
                        <div class="similar-property-listing-right">
                        <?php
                            foreach($activeProperty as $properties){
                            ?>
                                <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>" class="similar-property-listing">
                                    <?php
                                    $photosArr = $properties->photos;
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
                                    }
                                    ?>
                                    <div class="similar-property-content">
                                        <p class="btn btn-primary red-btn">View Details</p>
                                        <p class="similar-property-content-txt"><?= $properties->formattedAddress ?></p>
                                    </div>
                                </a>
                            <?php 
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
                        <h4>Recently Sold Homes</h4>
                        <div class="similar-property-listing-right">
                        <?php    
                            foreach($soldProperty as $properties){
                            ?>
                            <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>" class="similar-property-listing">
                                <?php
                                $photosArr = $properties->photos;
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
                                    <p class="sold-priceTxt"><?= $properties->price ? $properties->price : "N/A" ?></p>
                                    <p class="similar-property-content-txt"><?= $properties->formattedAddress ?></p>
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
                    <!-- Property Details Similar Property -->

                    <!-- Property Details AD -->
                    <div class="property-details-right-ad">
                        <a href="javascript:void(0)">
                            <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/prpperty-details-ad.png" alt="">
                        </a>
                    </div>
                    <!-- Property Details AD -->
                </div>
                <!-- Property Details Right -->
            </div>
        </div>
    </div>

    <!-- Property Details Bottom -->
    
    <!-- Property Details Bottom -->
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
$js = "$(function(){
        $('.areaphoto').gallerybox();
        $('.frm_payment_calculator').submit();
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
    
    initializeSold(".  json_encode($soldItems).");
    initializeLocalInfo(".$propMapJson.", ".  json_encode($LocalInfoItems).");
        
    $(document).on('click', '.local_info_filter_by_type', function(){
        var typeId = $(this).data('local_info_type_id');
        initializeLocalInfo(".$propMapJson.", ".  json_encode($LocalInfoItems).", typeId);
    });
    });";

$this->registerJs($js, View::POS_END);