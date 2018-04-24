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
use common\models\Property;
use common\models\Testimonial;
use common\models\User;
use common\models\StaticPage;
use common\models\Agency;
use yii\helpers\Inflector;
use common\models\BannerType;
use common\models\StaticBlockLocationMaster;
use frontend\helpers\PropertyHelper;

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);



//\yii\helpers\VarDumper::dump($blockLocation); exit;
$profileId = 5;
$bannerType     = BannerType::findByName('Home');
$staticPage     = StaticPage::findByName('Home');

$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();

$staticPages = StaticBlock::findByTitle('Home');

$properties = Property::find()->active()->all();
PropertyHelper::filterListing($properties);
$testimonials = Testimonial::find()->active()->all();

$agents = User::find()->where(['profile_id' => $profileId])->limit(4)->all();

$agencyCnt = Agency::find()->count();

$customerCnt = User::find()->where(['not in','profile_id',[USER::PROFILE_SUPERADMIN,USER::PROFILE_ADMIN]])->count();

$saleHomeCnt  = Property::find()->where(['property_category_id' => 2])->count();
//yii\helpers\VarDumper::dump($banners,12,4);exit;
$this->title = $staticPage->pageTitle;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $staticPage->meta_description
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $staticPage->meta_keywords
]);

$statArea = StaticBlock::findByTitle('Stat Area');

$handlers = new HandlerContainer();
$handlers->add('FEATURE_IMAGE', function(ShortcodeInterface $s) {
    $name = $s->getParameter('name');
//    echo $name; die();
    $statArea = StaticBlock::findByTitle(Inflector::camel2words($name));
    if(isset($statArea->photo)){
        return $statArea->photo->imageUrl;
    }
    
});
$processor      = new Processor(new RegularParser(), $handlers);
$newsUpdate     =   StaticBlock::findByTitle('News And Update');
$localSearch    =   StaticBlock::findByTitle('Local Search');

//\yii\helpers\VarDumper::dump($properties); exit;
echo $this->render('//shared/_property_banner_search', ['type' => 'property']);
?>
<!-- Start Slider Section ==================================================-->

<!-- End Slider Section ==================================================-->
<!-- Start Content Section ==================================================-->
<section>
    <!-- Home Service Sec -->
    <div class="home-service-sec">
        <?php
        if (!empty($staticPages)) {
            echo $staticPages->content;
        }
        ?>
    </div>
    <!-- Home Service Sec -->

    <!-- Home Listing Sec -->
    <div class="home-listing-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if (!empty($properties)) {
                    ?>
                    <h2>LOS ANGLES <span>View all <?= count($properties) ?> New Listings</span></h2>
                    <div class="listing-item-sec">
                        <div class="row">
                            <div id="owl-demo" class="owl-carousel owl-theme">
                                <?php
                                foreach ($properties as $key => $property) {
                                ?>
                                    <div class="item">
                                        <a href="javascript:void(0)" class="listing-item-img" >
                                            <?php
                                            $photosArr = $property->photos;
                                            if(is_array($photosArr) && count($photosArr) > 0){
                                                foreach($photosArr as $photoKey => $photoVal){
                                                    if($photoKey == 0){
                                                        if(isset($photoVal) && $photoVal != ''){
                                                            $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                            echo Html::img($alias,['alt' => $property->formattedAddress]);
                                                        }
                                                    }
                                                }
                                            }else{
                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['alt' => $property->formattedAddress]);
                                            }
                                            ?>
                                        </a>
                                            <div class="listing-con">
                                                <!--<div class="heart-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>-->
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
                    <div class="listing-counter-sec">
                        <div class="col-sm-3 counter-listing">
                            <div class="count counter-no"><?php echo $saleHomeCnt ?></div>
                            <div class="counter-name">Homes For Sale</div>
                        </div>

                        <div class="col-sm-3 counter-listing">
                            <div class="count counter-no">11</div>
                            <div class="counter-name">Open Houses</div>
                        </div>

                        <div class="col-sm-3 counter-listing">
                            <div class="count counter-no">3537</div>
                            <div class="counter-name">Recently Sold</div>
                        </div>

                        <div class="col-sm-3 counter-listing">
                            <div class="count counter-no">218</div>
                            <div class="counter-name">Price Reduced</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home Service Sec -->

    <!-- News Advice Sec -->
    <?php if(!empty($newsUpdate)){
        echo $processor->process($newsUpdate->content);
      }
    ?>
    <!-- News Advice Sec -->

    <!-- Featured Agent Sec -->
    <div class="featured-agent-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Featured Agent <span>Quam pretium lobortim sit amet ipsum</span></h2>
                    <div class="col-sm-11 featured-agent-listing">
                        <?php
                        if(!empty($agents)){
                            $link = [];
                            foreach($agents as $key => $agent){
                                if(!empty($agent->agentSocialMedias)){
                                    foreach($agent->agentSocialMedias as $social){
                                        $link[$social->name] = $social->url;
                                    }
                                }
                        ?>
                        <div class="col-sm-3">
                            <div class="featured-agent-list">
                                <?php
                                    $userImage = $agent->getImageUrl(User::THUMBNAIL);
                                    echo Html::img($userImage,['height' => '176px', 'width'=>'176']);
                                ?>
                              <h3><?php echo Html::a($agent->fullName, ['user/view-profile', 'slug' => $agent->slug]) ?></h3>
                                <div class="featured-agent-social">
                                    <a href="<?php if(isset($link['facebook']) && $link['facebook']) echo 'http://'. $link['facebook']; else echo '#'?>" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="<?php if(isset($link['twitter']) && $link['twitter']) echo 'http://'. $link['twitter']; else echo '#'?>" class="twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="<?php if(isset($link['linkedin']) && $link['linkedin']) echo 'http://'. $link['linkedin']; else echo '#'?>" class="pinterest" target="_blank"><i class="fa fa-linkedin"></i></a>
                                    <a href="<?php if(isset($link['google']) && $link['google']) echo 'http://'. $link['google']; else echo '#'?>" class="google-plus" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                </div>
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
    </div>
    <!-- Featured Agent Sec -->

    <!-- Testimonial Sec -->
    <?php
        if(!empty($testimonials)){
    ?>
        <div class="testimonial-sec">
            <div class="container">
                <div class="col-sm-12 testimonial-inner">
                    <div id="home-testimonial" class="carousel slide" data-ride="carousel"> 
                        <div class="carousel-inner" role="listbox">
                            <?php
                                foreach($testimonials as $key => $testmonialVal){
                            ?>
                                    <div class="item <?php echo $key == 0 ? 'active' : ''; ?>">
                                        <div class="carousel-content">
                                            <?php
                                                $userImage = $testmonialVal->user->ImageUrl;
                                                echo Html::img($userImage,['height' => '110px', 'width'=>'180']);
                                            ?>

                                            <h2><?php echo $testmonialVal->user->fullName ?></h2>
                                            <p>“ <?php echo $testmonialVal->description ?>”</p>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                        <ol class="carousel-indicators">
                            <?php
                                $count = count($testimonials);
                                //echo $count;
                                for($i = 1; $i <= $count; $i++){
                            ?>
                                <li data-target="#home-testimonial" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                            <?php
                                }

                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <?php 
    
        }
    ?>
    <!-- Testimonial Sec -->

    <!-- Neighborhood Sec -->
    <?php if(!empty($localSearch)){ ?>
        <div class="neighborhood-sec" style="background:rgba(0, 0, 0, 0) url('<?= $localSearch->photo->imageUrl ?>') no-repeat fixed 0 0 / cover">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <?php echo $processor->process($localSearch->content) ?>
                      <form action="<?= Url::to(['realestate/search'])?>" class="row" onsubmit="return false">
                          <input type="hidden" name="location" class="realestate_search_location" />
                        <div class="col-sm-9 pleft pright">
                        <?= $this->render('//shared/_location_suggestion.php')?>
                        </div>
                        <div class="col-sm-3 pleft"><button type="submit" class="btn btn-default btn_search_realestate">Search Local</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    
    <!-- Neighborhood Sec -->

    <!-- Counter Sec -->
    <?php if(!empty($statArea)){
            echo $processor->process($statArea->content);
    }?>
    <!-- Counter Sec -->

    
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