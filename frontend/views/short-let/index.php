<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\StaticBlock;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use common\models\User;
use yii\helpers\Inflector;
use common\models\Rental;
use common\models\StaticBlockLocationMaster;
use common\models\News;
use common\models\BannerType;
use common\models\Banner;
use common\models\Property;
use common\models\RentalExtension;


$this->title = "All Short Let";

$bannerType     = BannerType::findByName('Short Let');
$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();

$shortRental    = Property::find()->where(['property_category_id' => 3])->all();

$staticBlockTpe         = StaticBlockLocationMaster::findByTitle('All Rental');
$newsAdvice             = StaticBlock::find()->where(['block_location_id' => $staticBlockTpe->id])->one();

$newsListAr     = News::find()->orderBy(['id' => SORT_DESC])->all();

echo $this->render('//shared/_property_banner_search', ['type' => 'short_let']);


?>


<section>
    <!-- Home Listing Sec -->
    <div class="home-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if (!empty($shortRental)) {
                        ?>
<!--                        <h2>Rentals with In-Unit Laundry </h2>-->
                        <div class="listing-item-sec">
                            <div class="row">
                                <div id="owl-demo" class="owl-carousel owl-theme">
                                    <?php
                                    foreach ($shortRental as $key => $property) {
                                        ?>
                                        <div class="item">
                                            <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>" class="listing-item-img" >
                                                <?php
                                                $photosArr = $property->photos;
                                                if (is_array($photosArr) && count($photosArr) > 0) {
                                                    foreach ($photosArr as $photoKey => $photoVal) {
                                                        if ($photoKey == 0) {
                                                            if (isset($photoVal) && $photoVal != '') {
                                                                $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                echo Html::img($alias);
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                }
                                                ?>
                                            </a>
                                            <div class="listing-con">
                                                <div class="heart-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                                                <p class="listing-con-details"><?php echo $property->title; ?></p>
                                                <div class="clearfix"></div>
                                                <p class="listing-price">
                                                    <?php echo $property->price; ?> /
                                                    <span><?php echo $property->metricType->name; ?></span>
                                                </p>
                                                <div class="btn btn-default info-btn"><a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>"><i class="fa fa-book" aria-hidden="true"></i> Info</a></div>
                                            </div>
                                            </a>
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
                </div>
            </div>
        </div>
    </div>
    <!-- Home Service Sec -->
    

    <!-- Home Listing Sec -->
    <div class="home-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if (!empty($studioProperty)) {

                        ?>
                        <h2>Studio Apartments</h2>
                        <div class="listing-item-sec">
                            <div class="row">
                                <div id="studio-rental" class="owl-carousel owl-theme">
                                    <?php
                                    foreach ($studioProperty as $poolKey => $poolVal) {
                                        //\yii\helpers\VarDumper::dump($poolVal->title); exit;
                                        ?>
                                        <div class="item">
                                            <a href="<?php echo Url::to(['property/view', 'slug' => $poolVal->slug]) ?>" class="listing-item-img" >
                                                <?php
                                                $photosArr = $poolVal->photos;
                                                if (is_array($photosArr) && count($photosArr) > 0) {
                                                    foreach ($photosArr as $photoKey => $photoVal) {
                                                        if ($photoKey == 0) {
                                                            if (isset($photoVal) && $photoVal != '') {
                                                                $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                echo Html::img($alias);
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                }
                                                ?>
                                            </a>
                                            <div class="listing-con">
                                                <div class="heart-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                                                <p class="listing-con-details"><?php echo $poolVal->title; ?></p>
                                                <div class="clearfix"></div>
                                                <p class="listing-price">
                                                    <?php echo $poolVal->price; ?> /
                                                    <span><?php echo $poolVal->metricType->name; ?></span>
                                                </p>
                                                <div class="btn btn-default info-btn"><a href="<?php echo Url::to(['property/view', 'slug' => $poolVal->slug]) ?>"><i class="fa fa-book" aria-hidden="true"></i> Info</a></div>
                                            </div>
                                            </a>
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
                </div>
            </div>
        </div>
    </div>
    <!-- Home Service Sec -->

    <!-- News Advice Sec -->
        <?php 
        if(!empty($newsAdvice)){ ?>
            <div class="news-advice-sec" style="background:rgba(0, 0, 0, 0) url('<?= $newsAdvice->photo->imageUrl ?>') no-repeat fixed 0 0 / cover">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2><?= $newsAdvice->title ?></h2>
                            <p><?= $newsAdvice->content ?></p>
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- News Advice Sec -->
        <!-- News Advice Sec -->
        <?php
        if(!empty($newsListAr)){
        ?>
        <div class="news-feed-sec">
            <div class="container">
                <div class="row">
                    <div id="news-feed-list" class="owl-carousel owl-theme news-feed-list-sec">
                        <?php
                        foreach($newsListAr as $news){
                        ?>
                        <div class="item" style="text-align:left;">
                            <h6 style="margin-left:10px;"><?= $news->newsCategory->name ?></h6>
                            <a href="javascript:void(0)" class="news-feed-listing" style="background:url('<?= $news->photo->imageUrl ?>') no-repeat;">
                                <div class="news-feed-list-con">
                                    <h2><?= $news->title ?></h2>
                                    <p><?= $news->getReadMore($news->content); ?></p>
                                </div>
                            </a>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <!-- Neighborhood Sec -->
        <div class="neighborhood-sec property-buy-neighborhood">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <h2>Find Your Neighborhood</h2>
                        <p>Does it have pet-friendly rentals? What are the crime rates? How are the schools? Get important local information on the area you’re most interested in.</p>
                        <form name="" action="" method="post" class="row">
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="" placeholder="Address, City, State or Neighborhood">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-default">Search Local</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
