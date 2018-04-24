<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile(
    '@web/public_main/js/holiday-package-details.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = "Holiday Package Details";
?>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<!-- Start Content Section ==================================================-->
<section>
    <!-- Hotel Details top sec -->
    <div class="hotel-details-top-sec">
        <div class="col-sm-6 hotel-details-top-left">
            <div id="slider" class="carousel slide" data-ride="carousel">
                <?php
                $photos                 =   $model->photos; 
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
                }
                ?>
            </div>
        </div>

        <div class="col-sm-6 hotel-details-top-right">
            <h2><?= $model->name ?></h2>
            <!--<p><?= $model->source_city ? $model->source_city : "" ?> (3N) &nbsp;|&nbsp; <?= $model->destination_city ? $model->destination_city : "" ?> (1N) </p>-->
            <p class="price-hotel-details">Price: <span><?= Yii::$app->formatter->asCurrency($model->package_amount) ?> </span></p>
            <p><a href="<?= Url::to(['holiday-package/package-booking', 'id' => $model->id])?>" class="btn btn-default red-btn package-book-online-btn">Book Now</a> </p>                
            </div>
        </div>
        <div class="col-sm-12">
            <div id="holiday_package_details_map_canvas" style="height:250px;"></div>
        </div>
    </div>
    <!-- Hotel Details top sec -->

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="hotel-tab-listing-sec">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#package-itinerary" aria-controls="package-itinerary" role="tab" data-toggle="tab">Package Itinerary</a></li>
                            <li role="presentation"><a href="#terms-conditions" aria-controls="terms-conditions" role="tab" data-toggle="tab">Terms & Conditions</a></li>
                            <li role="presentation"><a href="#cancellation-policy" aria-controls="cancellation-policy" role="tab" data-toggle="tab">Cancellation Policy</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="package-itinerary">
                                <div class="package-tab">
                                    <?php 
                                    $packageItineraries     =   $model->holidayPackageItineraries;
                                   // yii\helpers\VarDumper::dump($packageItineraries); exit;
                                    if(!empty($packageItineraries)){
                                        foreach($packageItineraries as $itinerary){
                                    ?>
                                        <div class="package-listing">
                                            <h2><span><?= $itinerary->days_name ?></span> <?= $itinerary->title ?>  Arrival in <?= $itinerary->city ?></h2>
                                            <?php
                                            $photos                 =   $itinerary->photos; 
                                            if(!empty($photos[0])){
                                                $alias = $photo->getImageUrl($photo::THUMBNAIL);
                                                echo Html::img($alias);
                                            }else{
                                                Html::img(Yii::getAlias('@backend/web/images/banner_image/no-preview.jpg'));
                                            }
                                            ?>
                                            <p><?= $itinerary->description ?></p>
                                        </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="terms-conditions">
                                <div class="hotel-facilities-tab">
                                    <h3>Inclusion</h3>
                                    <p class="policy-list-bottomTxt"> <?= $model->inclusion ? $model->inclusion : "" ?> </p>
                                    <h3>Exclusions</h3>
                                    <p class="policy-list-bottomTxt"> <?= $model->exclusions ? $model->exclusions : "" ?> </p>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="cancellation-policy">
                                <div class="cancellation-policy-inner">
                                    <div class="policy-list">
                                        <p class="policy-list-topTxt">Payment policy</p>
                                        <p class="policy-list-bottomTxt"><?= $model->payment_policy ? $model->payment_policy : "" ?></p>
                                        
                                        <p class="policy-list-topTxt">Cancellation policy</p>
                                        <p class="policy-list-bottomTxt"><?= $model->cancellation_policy ? $model->cancellation_policy : "" ?></p>
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
$markers = ['name' => $model->name, 'description' => $model->description, 'source_lat' => $model->source_lat,'source_lng' => $model->source_lng,'destination_lat' => $model->destination_lat,'destination_lng' => $model->destination_lng];
$js = "$(function(){
        holidayMapInitialize(". json_encode($markers).");
    });";
$this->registerJs($js, View::POS_END);