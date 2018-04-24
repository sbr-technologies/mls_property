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
use common\models\ConstructionStatusMaster;
use common\models\StaticBlockLocationMaster;
use common\models\News;


//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = "New Homes";

$blockLocation = 1;
$profileId = 5;
$constructionType   = ConstructionStatusMaster::findByTitle('New Development');
$staticPage     = StaticPage::findByName('Home');
$NewConstProperties = Property::find()->where(['construction_status_id' => $constructionType->id])->active()->all();
//\yii\helpers\VarDumper::dump($NewConstProperties,4,12); exit;
$luxuryHomeArr  = Property::find()->where(['property_type_id' => 7])->active()->all();
$commercialHomeArr  =   Property::find()->where(['property_type_id' => 11])->active()->all();

$limitedPriceHomeArr  =   Property::find()->where(['<=','price', 45000])->active()->all();
//yii\helpers\VarDumper::dump($limitedPriceHomeArr,4,12); exit;

$staticBlockTpe     = StaticBlockLocationMaster::findByTitle('New Homes');
$newsAdvice     = StaticBlock::find()->where(['block_location_id' => $staticBlockTpe->id])->one();


$newsListAr     = News::find()->orderBy(['id' => SORT_DESC])->all();
    echo $this->render('//shared/_property_banner_search', ['type' => 'property']);
    
?>
<section>
    <!-- Buy Listing Sec -->
    <?php
    if (!empty($NewConstProperties)) {
    ?>
    <div class="home-listing-sec property-buy-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>New Construction <span>See all in London, KY</span></h2>
                    <div class="listing-item-sec">
                        <div class="row">
                            <div id="newest-listings-buy" class="owl-carousel owl-theme">
                                <?php
                                foreach ($NewConstProperties as $key => $property) {
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
</section>
