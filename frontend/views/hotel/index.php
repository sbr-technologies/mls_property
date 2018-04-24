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
use common\models\Banner;
use common\models\Hotel;
use common\models\User;
use yii\helpers\Inflector;
use common\models\BannerType;
use common\models\StaticBlockLocationMaster;

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title            = "Hotel";


$bannerType             = BannerType::findByName('Hotel');
$banners                = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();

$staticBlockLocation    = StaticBlockLocationMaster::findByTitle('Hotel');
$newsAdvice             = StaticBlock::find()->where(['block_location_id' => $staticBlockLocation->id, 'name' => 'NEWS & ADVICE TRENDS'])->one();

$hotels                 = Hotel::find()->active()->all();
//yii\helpers\VarDumper::dump($staticBlockLocation->id); 
echo $this->render('//shared/_property_banner_search', ['type' => 'hotel']);
?>
<!-- Start Slider Section ==================================================-->

<!-- End Slider Section ==================================================-->
<!-- Start Content Section ==================================================-->
<section>
    

    <!-- Home Listing Sec -->
    <div class="home-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if (!empty($hotels)) {
                    ?>
                    <h2><span>View all <?= count($hotels) ?> New Listings</span></h2>
                    <div class="listing-item-sec">
                        <div class="row">
                            <div id="owl-demo" class="owl-carousel owl-theme">
                                <?php
                                foreach ($hotels as $key => $hotel) {
                                ?>
                                    <div class="item">
                                        <a href="<?php echo Url::to(['hotel/view','slug' => $hotel->slug]) ?>" class="listing-item-img" >
                                            <?php
                                            $photosArr = $hotel->photos;
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
                                                <p class="listing-con-details"><?php echo $hotel->name; ?></p>
                                                <div class="clearfix"></div>
                                                <p class="listing-price">
                                                    <?php echo $hotel->price; ?> /
                                                    <span>per Person</span>
                                                </p>
                                                <div class="btn btn-default info-btn"><a href="<?php echo Url::to(['hotel/view','slug' => $hotel->slug]) ?>"><i class="fa fa-book" aria-hidden="true"></i> Info</a></div>
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

    

    
</section>
<!-- Start Content Section ==================================================-->

<?php
$js = "$(function(){
    
        $('.frm_home_page_search').on('submit', function(){
            var thisForm = $(this);
            if(thisForm.find('input[name=location]').val() == ''){
                return false;
            }

        });
    
    });";

$this->registerJs($js, View::POS_END);