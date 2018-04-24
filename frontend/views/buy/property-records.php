<?php 
use yii\helpers\Url;
$this->title = "Property Records";
?>
<section class="property-records-section">
  <section class="content-header">
    <h1>Property Records</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
            <?php if($type == 'all'){
                echo '<li class="active">Properties by state</li>';
            }elseif($type == 'state'){
                echo '<li><a href="'.Url::to(['buy/property-records']).'">Properties by state</a></li>';
                echo '<li class="active">'.$stateName.'</li>';
            }elseif($type == 'city'){
                echo '<li><a href="'.Url::to(['buy/property-records']).'">Properties by state</a></li>';
                echo '<li><a href="'.Url::to(['buy/property-records', 'state' => $stateCode]).'">'.$stateName.'</a></li>';
                echo '<li>'.$cityName.'</li>';
            }elseif($type == 'zip'){
                echo '<li><a href="'.Url::to(['buy/property-records']).'">Properties by state</a></li>';
                echo '<li><a href="'.Url::to(['buy/property-records', 'state' => $stateCode]).'">'.$stateName.'</a></li>';
                echo '<li><a href="'.Url::to(['buy/property-records', 'city' => $cityName]).'">'.$cityName.'</a></li>';
                echo '<li class="active">'.$zip.'</li>';
            }
            ?>
        </ol>
    </section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                  <ul class="property-record-location-list">
                    <?php $i = 1;
                    foreach ($list as $property){
                        if($type == 'all'){
                            echo '<li><a href="'.Url::to(['buy/property-records', 'state' => $property->state]).'">'. $property->state_long. '</a></li>';
                        }elseif($type == 'state'){
                            echo '<li><a href="'.Url::to(['buy/property-records', 'city' => $property->city]).'">'. $property->city. ' ('.$property->cnt.')</a></li>';
                        }elseif($type == 'city'){
                            echo '<li><a href="'.Url::to(['buy/property-records', 'zip' => $property->zip_code]).'">'. ($property->zip_code?$property->zip_code:'---'). ' ('.$property->cnt.')</a></li>';
                        }elseif($type == 'zip'){
                            echo '<li><a href="'.Url::to(['property/view', 'slug' => $property->slug]).'">'. $property->formattedAddress. '</a></li>';
                        }
                        if($i%20 == 0){
                            echo '</ul><ul class="property-record-location-list">';
                        }
                        
                        $i++;
                    }
                    ?>
                  </ul>
                </div>

                <!-- Property Details Right -->
                <div class="col-sm-3 property-details-right">
                    <!-- Property Details AD -->
                    <div class="property-details-right-ad">
                        <a href="javascript:void(0)"><img src="<?=Yii::getAlias('@web')?>/images/prpperty-details-ad.png" alt=""></a>
                    </div>
                    <!-- Property Details Similar Property -->
                    <div class="property-details-right-similar-property">
                        <h4>Recently Sold Homes</h4>
                        <div class="similar-property-listing-right">
                            <a href="javascript:void(0)" class="similar-property-listing">
                              <img src="<?=Yii::getAlias('@web')?>/images/similar-property-img1.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$123.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="<?=Yii::getAlias('@web')?>/images/similar-property-img2.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$133.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="<?=Yii::getAlias('@web')?>/images/similar-property-img3.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$153.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="similar-property-listing">
                                <img src="<?=Yii::getAlias('@web')?>/images/similar-property-img4.jpg" alt="">
                                <div class="similar-property-content">
                                    <p class="sold-priceTxt">$123.34</p>
                                    <p class="similar-property-content-txt">12/D S. N. Jhon Road, New York. 7684652</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Property Details Similar Property -->

                    <!-- Property Details AD -->
                    <div class="property-details-right-ad">
                        <a href="javascript:void(0)"><img src="<?=Yii::getAlias('@web')?>/images/prpperty-details-ad.png" alt=""></a>
                    </div>
                    <!-- Property Details AD -->
                </div>
                <!-- Property Details Right -->
            </div>
        </div>
    </div>
</section>