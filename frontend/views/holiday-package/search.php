<?php

use yii\helpers\Html;
use common\models\HolidayPackage;
use yii\helpers\Url;


$this->registerJsFile(
    '@web/public_main/js/holiday-package.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title        = $locationFromId. ' to ' . $locationToId .' Holiday Package for - '. Yii::$app->name;
$holidayPackages    = $dataProvider->getModels();
//\yii\helpers\VarDumper::dump($holidayPackages,4,12); exit;
?>
<!-- Start Content Section ==================================================-->
<section>
    <div class="property-menu-bar hoter-top-bar holiday-package-top-bar">
        <div class="container">
            <div class="row">
                <!-- Property Menu Bar -->
                <?= Html::beginForm(['holiday-package/search'], 'get', ['class' => 'frm_geocomplete frm_package_page_search', 'id' => 'holiday_package_form']) ?>
                <?= Html::hiddenInput('location_from', $locationFromId, ['class' => 'package_search_location_from form-control', 'placeholder' => 'From']) ?>
                <?= Html::hiddenInput('location_to', $locationToId, ['class' => 'package_search_location_to form-control', 'placeholder' => 'To']) ?>
                <div class="col-sm-3">
                    <?php echo $this->render('_from_location_suggestion'); ?>
                </div>
                <div class="col-sm-3">
                    <?php echo $this->render('_to_location_suggestion'); ?>
                </div>
                <div class="col-sm-3">
                    <div class="date-field">
                        <select class="form-control package_search_travel_month" name="checkin">
                            <option value="">Month of travel(any)</option>
                            <option value="JUN2017" <?php if($month_year_travel == 'JUN2017') echo 'selected'?>>June 2017</option>
                            <option value="JUL2017" <?php if($month_year_travel == 'JUL2017') echo 'selected'?>>July 2017</option>
                            <option value="AUG2017" <?php if($month_year_travel == 'AUG2017') echo 'selected'?>>August 2017</option>
                            <option value="SEP2017" <?php if($month_year_travel == 'SEP2017') echo 'selected'?>>September 2017</option>
                            <option value="OCT2017" <?php if($month_year_travel == 'OCT2017') echo 'selected'?>>October 2017</option>
                            <option value="NOV2017" <?php if($month_year_travel == 'NOV2017') echo 'selected'?>>November 2017</option>
                            <option value="DEC2017" <?php if($month_year_travel == 'DEC2017') echo 'selected'?>>December 2017</option>
                        </select>
                        <!--<span><i class="fa fa-calendar" aria-hidden="true"></i></span>-->
                    </div>
                </div>

                <div class="col-sm-3">
                    <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_holiday-package']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
<!--                    <div class="holiday-package-listing-top">
                        <ul>
                            <li>Sort By: <strong>Popular</strong></li>
                            <li>Price: <a href="javascript:void(0)">Low to High</a></li>
                            <li>Price: <a href="javascript:void(0)">High to Low</a></li>
                        </ul>
                        <a href="javascript:void(0)" class="btn btn-default red-btn pull-right booking-enquiry-btn" data-toggle="modal" data-target="#enquiryModal">Booking Enquiry</a>
                    </div>-->

                    <?php 
                    if(!empty($holidayPackages)){
                        foreach($holidayPackages as $package){
                    ?>
                            <div class="holiday-package-listing">
                                <h3><?= $package->name ?></h3>
                                <div class="col-sm-4 package-listing-left">
                                    <a href="javascript:void(0)">
                                        <?php 
                                        $photo                =   $package->photos; 
                                        //\yii\helpers\VarDumper::dump($photo[0],4,12); exit;
                                            if(!empty($photo)){
                                                $alias = $photo[0]->getImageUrl($photo[0]::LARGE);
                                                echo Html::img($alias);
                                            }else{
                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['alt' => '']);
                                            }
                                        ?>
                                    </a>
                                </div>
                                <div class="col-sm-8 package-listing-right">
                                    <p><?= $package->description ?></p>
                                    <?php
                                    $featurListArr = $package->holidayFeatures;
                                    if(is_array($featurListArr) && count($featurListArr) > 0){
                                    ?>
                                    <h4>Hotels Included in package</h4>
                                    <div class="package-tab-sec">
                                        <div class="custom-check-radio">
                                            <form name="">
                                                <?php
                                                foreach($featurListArr as $feature){
                                                ?>
                                                <label>
                                                    <input type="radio" name="group1" class="<?= $feature->holidayPackageType->name ?> trigger" data-rel="<?= $feature->holidayPackageType->name ?>" checked>
                                                    <span class="lbl"><?= $feature->holidayPackageType->name ?></span>
                                                </label>
                                                <?php
                                                    }
                                                ?>
                                            </form>
                                        </div>

                                        <div class="package-tab-inner-con">
                                            <?php
                                            foreach($featurListArr as $featurKey => $feature){
                                                if($featurKey == 0){
                                                    $dispaly = "display:block;";
                                                }else{
                                                    $dispaly = "";
                                                }
                                                $featureItem = $feature->holidayPackageFeatureItems;
                                                //yii\helpers\VarDumper::dump($featureItem,4,12); 
                                                ?>
                                                <div class="<?= $feature->holidayPackageType->name ?> package-content" style="<?= $dispaly ?>">
                                                    <?php 
                                                    if(is_array($featureItem) && count($featureItem) > 0){
                                                    ?>
                                                    <ul>
                                                    <?php
                                                        foreach($featureItem as $item){
                                                    ?>
                                                        <li><?= $item->name ?></li>
                                                    <?php
                                                        }
                                                    ?>
                                                    </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            <?php
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                    ?>
                                </div>
                                <div class="package-listing-bottom">
                                    <p class="package-priceTxt">
                                        <img src="images/coin-icon.png" alt="">
                                        <span><strong><?= Yii::$app->formatter->asCurrency($package->package_amount) ?></strong></span>
                                    </p>
                                    <a href="<?= Url::to(['holiday-package/package-details', 'id' => $package->id])?>" class="btn btn-default red-btn pull-right package-view-details-btn">View Details</a>
                                    <a href="<?= Url::to(['holiday-package/package-booking', 'id' => $package->id])?>" class="btn btn-default red-btn pull-right package-book-online-btn">Book Online</a>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$js = "$(function(){
         $('.txt_from_location').val('$fromLocation');
         $('.txt_to_location').val('$toLocation');
       });";
$this->registerJs($js, \yii\web\View::POS_END);