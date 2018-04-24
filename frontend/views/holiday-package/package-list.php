<?php

use yii\helpers\Html;
use common\models\HolidayPackage;
use yii\helpers\Url;



$this->title        = $city. ' Holiday Package List - '. Yii::$app->name;
$holidayPackages    = $dataProvider->getModels();
//echo "<pre>"; print_r($holidayPackages); echo "<pre>"; exit;
?>
<!-- Start Content Section ==================================================-->
<section>
    <!-- Property Menu Bar -->
    <div class="property-menu-bar hoter-top-bar holiday-package-top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="hotel-top-barTxt">From <span>India</span></p>
                        </div>

                        <div class="col-sm-6">
                            <p class="hotel-top-barTxt">To <span>London</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="hotel-top-barTxt">Check-In <span>29 th March, 2017</span></p>
                        </div>
                        <div class="col-sm-6">
                            <p class="hotel-top-barTxt">Check-Out <span>8 th April, 2017</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="hotel-top-barTxt text-center">Room <span>1</span></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="hotel-top-barTxt text-center">Adults <span>2</span></p>
                        </div>
                        <div class="col-sm-2">
                            <p class="hotel-top-barTxt text-center">Children <span>0</span></p>
                        </div>
                        <div class="col-sm-6">
                            <a href="javascript:void(0)" class="btn btn-primary red-btn pull-right">Modify Search</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="holiday-package-listing-top">
                        <ul>
                            <li>Sort By: <strong>Popular</strong></li>
                            <li>Price: <a href="javascript:void(0)">Low to High</a></li>
                            <li>Price: <a href="javascript:void(0)">High to Low</a></li>
                        </ul>
                        <a href="javascript:void(0)" class="btn btn-default red-btn pull-right booking-enquiry-btn" data-toggle="modal" data-target="#enquiryModal">Booking Enquiry</a>
                    </div>
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
                                        <span><strong>$<?= $package->package_amount ?></strong> per day</span>
                                    </p>
                                    <a href="<?= Url::to(['holiday-package/package-details', 'id' => $package->id])?>" class="btn btn-default red-btn pull-right package-view-details-btn">View Details</a>
                                    <a href="javascript:void(0)" class="btn btn-default red-btn pull-right package-book-online-btn">Book Online</a>
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
<!-- Start Content Section ==================================================-->