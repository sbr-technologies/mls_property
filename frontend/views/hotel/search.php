<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Hotel;
use yii\widgets\LinkPager;

$this->title = $location. ' Hotel for - '. Yii::$app->name;
$hotelList = $dataProvider->getModels();
?>
<section>
    <!-- Property Menu Bar -->
    <?= $this->render('//shared/_hotel_search_filtter.php', ['hotelName' => $hotelName, 'locationId' => $locationId, 'location' => $location,
        'rating' => $rating, 'facilities' => $facilities])?>
    <!-- Property Menu Bar -->

    <div class="inner-content-sec">
        <div class="container hotel_search_result_container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="hotel-listing-top">
                        <h2>Hotels In <?= $location ?></h2>
                        <div class="hotel-listing-select pull-right">
                            <select class="pull-right sort_hotel_by property-listing-select">
                              <option value="<?= Hotel::SORT_RELEVANT ?>" <?php if($sortBy == Hotel::SORT_RELEVANT)echo 'selected'?>>Relevant</option>
                                <option value="<?= Hotel::SORT_RATINGS ?>" <?php if($sortBy == Hotel::SORT_RATINGS)echo 'selected'?>>Highest Ratings</option>
                                <option value="<?= Hotel::SORT_POPULARITY ?>" <?php if($sortBy == Hotel::SORT_POPULARITY)echo 'selected'?>>Popularity</option>
                                <option value="<?= Hotel::SORT_RECENT_VIEWED ?>" <?php if($sortBy == Hotel::SORT_RECENT_VIEWED)echo 'selected'?>>Recently Viewed</option>
                            </select>
                        </div>
                    </div>
                    <?php
                        if(!empty($hotelList)){
                    ?>
                    <div class="row">
                        <?php
                        foreach($hotelList as $hotel){
                        ?>
                        <div class="col-sm-6">
                            <div class="hotel-listing">
                                <a href="<?php echo Url::to(['hotel/view','slug' => $hotel->slug]) ?>">
                                    <?php 
                                    $photo                =   $hotel->photos; 
                                    //\yii\helpers\VarDumper::dump($photo[0],4,12); exit;
                                        if(!empty($photo)){
                                            $alias = $photo[0]->getImageUrl($photo[0]::LARGE);
                                            echo Html::img($alias,['height' => '350px']);
                                        }
                                    ?>
                                    
                                    <span class="property-total-img"><i class="fa fa-picture-o" aria-hidden="true"></i> <?= count($photo) ?></span>
                                    <span class="hotel-listing-mark">4.2<span class="hotel-listing-mark-top-smTxt">/5</span> <span class="hotel-listing-mark-bottom">Very Good</span></span>
                                    <div class="hotel-listing-con">
                                        <div class="col-sm-6">
                                            <h4><?= $hotel->name ?></h4>
                                            <p><?= $hotel->city.", ".$hotel->state.", ".$hotel->country ?></p>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                          <h3><?= Yii::$app->formatter->asCurrency($hotel->price) ?></h3>
                                            <p>
                                                <?php
                                                    if(!empty($hotel->days_no) && !empty($hotel->night_no)){
                                                ?>
                                                    <?= $hotel->days_no ? $hotel->days_no." Day": "" ?> and <?= $hotel->night_no ? $hotel->night_no." Night": "" ?>  Per Room
                                                <?php 
                                                }elseif (!empty($hotel->days_no)) {
                                                ?> 
                                                    <?= $hotel->days_no ? $hotel->days_no." Day": "" ?>  Per Room
                                                <?php
                                                }elseif (!empty($hotel->night_no)){
                                                ?>
                                                    <?= $hotel->night_no ? $hotel->night_no." Night": "" ?>  Per Room
                                                <?php
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>
                        <div class="col-sm-12">
                            <div class="property-listing-bottom-sec">
                                <p class="pull-left">Found <?= count($hotelList) ?> Matching Hotel(s)</p>
                                <div class="pagination-sec">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>