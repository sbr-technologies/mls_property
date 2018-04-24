<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\StaticBlock;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use common\models\Banner;
use common\models\Property;
use common\models\Testimonial;
use common\models\User;
use common\models\StaticPage;
use common\models\Agency;
use yii\helpers\Inflector;
use common\models\BannerType;
use common\models\StaticBlockLocationMaster;
use common\models\News;


//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = "All Homes";

$blockLocation = 1;
$profileId = 5;
$bannerType     = BannerType::findByName('Home');
$staticPage     = StaticPage::findByName('Home');

$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();

$properties = Property::find()->active()->all();

$luxuryHomeArr  = Property::find()->where(['property_type_id' => 7])->active()->all();
$commercialHomeArr  =   Property::find()->where(['property_type_id' => 11])->active()->all();

$limitedPriceHomeArr  =   Property::find()->where(['<=','price', 45000])->active()->all();

$staticBlockTpe     = StaticBlockLocationMaster::findByTitle('All Home');
$newsAdvice     = StaticBlock::find()->where(['block_location_id' => $staticBlockTpe->id])->one();

$newsListAr     = News::find()->orderBy(['id' => SORT_DESC])->all();

//yii\helpers\VarDumper::dump($newsListAr,4,12); exit;
echo $this->render('//shared/_property_banner_search', ['type' => 'property']);
?>

<!-- Start Content Section ==================================================-->
<section>
    <!-- Buy Listing Sec -->
    <?php
    if (!empty($properties)) {
    ?>
    <div class="home-listing-sec property-buy-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Newest Listings <span>See all in London, KY</span></h2>
                    <div class="listing-item-sec">
                        <div class="row">
                            <div id="newest-listings-buy" class="owl-carousel owl-theme">
                                <?php
                                foreach ($properties as $key => $property) {
                                ?>
                                <div class="item">
                                    <a href="javascript:void(0)" class="listing-item-img">
                                        <?php
                                            $photosArr = $property->photos;
                                            if(is_array($photosArr) && count($photosArr) > 0){
                                                foreach($photosArr as $photoKey => $photoVal){
                                                    if($photoKey == 0){
                                                        if(isset($photoVal) && $photoVal != ''){
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
                                            <p class="listing-price">$<?php echo $property->price; ?> /
                                                    <span><?php echo $property->metricType->name; ?></span></p>
                                            <div class="btn btn-default info-btn">
                                                <a href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>">
                                                    <i class="fa fa-book" aria-hidden="true"></i> Info
                                                </a>
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
            </div>
        </div>
    </div>
    <!-- Buy Service Sec -->
    <?php } ?>

    <!-- News Advice Sec -->
    <div class="property-buy-home-sec">
        <div class="col-sm-6 property-buy-home-left">
            <div class="property-buy-home-listing-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Luxury Homes <span>See all in London, KY</span></h2>
                            <?php
                            if(!empty($luxuryHomeArr)){
                            ?>
                            <div class="listing-item-sec">
                                <div id="luxury-listings-buy" class="owl-carousel owl-theme">
                                    
                                    <?php
                                    foreach ($luxuryHomeArr as $key => $luxury) {
                                    ?>
                                        <div class="item">
                                            <a href="javascript:void(0)">
                                                <?php
                                                    $photosArr = $luxury->photos;
                                                    if(is_array($photosArr) && count($photosArr) > 0){
                                                        foreach($photosArr as $photoKey => $photoVal){
                                                            if($photoKey == 0){
                                                                if(isset($photoVal) && $photoVal != ''){
                                                                    $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                    echo Html::img($alias);
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                    }
                                                ?>
                                                
                                                <div class="listing-con">
                                                    <div class="heart-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                                                    <p class="listing-price">$<?php echo $luxury->price; ?> /
                                                    <span><?php echo $luxury->metricType->name; ?></span></p>
                                                    <div class="clearfix"></div>
                                                    <p class="listing-con-details"><?php echo $luxury->title; ?> <br><?= $luxury->no_of_room ?> beds  - <?= $luxury->no_of_bathroom ?> bath  - <?= $luxury->lot_size ?> sq ft </p>
                                                </div>
                                            </a>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 property-buy-home-right">
            <div class="property-buy-home-listing-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Commercial Homes <span>See all in London, KY</span></h2>
                            <?php
                            if(!empty($commercialHomeArr)){
                            ?>
                            <div class="listing-item-sec">
                                <div id="affordable-listings-buy" class="owl-carousel owl-theme">
                                    <?php
                                    foreach ($commercialHomeArr as $key => $commercial) {
                                    ?>
                                        <div class="item">
                                            <a href="javascript:void(0)">
                                                <?php
                                                    $photosArr = $luxury->photos;
                                                    if(is_array($photosArr) && count($photosArr) > 0){
                                                        foreach($photosArr as $photoKey => $photoVal){
                                                            if($photoKey == 0){
                                                                if(isset($photoVal) && $photoVal != ''){
                                                                    $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                    echo Html::img($alias);
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                                    }
                                                ?>
                                                
                                                <div class="listing-con">
                                                    <div class="heart-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                                                    <p class="listing-price">$<?php echo $commercial->price; ?> /
                                                    <span><?php echo $commercial->metricType->name; ?></span></p>
                                                    <div class="clearfix"></div>
                                                    <p class="listing-con-details"><?php echo $commercial->title; ?> <br><?= $commercial->no_of_room ?> beds  - <?= $commercial->no_of_bathroom ?> bath  - <?= $commercial->lot_size ?> sq ft </p>
                                                </div>
                                            </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- News Advice Sec -->
    
    <!-- Buy Listing Sec -->
    <?php
    if (!empty($limitedPriceHomeArr)) {
    ?>
    <div class="home-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Homes around $45,000 <span>See all in London, KY</span></h2>
                    <div class="listing-item-sec">
                        <div class="row">
                            <div id="home-listings-buy" class="owl-carousel owl-theme">
                                <?php
                                foreach ($limitedPriceHomeArr as $key => $limited) {
                                ?>
                                <div class="item">
                                    <a href="javascript:void(0)" class="listing-item-img">
                                        <?php
                                            $photosArr = $limited->photos;
                                            if(is_array($photosArr) && count($photosArr) > 0){
                                                foreach($photosArr as $photoKey => $photoVal){
                                                    if($photoKey == 0){
                                                        if(isset($photoVal) && $photoVal != ''){
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
                                        <p class="listing-con-details"><?php echo $limited->title; ?></p>
                                        <div class="clearfix"></div>
                                        <p class="listing-price">$<?php echo $limited->price; ?> /
                                                <span><?php echo $limited->metricType->name; ?></span></p>
                                        <div class="btn btn-default info-btn">
                                            <a href="<?php echo Url::to(['property/view', 'slug' => $limited->slug]) ?>">
                                                <i class="fa fa-book" aria-hidden="true"></i> Info
                                            </a>
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
            </div>
        </div>
    </div>
    <?php 
    }
    ?>
    
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
    <!-- News Advice Sec -->
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
    <!-- Neighborhood Sec -->
</section>
<!-- Start Content Section ==================================================-->