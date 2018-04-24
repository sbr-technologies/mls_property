<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;
use kartik\rating\StarRating;

//use common\models\Hotel;
$this->title = $model->formattedAddress;
//$modelList = Hotel::find()->orderBy(['id' => SORT_ASC])->active()->all();
//$location = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$model->lat},{$model->lng}&radius=5000&key=". Yii::$app->params['googlePhotoKey']);
//\yii\helpers\VarDumper::dump($model,4,12); exit;
$hotelMapJson = '';
//$hotelInfo = ['lat' => $model->lat, 'lng' => $model->lng];
$hotelMapJson = json_encode(['title' => $model->formattedAddress, 'description' => $model->description, 'lat' => $model->lat, 'lng' => $model->lng]);
//\yii\helpers\VarDumper::dump($hotelMapJson,12,1); exit;
$this->registerJsFile(
    '@web/public_main/js/hotel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<!-- Start Content Section ==================================================-->
<section>
    <!-- Hotel Details top sec -->
    <div class="hotel-details-top-sec">
        <div class="col-sm-6 hotel-details-top-left">
            <?php
            $photos                 =   $model->photos; 
//            \yii\helpers\VarDumper::dump($photos,12,1); exit;
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
                        <div class="<?= $active ?> item slider" data-slide-number="<?= $key ?>">
                        <?php
                            if(isset($photo) && $photo != ''){
                                $alias = $photo->getImageUrl($photo::LARGE);
                                echo Html::img($alias,['height' => '350px']);
                            }else{
                                Html::img(Yii::getAlias('@backend/web/images/banner_image/no-preview.jpg'));
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
                    <a class="left carousel-control" href="#slider" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>
                    <a class="right carousel-control" href="#slider" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span></a>
                <?php 
                }
                ?>
            </div>

            <ul class="slider-thumb">
                <?php
                foreach ($photos as $key => $photo) {
                    if($key == 0){
                        $selected     =   'selected';
                    }else{
                        $selected     =   '';
                    }
                    ?>
                <li>
                    <a id="carousel-selector-<?= $key ?>" class="<?= $selected ?>">
                        <?php
                            if(isset($photo) && $photo != ''){
                                $alias = $photo->getImageUrl($photo::LARGE);
                                echo Html::img($alias,['class' => 'img-responsive']);
                            }
                        ?>
                    </a>
                </li>
                <?php
                }
                ?>
            </ul>
            <?php 
            }else{
                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['height' => '350px','width' => '100%','class' => 'galleryimg']);
            }
            ?>
        </div>

        <div class="col-sm-6 hotel-details-top-right">
            <h2><?= $model->name ?></h2>
            <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?= ucwords($model->formattedAddress ? $model->formattedAddress : "") ?> </p>
            <p class="rating-hotel-details">
                
                <?php
                echo '<label class="control-label">Rating : </label>';
                echo    StarRating::widget([
                            'name'                  => 'Hotel Rating',
                            'value'                 => $model->avg_rating,
                            'pluginOptions'         => [
                                                        'displayOnly'           => true,
                                                        'starCaptions'          => [
                                                                                    0 => 'Extremely Poor',
                                                                                    1 => 'Very Poor',
                                                                                    2 => 'Poor',
                                                                                    3 => 'Good',
                                                                                    4 => 'Very Good',
                                                                                    5 => 'Extremely Good',
                                                                                ],
                                                        'starCaptionClasses'    => [
                                                                                    0 => 'text-danger',
                                                                                    1 => 'text-danger',
                                                                                    2 => 'text-warning',
                                                                                    3 => 'text-info',
                                                                                    4 => 'text-primary',
                                                                                    5 => 'text-success',
                                                                                ],
                                                    ]
                        ]);
                ?>
            </p>
            <p class="price-hotel-details">Price: <span> <?= Yii::$app->formatter->asCurrency($model->price)?></span> <br>
            <?php
                if(!empty($model->days_no) && !empty($model->night_no)){
            ?>
                <?= $model->days_no ? $model->days_no." Day": "" ?> and <?= $model->night_no ? $model->night_no." Night": "" ?>  Per Room
            <?php 
            }elseif (!empty($model->days_no)) {
            ?> 
                <?= $model->days_no ? $model->days_no." Day": "" ?>  Per Room
            <?php
            }elseif (!empty($model->night_no)){
            ?>
                <?= $model->night_no ? $model->night_no." Night": "" ?>  Per Room
            <?php
            }
            ?>
            </p>
            <a href="javascript:void(0)" class="btn btn-default btn-lg red-btn">Select Room</a>
        </div>
        <div class="col-sm-12">
            <div id="hotel_info_map_canvas" style="height:250px;"></div>
        </div>
    </div>
    <!-- Hotel Details top sec -->

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="hotel-tab-listing-sec">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#hotel-overview" aria-controls="hotel-overview" role="tab" data-toggle="tab">Hotel Overview</a></li>
                            <li role="presentation"><a href="#hotel-room" aria-controls="hotel-room" role="tab" data-toggle="tab">Select Your Rooms</a></li>
                            <li role="presentation"><a href="#facilities" aria-controls="facilities" role="tab" data-toggle="tab">Facilities</a></li>
                            <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="hotel-overview">
                                <div class="hotel-overview-tab">
                                    <?= $model->description ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="hotel-room">
                                <div class="hotel-room-sec">
                                    <h2>Standard Double / Twin</h2>
                                    <div class="hotel-room-listing">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div id="roomslider" class="carousel slide" data-ride="carousel">
                                                    <div class="carousel-inner" role="listbox">
                                                        <div class="active item roomslider" data-slide-number="0">
                                                            <img src="images/home1.jpg" class="img-responsive">
                                                        </div>
                                                        <div class="item roomslider" data-slide-number="1">
                                                            <img src="images/home2.jpg" class="img-responsive">
                                                        </div>
                                                        <div class="item roomslider" data-slide-number="2">
                                                            <img src="images/home3.jpg" class="img-responsive">
                                                        </div>
                                                        <div class="item roomslider" data-slide-number="3">
                                                            <img src="images/home4.jpg" class="img-responsive">
                                                        </div>
                                                    </div>
                                                    <a class="left carousel-control" href="#roomslider" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>
                                                    <a class="right carousel-control" href="#roomslider" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span></a>
                                                </div>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="hotel-room-con">
                                                    <div class="col-sm-6">
                                                        <h3>Room Only</h3>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proinm feugiat sapien ut diam pellentesque porta. Aliquam erat volums tpat. Nullam bibendum tempor metus nec consequat. Nullam pellentesque sem vel lacus rhoncus varius. <a href="javascript:void(0)">More</a></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h4>Additional Deals</h4>
                                                        <p>Book for 2 nights or more & Get 5% Discount</p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <h5>$4,500</h5>
                                                        <p><span>Per Room / Night</span></p>
                                                        <a href="javascript:void(0)" class="btn btn-default red-btn">Book Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="facilities">
                                <?php
                                $hotelFacilityArr   =   $model->hotelFacilities;
                                ?>
                                <div class="hotel-facilities-tab">
                                    <h2>Hotel Facilities</h2>
                                    <?php
                                    if(!empty($hotelFacilityArr)){
                                    ?>
                                    <ul>
                                        <?php 
                                        foreach($hotelFacilityArr as $facility){
                                        ?>
                                        <li><?= $facility->title ?></li>
                                        <?php 
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                    }else{
                                    ?>
                                    <div class="alert alert-info margine10top" style="margin:10px;">
                                        <i class="fa fa-info"></i>					
                                        No data found.
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <h2>Room Facilities</h2>
                                     <?php
                                    $roomFacilityArr   =   $model->roomFacilities;
                                    if(!empty($roomFacilityArr)){
                                        foreach($roomFacilityArr as $room){
                                    ?>
                                    <p><span><?= $room->title ?></span> <?= $room->description ?></p>
                                    <?php
                                        }
                                    }else{
                                    ?>
                                    <div class="alert alert-info margine10top" style="margin:10px;">
                                        <i class="fa fa-info"></i>					
                                        No data found.
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="reviews">
                                <div class="hotel-review-listing">
                                    <div class="row">
                                        <div class="col-sm-2 review-listing-left">
                                            <div class="review-listing-left-img"><img src="images/review-no-img.png" alt=""></div>
                                            <p>Robert Gomes <span>Sat, Jan 28, 2017</span></p>
                                        </div>
                                        <div class="col-sm-10 review-listing-right">
                                            <h3>Hotel is currently under construction</h3>
                                            <h4><span>3.5</span> Couple traveler</h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin feugiat sapien ut diam pellentesque porta. Aliquam erat volutpat. Nullam bibendum tempor metus nec consequat. Nullam pellentesque sem vel lacus rhoncus varius. Morbi lobortis sit amet libero eget facilisis. Quisque molestie risus eget metus consectetur, eget pharetra neque viverra. Nam vel nisi faucibus, vestibulum ante et, tempor ante. In eu erat eleifend, dictum enim a, facilisis dui. Suspendisse lacinia, erat bibendum rutrum dapibus, turpis lectus condimentum mauris, lobortis varius diam quam sit amet nisl. Donec eget tellus nibh.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->
<?php
$js =   "$(function(){
            ".(!empty($hotelMapJson)?"initializeHotelInfo(".$hotelMapJson.");":'')."
        });";

$this->registerJs($js, View::POS_END);

?>