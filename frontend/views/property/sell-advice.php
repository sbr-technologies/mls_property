<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Banner;
use common\models\BannerType;

$this->title = 'Sell Advice';
$this->params['breadcrumbs'][] = $this->title;

$bannerType = 1;
$banners = Banner::find()->where(['type_id' => $bannerType])->orderBy(['sort_order' => SORT_ASC])->active()->all();
?>

<!-- Start Slider Section ==================================================-->
<figure class="bannerwithsearch">
    <!-- Home Slider -->
    <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php
            if (!empty($banners)) {
                foreach ($banners as $key => $banner) {
                    $bannerUrl      =   '';
                    $photo = $banner->photo;
                    $alias = $photo->getImageUrl();
                    //echo Html::img($alias);
                    if($banner->property_id != ''){
                        $bProp = Property::findOne($banner->property_id);
                        if(!empty($bProp)){
                            $bannerUrl = Url::to(['property/view', 'slug' => $bProp->slug]);
                        }
                    }
                    ?>
                    <div class="item slider <?php echo $key == 0 ? 'active' : ''; ?>" style="background-image:url(<?php echo $photo->getImageUrl() ?>);">
                        <a href="<?= $bannerUrl ?>">
                            <div class="slidercontent">
                                <div class="container">
                                    <div class="figuretext"><?php echo Yii::$app->language == "ar" ? (!empty($banner->title_ar) ? $banner->title_ar : $banner->title) : $banner->title; ?></div>
                                    <div class="figuretextbottom"><?php echo Yii::$app->language == "ar" ? (!empty($banner->description_ar) ? $banner->description_ar : $banner->description) : $banner->description; ?></div>
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
<!--                            <div class="figuretext"><?php //echo Yii::$app->language == "ar" ? (!empty($banner->title_ar) ? $banner->title_ar : $banner->title) : $banner->title; ?></div>
                            <div class="figuretextbottom"><?php //echo Yii::$app->language == "ar" ? (!empty($banner->description_ar) ? $banner->description_ar : $banner->description) : $banner->description; ?></div>-->
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
                                <li role="presentation" class="active"><a href="#buy" aria-controls="buy" role="tab" data-toggle="tab">Buy</a></li>
                                <li role="presentation"><a href="#rent" aria-controls="rent" role="tab" data-toggle="tab">Rent</a></li>
                                <li role="presentation"><a href="#sell" aria-controls="sell" role="tab" data-toggle="tab">Sell</a></li>
                            </ul>

                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="buy">
                                <?= Html::beginForm(['property/search'], 'get', ['class' => 'frm_geocomplete','id' => 'buy_property_form']) ?>
                                    <div class="row">
                                        <div class="searchbox clearfix form-group-md">
                                            <?= Html::textInput('location', '', ['class' => 'form-control readonlyCls','id' => 'geocomplete','placeholder' => 'Address, City, State or Neighborhood']) ?>
                                            <div class="button_holder">
                                                <?= Html::submitButton('Search Now', ['class' => 'btn btn-button btn-block btn-md']) ?>
                                            </div>
                                            <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                                        </div>
                                    </div>
                                <?= Html::endForm() ?>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="rent">
                                <div class="row">
                                    <div class="searchbox clearfix form-group-md">
                                        <input type="text" class="form-control " placeholder="Address, City, State or Neighborhood">
                                        <div class="button_holder">
                                            <button type="submit" class="btn btn-button btn-block btn-md">Search Now</button>
                                        </div>
                                        <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="sell">
                                <div class="row">
                                    <div class="searchbox clearfix form-group-md">
                                        <input type="text" class="form-control " placeholder="Address, City, State or Neighborhood">
                                        <div class="button_holder">
                                            <button type="submit" class="btn btn-button btn-block btn-md">Search Now</button>
                                        </div>
                                        <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
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
<!-- End Slider Section ==================================================-->
<section>
    <!-- Service Sec -->
    <div class="home-service-sec property-sell-service-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home-service-list-sec">
                        <div class="col-sm-4">
                            <a href="javascript:void(0)">
                                <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-value.png" alt="">
                                <h3>View your estimated home value</h3>
                                <p>Nam sed luctus semn semper</p>
                            </a>
                        </div>

                        <div class="col-sm-4">
                            <a href="javascript:void(0)">
                                <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-report.png" alt="">
                                <h3>Know the personalized report</h3>
                                <p>Nam sed luctus semn semper</p>
                            </a>
                        </div>

                        <div class="col-sm-4">
                            <a href="javascript:void(0)">
                                <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-chart.png" alt="">
                                <h3>About sell your home info</h3>
                                <p>Nam sed luctus semn semper</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service Sec -->

    <!-- Sell your home Sec -->
    <div class="sell-home-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Want to Sell Your Home? <span>Follow The Steps</span></h2>

                    <div class="row">
                        <div class="home-sell-listing-sec">
                            <div class="col-sm-3">
                                <a href="javascript:void(0)" class="home-sell-listing">
                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/home-sell-listing-img1.jpg" alt="">
                                    <div class="home-sell-round">1 <span>step</span></div>
                                    <h3>Whip it into shape</h3>
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a href="javascript:void(0)" class="home-sell-listing">
                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/home-sell-listing-img2.jpg" alt="">
                                    <div class="home-sell-round">2 <span>step</span></div>
                                    <h3>Register as a Seller</h3>
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a href="javascript:void(0)" class="home-sell-listing">
                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/home-sell-listing-img3.jpg" alt="">
                                    <div class="home-sell-round">3 <span>step</span></div>
                                    <h3>Find a listing agent</h3>
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a href="javascript:void(0)" class="home-sell-listing">
                                    <img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/home-sell-listing-img4.jpg" alt="">
                                    <div class="home-sell-round">4 <span>step</span></div>
                                    <h3>List at the Right Price</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sell your home Sec -->
</section>