<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\BannerType;
use common\models\Banner;
use common\models\StaticBlockLocationMaster;
use common\models\StaticBlock;
use common\models\PropertyType;
use common\models\Property;


$this->title = "See What Your Home Is Worth";

$bannerType     = BannerType::findByName('Sell');
//yii\helpers\VarDumper::dump($bannerType->id); exit;
$banner = Banner::find()->where(['type_id' => $bannerType->id])->active()->one();

$staticBlockType     = StaticBlockLocationMaster::findByTitle('Sell');

$staticBlockArr = StaticBlock::find()->where(['block_location_id' => $staticBlockType->id])->limit(4)->active()->all();

//yii\helpers\VarDumper::dump($staticBlockArr,4,12); exit;
?>

<?php 
$this->registerCssFile(
    '@web/plugins/bootstrap-multiselect/bootstrap-multiselect.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);

$this->registerJsFile(
    '@web/plugins/bootstrap-multiselect/bootstrap-multiselect.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
?>

<!-- Start Slider Section ==================================================-->
<figure class="bannerwithsearch">
    <!-- Home Slider -->
    <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php
            if (!empty($banner)) {
                $photo = $banner->photo;
            ?>
            <div class="item slider active" style="background-image:url(<?php echo $photo->getImageUrl() ?>);">

            </div>
            <?php 
            }
            ?>
        </div>
    </div>
    <!-- Home Slider -->

    <!-- Home Search Form -->
    <div class="searchhome search-sell">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-push-1">
                    <div class="searchholder clearfix">
                        <div class="row">
                            <div class="searchbox sell-searchbox clearfix form-group-md">
                                <h3>How much is your home worth? Looking to sell?</h3>
                                <h4 class="text-center">Search the neighborhood by selecting only the location. And if you like, search for an address.</h4>
                                <div class="col-sm-9">
                                    <div class="row">
                                    <?php // echo $this->render('//shared/_complete_address_suggestion.php', [])?>
                                        <div class="col-sm-6"><?php echo $this->render('//shared/_location_suggestion'); ?></div>
                                        <div class="col-sm-6"><?php echo $this->render('//shared/_address_suggestion'); ?></div>
                                    </div>
                                </div>
                                <?= Html::beginForm(['sell/estimate'], 'get', ['class' => 'frm_realestate_sell_estimate', 'id' => 'buy_property_form']) ?>  
                                    <input type="hidden" class="realestate_search_location" />
                                    <input type="hidden" class="realestate_search_address" />
                                    <div class="col-sm-3 pleft">
                                        <button type="button" class="btn btn-button btn-block btn-md btn_sell_estimate">Get Estimate</button>
                                    </div>
                                    <div class="clearfix">
                                        <a href="javascript:void(0)" class="searchLink"><i class="fa fa-search" aria-hidden="true"></i> Search Options</a>
                                        <div class="adventure-search-box">
                                            <a href="javascript:void(0)" class="adventure-search-close"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                                            <h3>Advanced Search</h3>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <select name="" class="selectpicker adv_min_price form-control">
                                                            <option value="">Min Price</option>
                                                            <option value="100000">N100K</option>
                                                            <option value="250000">N250K</option>
                                                            <option value="500000">N500K</option>
                                                            <option value="750000">N750K</option>
                                                            <option value="1000000">N1M</option>
                                                            <option value="2000000">N2M</option>
                                                            <option value="5000000">N5M</option>
                                                            <option value="10000000">N10M</option>
                                                            <option value="20000000">N20M</option>
                                                            <option value="40000000">N40M</option>
                                                            <option value="50000000">N50M</option>
                                                            <option value="60000000">N60M</option>
                                                            <option value="80000000">N80M</option>
                                                            <option value="100000000">N100M</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <select name="" class="selectpicker adv_max_price form-control">
                                                            <option value="">Max Price</option>
                                                            <option value="100000">N100K</option>
                                                            <option value="250000">N250K</option>
                                                            <option value="500000">N500K</option>
                                                            <option value="750000">N750K</option>
                                                            <option value="1000000">N1M</option>
                                                            <option value="2000000">N2M</option>
                                                            <option value="5000000">N5M</option>
                                                            <option value="10000000">N10M</option>
                                                            <option value="20000000">N20M</option>
                                                            <option value="40000000">N40M</option>
                                                            <option value="50000000">N50M</option>
                                                            <option value="60000000">N60M</option>
                                                            <option value="80000000">N80M</option>
                                                            <option value="100000000">N100M</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <select name="" class="selectpicker adv_bedroom form-control">
                                                            <option value="">Bedroom</option>
                                                            <option value="1">1+</option>
                                                            <option value="2">2+</option>
                                                            <option value="3">3+</option>
                                                            <option value="4">4+</option>
                                                            <option value="5">5+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <select name="" class="selectpicker adv_bathroom form-control">
                                                            <option value="">Bathroom</option>
                                                            <option value="1">1+</option>
                                                            <option value="2">2+</option>
                                                            <option value="3">3+</option>
                                                            <option value="4">4+</option>
                                                            <option value="5">5+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <select name="" class="selectpicker adv_garage form-control">
                                                            <option value="">Garage</option>
                                                            <option value="1">1+</option>
                                                            <option value="2">2+</option>
                                                            <option value="3">3+</option>
                                                            <option value="4">4+</option>
                                                            <option value="5">5+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <?= Html::dropDownList('property_type_id', '', yii\helpers\ArrayHelper::map(PropertyType::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Property Type', 'class' => 'adv_property_type multiselect_dropdown', 'multiple' => true]); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <?= Html::dropDownList('construction_status', '', yii\helpers\ArrayHelper::map(\common\models\ConstructionStatusMaster::find()->active()->all(), 'id', 'title'), ['data-placeholder' => 'Construction Status', 'class' => 'adv_construction_status multiselect_dropdown', 'multiple' => true]); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <?= Html::dropDownList('market_status', [Property::MARKET_ACTIVE], [Property::MARKET_ACTIVE => Property::MARKET_ACTIVE, Property::MARKET_PENDING => Property::MARKET_PENDING, Property::MARKET_SOLD => Property::MARKET_SOLD], ['data-placeholder' => 'Market Status', 'class' => 'adv_market_status multiselect_dropdown', 'multiple' => true]); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <?= Html::textInput('reference_id', '', ['placeholder' => 'Property ID', 'class' => 'form-control adv_propertyid']); ?>
                                                    </div>
                                                </div>
                                            </div> <!-- Row End-->
                                            <div class="row">
                                                <div class="col-sm-2 col-sm-push-5">
                                                    <div class="form-group">
                                                        <button name="" type="button" class="btn_sell_estimate btn btn-primary red-btn">Search Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?= Html::endForm() ?>
                                <div class="col-sm-12 searchbox-bottom">
                                    <div class="col-sm-4">
                                        <i class="fa fa-usd" aria-hidden="true"></i>
                                        <span>See estimated home value</span>
                                    </div>

                                    <div class="col-sm-4">
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <span>Ask for a personalized report</span>
                                    </div>

                                    <div class="col-sm-4">
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        <span>Learn to sell your home</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Home Search Form -->
</figure>
<!-- End Slider Section ==================================================-->

<!-- Start Content Section ==================================================-->
<section>
    <!-- Sell your home Sec -->
    <div class="sell-home-sec sell-search-bottom-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Want to Sell Your Home? <span>Follow The Steps</span></h2>

                    <div class="row">
                        <div class="home-sell-listing-sec">
                            <?php
                            if(!empty($staticBlockArr)){
                                $sl = 1;
                                foreach($staticBlockArr as $sellBlock){
                                    $photo = $sellBlock->photo;
                                    if($sellBlock->title == "Whip it into shape"){
                                    ?>
                                        <div class="col-sm-3">
                                            <a href="<?= Url::to(['/sell/view','slug' => 'whip-it-into-shape']) ?>" class="home-sell-listing">
                                                <img src="<?php echo $photo->getImageUrl() ?>" alt="">
                                                <div class="home-sell-round"><?= $sl ?> <span>step</span></div>
                                                <h3><?= $sellBlock->title ?></h3>
                                            </a>
                                        </div>
                                    <?php
                                    }elseif($sellBlock->title == "Register as a Seller"){
                                    ?>
                                        <div class="col-sm-3">
                                            <a href="<?= Url::to(['/sell/view','slug' => 'register-as-a-seller']) ?>" class="home-sell-listing">
                                                <img src="<?php echo $photo->getImageUrl() ?>" alt="">
                                                <div class="home-sell-round"><?= $sl ?> <span>step</span></div>
                                                <h3><?= $sellBlock->title ?></h3>
                                            </a>
                                        </div>
                                    <?php
                                    }elseif($sellBlock->title == "Find a listing agent"){
                                    ?>
                                        <div class="col-sm-3">
                                            <a href="<?= Url::to(['/sell/view','slug' => 'finding-a-listing-agent']) ?>" class="home-sell-listing">
                                                <img src="<?php echo $photo->getImageUrl() ?>" alt="">
                                                <div class="home-sell-round"><?= $sl ?> <span>step</span></div>
                                                <h3><?= $sellBlock->title ?></h3>
                                            </a>
                                        </div>
                                    <?php
                                    }elseif($sellBlock->title == "List at the Right Price"){
                                    ?>
                                        <div class="col-sm-3">
                                            <a href="<?= Url::to(['/sell/view','slug' => 'list-at-the-right-price']) ?>" class="home-sell-listing">
                                                <img src="<?php echo $photo->getImageUrl() ?>" alt="">
                                                <div class="home-sell-round"><?= $sl ?> <span>step</span></div>
                                                <h3><?= $sellBlock->title ?></h3>
                                            </a>
                                        </div>
                                    <?php
                                    }
                                $sl++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sell your home Sec -->
</section>
<!-- Start Content Section ==================================================-->

<?php
$js = "$(function(){
        $('.searchLink').click(function(){
            var thisForm = $(this).closest('form');
            thisForm.find('.adventure-search-box').slideDown();
        });
        $('.adventure-search-close').click(function(){
            var thisForm = $(this).closest('form');
            thisForm.find('.adventure-search-box').slideUp();
        });
        $('.multiselect_dropdown').multiselect();
    })";

$this->registerJs($js, View::POS_END);