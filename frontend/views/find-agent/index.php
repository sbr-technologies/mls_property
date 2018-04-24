<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\StaticBlock;
use common\models\Banner;
use common\models\User;
use common\models\StaticPage;
use yii\helpers\Inflector;
use common\models\BannerType;


$this->registerJsFile(
    '@web/public_main/js/find_agent.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->title = "Find Agent";
$bannerType     = BannerType::findByName('Find Agent');
$staticBlocks = StaticBlock::find()->where(['block_location_id' => 3])->orderBy(['id' => SORT_ASC])->limit(6)->active()->all();
$findAgentBottom = StaticBlock::find()->where(['block_location_id' => 4])->orderBy(['id' => SORT_ASC])->limit(3)->active()->all();
$banners = Banner::find()->where(['type_id' => $bannerType->id])->orderBy(['sort_order' => SORT_ASC])->active()->all();
$trustedHand = StaticBlock::findByTitle('Trusted Hand'); 
//yii\helpers\VarDumper::dump($findAgentBottom,4,12); exit;
?>
<!-- Start Slider Section ==================================================-->
<figure class="bannerwithsearch">
    <!-- Home Slider -->
    <?php 
    if (!empty($banners)) {
    ?>
        <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                foreach ($banners as $key => $banner) {
                    $bannerUrl      =   '';
                    $photo = $banner->photo;
                    $alias = $photo->getImageUrl();
                ?>
                <div class="item slider <?php echo $key == 0 ? 'active' : ''; ?>" style="background-image:url(<?php echo $photo->getImageUrl() ?>);">
                    <div class="slidercontent">
                        <div class="container">
                            <div class="figuretext"><?php echo $banner->title; ?></div>
                            <div class="figuretextbottom"><?php echo $banner->description; ?></div>
                        </div>
                    </div>
                </div>
                <?php 
                }
                ?>
            </div>
        </div>
    <?php 
    }
    ?>
    <!-- Home Slider -->

    <!-- Home Search Form -->
    <div class="searchhome">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-push-1">
                    <div class="searchholder clearfix">
                        <div class="row">
                            <div class="searchbox agent-searchbox clearfix form-group-md">
                                <div class="col-sm-5">
                                    <?php echo $this->render('//shared/_location_suggestion');?>
                                    
                                </div>
                                <div class="col-sm-5">
                                    <?php echo $this->render('//shared/_agent_suggestion');?>
                                </div>
                                <div class="col-sm-2">
                                    <?= Html::beginForm(['find-agent/search'], 'get', ['class' => 'frm_geocomplete frm_find_agent_page_search','id' => 'buy_property_form']) ?>
                                    <?= Html::hiddenInput('location', '', ['class' => 'realestate_search_location'])?>
                                    <?= Html::hiddenInput('name', '', ['class' => 'realestate_search_agent'])?>
                                        <?= Html::button('Search Now', ['class' => 'btn btn-button btn-block btn-md btn_search_agent_home']) ?>
                                    <?= Html::endForm() ?>
                                </div>
                                <div class="border"></div>
                                <div class="col-sm-10">
                                    <label>Agent, Offices or Teams <i class="fa fa-caret-down" aria-hidden="true"></i></label>
                                    <select name="advance-search" class="selectpicker form-control" id="advance-search" onchange="showHideDiv(this.value);">
                                        <option value="">Select</option>
                                        <option value="agent">Agent</option>
                                        <option value="office">Offices</option>
                                        <option value="teams">Team</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <div id="agentDiv" style="display:none;">
                                        <?= Html::a('More Search', 
                                            ['/find-agent/agent-adv-search'],
                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'class' => 'btn btn-button btn-block btn-md mtop30 btn-advance-search']
                                        ); ?>
                                    </div>
                                    <div id="officeDiv" style="display:none;">
                                        <?= Html::a('More Search', 
                                            ['/find-agent/office-adv-search'],
                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'class' => 'btn btn-button btn-block btn-md mtop30 btn-advance-search']
                                        ); ?>
                                    </div>
                                    <div id="teamsDiv" style="display:none;">
                                        <?= Html::a('More Search', 
                                            ['/find-agent/teams-adv-search'],
                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'class' => 'btn btn-button btn-block btn-md mtop30 btn-advance-search']
                                        ); ?>
                                    </div>
                                    
                                    <!--<button type="button" class="btn btn-button btn-block btn-md mtop30 btn-advance-search">More Search</button>-->
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
            <!-- Home Service Sec -->
        <div class="home-service-sec">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Benefits of Using a AGENT</h2>
                        <div class="home-service-list-sec agent-benefit-list">
                        <?php
                        if (!empty($staticBlocks)) {
                            foreach($staticBlocks as $block){
                        ?>
                                <div class="col-sm-4">
                                    <a href="javascript:void(0)">
                                        <img src="<?= $block->photo->imageUrl ?>" alt="">
                                        
                                        <h3><?= $block->title ?></h3>
                                        <?= $block->content ?>
                                    </a>
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
        <!-- Home Service Sec -->

        <!-- News Advice Sec -->
        <?php
        if(!empty($trustedHand)){
        ?>
        <div class="agent-advice-sec" style="background:rgba(0, 0, 0, 0) url('<?= $trustedHand->photo->imageUrl ?>') no-repeat fixed 0 0 / cover">
            <?= $trustedHand->content ?>
        </div>
        
        <?php
        }
        ?>
        <!-- News Advice Sec -->

        <!-- Find Agent Bottom List Sec -->
            <div class="find-agent-bottom-list-sec">
            <div class="container">
                <div class="row">
                    <?php
                    if(!empty($findAgentBottom)){
                        foreach($findAgentBottom as $bottom){
                    ?>
                    <div class="col-sm-4">
                        <div class="find-agent-bottom-list">
                            <img src="<?= $bottom->photo->imageUrl ?>" alt="">
                            <div class="agent-list-overlay"></div>
                            <div class="find-agent-bottom-con">
                                <h3><?= $bottom->title ?></h3>
                                <?= $bottom->content ?>
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
        <!-- Find Agent Bottom List Sec -->
    </section>
<!-- Start Content Section ==================================================-->
