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

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);



$blockLocation = 1;
$profileId = 5;
$blockLocation = StaticBlockLocationMaster::findByTitle('Home Page');
$bannerType     = BannerType::findByName('Home');
$staticPage     = StaticPage::findByName('Home');

$searchOptionBuy   = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Buy'])->active()->one();
$searchOptionRent   = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Rent'])->active()->one();
$searchOptionHotel   = StaticBlock::find()->where(['block_location_id' => $blockLocation->id, 'name' => 'Search Hotel & BNB'])->active()->one();

$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();

$staticPages = StaticBlock::findByTitle('Home');

$properties = Property::find()->active()->all();

$testimonials = Testimonial::find()->all();

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
?>
<!-- Start Slider Section ==================================================-->
<!--<figure class="bannerwithsearch">
     Home Slider 
    <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php
            if (!empty($banners)) {
                foreach ($banners as $key => $banner) {
                    $bannerUrl      =   '';
                    $photo = $banner->photo;
                    $alias = $photo->getImageUrl();
                    //echo Html::img($alias);
                    if($banner->property_id != ''){
                        $bProp = Property::findOne($banner->property_id);
                        if(!empty($bProp)){
                            $bannerUrl = Url::to(['property/view', 'slug' => $bProp->slug]);
                        }
                    }
                    ?>
                    <div class="item slider <?php echo $key == 0 ? 'active' : ''; ?>" style="background-image:url(<?php echo $photo->getImageUrl() ?>);">
                        <a href="<?= $bannerUrl ?>">
                            <div class="slidercontent">
                                <div class="container">
                                    <div class="figuretext"><?php echo $banner->title; ?></div>
                                    <div class="figuretextbottom"><?php echo $banner->description; ?></div>
                                </div>
                            </div>
                        </a>
                    </div> 
                    <?php
                }
            } else {
                ?>
                <div class="item slider active" style="background-image:url(<?php echo Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg') ?>);">
                    <div class="slidercontent">
                        <div class="container">
                            <div class="figuretext"><?php //echo Yii::$app->language == "ar" ? (!empty($banner->title_ar) ? $banner->title_ar : $banner->title) : $banner->title; ?></div>
                            <div class="figuretextbottom"><?php //echo Yii::$app->language == "ar" ? (!empty($banner->description_ar) ? $banner->description_ar : $banner->description) : $banner->description; ?></div>
                        </div>
                    </div>
                </div>   
            <?php       
            }
            ?> 
            
        </div>
        <?php 
        if (!empty($banners) && count($banners) > 1) {
        ?>
            <a class="left carousel-control" href="#slider" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
            <a class="right carousel-control" href="#slider" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        <?php
        }
        ?>
        
    </div>
     Home Slider 

     Home Search Form 
    <div class="searchhome">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-push-1">
                    <div class="searchholder clearfix">
                        <div class="searchtopbar">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#buy" aria-controls="buy" role="tab" data-toggle="tab"><?= $searchOptionBuy->title ? $searchOptionBuy->title : "" ?></a></li>
                                <li role="presentation"><a href="#rent" aria-controls="rent" role="tab" data-toggle="tab"><?= $searchOptionRent->title ? $searchOptionRent->title : "" ?></a></li>
                                <li role="presentation"><a href="#sell" aria-controls="sell" role="tab" data-toggle="tab"><?= $searchOptionHotel->title ? $searchOptionHotel->title : "" ?></a></li>
                            </ul>

                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="buy">
                                    <div class="row">
                                        <div class="searchbox clearfix form-group-md">
                                            <?php echo $this->render('//shared/_location_suggestion');?>
                                            <div class="button_holder">
                                              <?= Html::beginForm(['realestate/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search','id' => 'buy_property_form']) ?>
                                              <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location'])?>
                                                <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_realestate']) ?>
                                              <?= Html::endForm() ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="rent">
                                <div class="row">
                                    <div class="searchbox clearfix form-group-md">
                                        <?php echo $this->render('//shared/_location_suggestion');?>
                                        <div class="button_holder">
                                          <?= Html::beginForm(['rental/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search','id' => 'buy_property_form']) ?>
                                          <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location'])?>
                                            <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_realestate']) ?>
                                          <?= Html::endForm() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="sell">
                                <div class="row">
                                    <div class="searchbox clearfix form-group-md">
                                        <?php echo $this->render('//shared/_location_suggestion');?>
                                        <div class="button_holder">
                                          <?= Html::beginForm(['realestate/search'], 'get', ['class' => 'frm_geocomplete frm_home_page_search','id' => 'buy_property_form']) ?>
                                          <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location'])?>
                                            <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_realestate']) ?>
                                          <?= Html::endForm() ?>
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
     Home Search Form 
</figure>-->
<?php echo $this->render('//shared/_property_banner_search', ['type' => 'property']);?>
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
                                                            echo Html::img($alias);
                                                        }
                                                    }
                                                }
                                            }else{
                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'property-listing-img']);
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
                            foreach($agents as $key => $agent){
                        ?>
                        <div class="col-sm-3">
                            <div class="featured-agent-list">
                                <?php
                                    $userImage = $agent->getImageUrl(User::THUMBNAIL);
                                    echo Html::img($userImage,['height' => '176px', 'width'=>'176']);
                                ?>
                              <h3><?php echo Html::a($agent->fullName, ['user/view-profile', 'slug' => $agent->slug]) ?></h3>
                                <div class="featured-agent-social">
                                    <a href="javascript:void(0)" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0)" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0)" class="pinterest"><i class="fa fa-pinterest-p"></i></a>
                                    <a href="javascript:void(0)" class="google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
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
                        <form name="" method="post" action="" class="row">
                        <div class="col-sm-9 pleft pright"><input type="text" placeholder="Address, City, State or Neighborhood" name="" class="form-control"></div>
                        <div class="col-sm-3 pleft"><button type="submit" class="btn btn-default">Search Local</button></div>
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