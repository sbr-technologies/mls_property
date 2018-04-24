<?php

use yii\helpers\Html;
use common\models\Property;
use yii\helpers\Url;

$properties = Property::find()->all();
?>
<section>
    <!-- Property Menu Bar -->
    <?php
    echo $this->render('//shared/_property_search_filtter', []);
    ?>
    <div class="property-search-sec" id="demo">
        <!-- Property Search Left bar -->
        <div class="col-sm-7 property-search-map-sec">
            <div class="property-search-map-inner">
                <iframe class="property-search-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50904.68150169838!2d-84.11612891001963!3d37.116004250371745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x885ccd149736c703%3A0x621951e47307cc98!2sLondon%2C+KY%2C+USA!5e0!3m2!1sen!2sin!4v1486015090030" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
        <!-- Property Search Left bar -->

        <!-- Property Search right bar -->
        <div class="col-sm-5 property-search-right-outer">
            <div class="property-search-right-sec">
                <div class="property-search-right-topbar">
                    <h2>London TX Real Estate</h2>
                    <p>4 homes for sale</p>
                </div>

                <div class="propery-search-title-bar">
                    <a href="javascript:void(0)" class="btn btn-default pull-right active">Map</a>
                    <a href="javascript:void(0)" class="btn btn-default pull-right">List</a>
                </div>

                <div class="property-search-tabbar-sec">
                    <div class="property-search-tabbar">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#homes-for-you" aria-controls="buy" role="tab" data-toggle="tab">Homes For You</a></li>
                            <li role="presentation"><a href="#newest" aria-controls="newest" role="tab" data-toggle="tab">Newest</a></li>
                            <li role="presentation"><a href="#cheapest" aria-controls="cheapest" role="tab" data-toggle="tab">Cheapest</a></li>
                            <li role="presentation"><a href="#more" aria-controls="more" role="tab" data-toggle="tab">More</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane tab-contentheight active" id="homes-for-you">
                            <?php
                            if (!empty($properties)) {      
                                foreach ($properties as $key => $property) {
                                ?>
                                <div class="property-search-listing-sec">
                                    <div class="property-search-listing">
                                        <a href="javascript:void(0)">
                                            <?php
                                                $photosArr = $property->photos;
                                                if(is_array($photosArr) && count($photosArr) > 0){
                                                    foreach($photosArr as $photoKey => $photoVal){
                                                        if($photoKey == 0){
                                                            if(isset($photoVal) && $photoVal != ''){
                                                                $alias = $photoVal->getImageUrl($photoVal::LARGE);
                                                                echo Html::img($alias,['class' => 'property-search-listing-img']);
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'property-listing-img']);
                                                }
                                                ?>
                                            <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> <?= count($photosArr) ?></span>
                                            <span class="property-right-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                            <div class="property-search-listing-bottom">
                                                <h3><?php echo Yii::$app->language == "ar" ? (!empty($property->title_ar) ? $property->title_ar : $property->title) : $property->title; ?></h3>
                                                <span class="btn btn-default btn-sm green-new-btn">New</span>
                                                <div class="property-listing-save-icon">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </div>
                                                <div class="clearfix"></div>
                                                <p class="priceTxt"><?php echo Yii::$app->language == "ar" ? (!empty($property->price_ar) ? $property->price_ar : $property->price) : $property->price; ?></p>
                                                <div class="property-search-listing-details">
                                                    <span><?php echo Yii::$app->language == "ar" ? (!empty($property->no_of_room_ar) ? $property->no_of_room_ar : $property->no_of_room) : $property->no_of_room; ?> Beds</span> |
                                                    <span><?php echo Yii::$app->language == "ar" ? (!empty($property->no_of_bathroom_ar) ? $property->no_of_bathroom_ar : $property->no_of_bathroom) : $property->no_of_bathroom; ?> Bathrooms</span> |
                                                    <span><?php echo Yii::$app->language == "ar" ? (!empty($property->size_ar) ? $property->size_ar : $property->size) : $property->size; ?></span> Sqr. Ft.
                                                </div>
                                            </div>
                                        </a>
                                    </div> 
                                </div>
                            <?php
                                }
                            }else{
                            ?>
                                <div class="alert alert-info margine10top">
                                    <i class="fa fa-info"></i>					
                                    No Property found.
                                </div>
                            <?php  
                            }
                            ?>
                            
                        </div>

                        <div role="tabpanel" class="tab-pane tab-contentheight" id="newest">
                            <div class="property-search-listing-sec">
                                <div class="property-search-listing">
                                    <a href="javascript:void(0)">
                                        <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/property-search-listing-img4.jpg" alt="" class="property-search-listing-img">
                                        <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> 10</span>
                                        <span class="property-right-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                        <div class="property-search-listing-bottom">
                                            <h3>206 Heritage Way, London, KY 40741</h3>
                                            <span class="btn btn-default btn-sm green-new-btn">New</span>
                                            <div class="property-listing-save-icon">
                                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="clearfix"></div>
                                            <p class="priceTxt">$299,000</p>
                                            <div class="property-search-listing-details">
                                                <span>2325 sqft</span> |
                                                <span>4 bed</span> |
                                                <span>3 bath</span> |
                                                <span>1garage</span> |
                                                <span>2 car park</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane tab-contentheight" id="cheapest">
                            <div class="property-search-listing-sec">
                                <div class="property-search-listing">
                                    <a href="javascript:void(0)">
                                        <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/property-search-listing-img3.jpg" alt="" class="property-search-listing-img">
                                        <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> 10</span>
                                        <span class="property-right-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                        <div class="property-search-listing-bottom">
                                            <h3>206 Heritage Way, London, KY 40741</h3>
                                            <span class="btn btn-default btn-sm green-new-btn">New</span>
                                            <div class="property-listing-save-icon">
                                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="clearfix"></div>
                                            <p class="priceTxt">$299,000</p>
                                            <div class="property-search-listing-details">
                                                <span>2325 sqft</span> |
                                                <span>4 bed</span> |
                                                <span>3 bath</span> |
                                                <span>1garage</span> |
                                                <span>2 car park</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane tab-contentheight" id="more">
                            <div class="property-search-listing-sec">
                                <div class="property-search-listing">
                                    <a href="javascript:void(0)">
                                        <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/property-search-listing-img2.jpg" alt="" class="property-search-listing-img">
                                        <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> 10</span>
                                        <span class="property-right-star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                        <div class="property-search-listing-bottom">
                                            <h3>206 Heritage Way, London, KY 40741</h3>
                                            <span class="btn btn-default btn-sm green-new-btn">New</span>
                                            <div class="property-listing-save-icon">
                                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            </div>
                                            <div class="clearfix"></div>
                                            <p class="priceTxt">$299,000</p>
                                            <div class="property-search-listing-details">
                                                <span>2325 sqft</span> |
                                                <span>4 bed</span> |
                                                <span>3 bath</span> |
                                                <span>1garage</span> |
                                                <span>2 car park</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Property Search right bar -->
    </div>
</section>
