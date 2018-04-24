<?php
use yii\web\AssetBundle;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Property;
use common\models\AdviceCategory;
use common\models\NewsCategory;
use common\models\Hotel;
use common\models\SiteConfig;
use common\models\Banner;
use common\models\Menu;
use yii\web\Session;
//use common\models\Rental;
use yii\web\View;


$user = Yii::$app->user->identity;
/* @var $this \yii\web\View */
/* @var $content string */

$this->registerCssFile(
    '@web/public_main/css/font-awesome.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/public_main/css/sitenav.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/plugins/owl-carousel/owl.carousel.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/public_main/css/site.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/public_main/css/responsive.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/public_main/css/mls-custom.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);

$this->registerCssFile(
    '@web/public_main/css/gallerybox.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);

$this->registerJsFile(
    '@web/public_main/js/gallerybox.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/plugins/owl-carousel/owl.carousel.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/plugins/slimScroll/jquery.slimscroll.min.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/js/account.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
    ]
);

$this->registerJsFile(
    '@web/public_main/js/site.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
    ]
); 

$varJs = "var loginPopupurl = '".Url::to(['site/login', 'popup' => 1])."';";
$this->registerJs($varJs, View::POS_HEAD);

$properties         = Property::find()->limit(5)->all();
$rentProperties     = Property::find()->where(['property_category_id' => 1])->limit(5)->all();
$sellProperties     = Property::find()->where(['property_category_id' => 2])->limit(5)->all();
$hotels             = Hotel::find()->limit(5)->all();
$newsCategopry      = NewsCategory::find()->active()->all();
$adviceCategopry    = AdviceCategory::find()->active()->all();

$buyImage           = Banner::find()->where(['type_id' => 3,'title' => 'Buy'])->one();
$sellImage          = Banner::find()->where(['type_id' => 3,'title' => 'Sell'])->one();
$findAgentImage     = Banner::find()->where(['type_id' => 3,'title' => 'Find Agent'])->one();
$hotelImage         = Banner::find()->where(['type_id' => 3,'title' => 'Hotel'])->one();
$newsImage          = Banner::find()->where(['type_id' => 3,'title' => 'News'])->one();
$connectImage       = Banner::find()->where(['type_id' => 3,'title' => 'Connect'])->one();

$homeForSale        =   Menu::find()->where(['parent_id' => 5])->all();
$homeValues         =   Menu::find()->where(['parent_id' => 9])->all();
$homeTips           =   Menu::find()->where(['parent_id' => 12])->all();

$homeSelling        =   Menu::find()->where(['parent_id' => 17])->all();
$community          =   Menu::find()->where(['parent_id' => 21])->all();
$sellingTips        =   Menu::find()->where(['parent_id' => 24])->all();

$appointmentRent    =   Menu::find()->where(['parent_id' => 28])->all();
$commonSearch       =   Menu::find()->where(['parent_id' => 32])->all();
$landLordTools      =   Menu::find()->where(['parent_id' => 35])->all();

$findMls            =   Menu::find()->where(['parent_id' => 41])->all();
$whyMls             =   Menu::find()->where(['parent_id' => 43])->all();
$howMls             =   Menu::find()->where(['parent_id' => 46])->all();

$hotelMenu          =   Menu::find()->where(['parent_id' => 50])->all();
$shortRentalTools   =   Menu::find()->where(['parent_id' => 55])->all();

$guideMore          =   Menu::find()->where(['parent_id' => 59])->all();
$contactUs          =   Menu::find()->where(['parent_id' => 61])->all();
$propertyTool       =   Menu::find()->where(['parent_id' => 65])->all();
$locateUs           =   Menu::find()->where(['parent_id' => 68])->all();

$shortLet           =   Menu::find()->where(['parent_id' => 74])->all();


$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
//echo $controller;
$session = Yii::$app->session;
//echo 11;
// get a session variable. The following usages are equivalent:
$locationId = $session->get('locationId');

if(isset($locationId)){
    $locationArr   =   explode('_',$locationId);
    if(count($locationArr) > 1){
        $location       =   $locationArr[0]." ".$locationArr[1];
    }else{
        $location       =   $locationArr[0];
    }
    
}else{
    $location   =   '';
}
//yii\helpers\VarDumper::dump($location); exit;
//\yii\helpers\VarDumper::dump($rentProperties); exit;
?>

<!-- Start Header Section ==================================================-->
<header class="mainheader">
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <!-- Header Top -->
    <div class="headertop">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 loginregister">
                    <?php
                    if(Yii::$app->user->isGuest){ ?>
                        <?= Html::a('Login', 
                            ['/site/login', 'popup' => 1],
                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal']
                        ); ?>
                        <?= Html::a('Register', 
                            ['/site/signup','popup' => 1],
                            ['data-target' => '#mls_bs_modal_two', 'data-toggle' => 'modal']
                        ); ?>
                    <?php
                    }else{ ?>
                        <?= Html::a(
                            'Dashboard',
                            $user->dashboardUrl,
                            ['class' => '']
                        ) ?>
                        <?= Html::a(
                            'Logout',
                            ['/site/logout'],
                            ['data-method' => 'post', 'class' => '']
                        ) ?>
                    <?php
                    }
                    ?>
                    
                    
                </div>
                <div class="col-sm-9 text-right">
                  <div class="topphone"><i class="fa fa-phone" aria-hidden="true"></i> <span>feel free to call</span> <?= SiteConfig::item('adminPhone')?></div>
                    <div class="topsocial">
                      <a href="<?= SiteConfig::item('facebookLink')?>" class="facebook" target="_blank"><i class="fa fa-facebook-f"></i></a>
                        <a href="<?= SiteConfig::item('linkedinLink')?>" class="linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="<?= SiteConfig::item('twitterLink')?>" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="<?= SiteConfig::item('instagramLink')?>" class="instagram" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="<?= SiteConfig::item('pinterestLink')?>" class="pinterest" target="_blank"><i class="fa fa-pinterest-p"></i></a>
                        <a href="<?= SiteConfig::item('youtubeLink')?>" class="youtube" target="_blank"><i class="fa fa-youtube"></i></a>
                        <!--<a href="<?= SiteConfig::item('facebookLink')?>" class="rss" target="_blank"><i class="fa fa-rss"></i></a>-->
                        <a href="<?= SiteConfig::item('gplusLink')?>" class="google-plus" target="_blank"><i class="fa fa-google-plus"></i></a>
                    </div>
                  <?php 
                    $selectedCurrency = 'NGN';
                    $cookies = Yii::$app->request->cookies;
                    if($cookies->has('selected_currency')){
                        $selectedCurrency = $cookies->getValue('selected_currency');
                    }
                  ?>
                    <div class="top_currency_converter form-group-sm">
                      <?= Html::dropDownList('selected_currency', $selectedCurrency, \yii\helpers\ArrayHelper::map(\common\models\CurrencyMaster::find()->all(), 'code', 'name'), ['class' => 'sel_change_currency form-control'])?>
                    </div>
                    <div class="toplanguage">
                      <!--<img src="images/language.png" alt="language">-->
                      <div id="google_translate_element"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Top -->

    <!-- Header Bottom -->
    <div class="headerbottom">
        <nav class="navbar navbar-default pmenu">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="navbar-brand" href="<?php echo Yii::$app->homeUrl?>"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/logo.png" alt=""></a>
                    </div>

                    <div class="top-nav">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                    <div class="collapse navbar-collapse js-navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown mega-dropdown <?= $controller == "buy" ? 'active' : ''  ?>"> <a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to(["realestate/index"]) ?>">BUY</a> <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Buy Top 5 Homes</li>
                                                    <li>
                                                        <?php
                                                        if (!empty($properties)) {
                                                        ?>
                                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <?php
                                                                foreach ($properties as $key => $property) {
                                                                    if($key == 0){
                                                                        $active     =   'active';
                                                                    }else{
                                                                        $active     =   '';
                                                                    }
                                                                ?>
                                                                    <div class="item <?= $active ?>"> 
                                                                      <a href="<?= Url::to(['property/view', 'slug' => $property->slug])?>">
                                                                            <?php
                                                                                $photosArr = $property->photos;
                                                                                if(is_array($photosArr) && count($photosArr) > 0){
                                                                                    foreach($photosArr as $photoKey => $photoVal){
                                                                                        if($photoKey == 0){
                                                                                            if(isset($photoVal) && $photoVal != ''){
                                                                                                $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                                                echo Html::img($alias,['class' => 'img-responsive']);
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }else{
                                                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'img-responsive','alt' => $property->formattedAddress,'height'=> '300px', 'width' => '300px']);
                                                                                }
                                                                                ?>
                                                                        </a>
                                                                        <h4><small><?php echo $property->formattedAddress; ?></small></h4>
                                                                        <div class="bannerbutton clearfix">
                                                                          <button class="btn btn-main" type="button"><?php echo Yii::$app->formatter->asCurrency($property->price); ?></button>
                                                                            <a class="btn btn-default nav-view-details-btn" href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>"><i class="fa fa-eye"></i> View Details</a>
                                                                        </div>
                                                                    </div>
                                                                <!-- End Carousel Inner --> 
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li><a href="javascript:void(0)">View all Collection</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Homes for Sale</li>
                                                        <?php
                                                        if(!empty($homeForSale)){
                                                            if(count($homeForSale) <= 4){
                                                                foreach($homeForSale as $key => $menu){   //realestate/search  
                                                        ?>  
                                                                    <li><a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($homeForSale as $key => $menu){ 
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($homeForSale as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                            ?>
                                                          <li><a href="<?= Url::to(["condominium/search"]) ?>">Condominium</a></li>      
                                                        <?php }
                                                        ?>
                                                        <li class="divider"></li>
                                                        <li class="dropdown-header">Home Values</li>
                                                        <?php
                                                        if(!empty($homeValues)){
                                                            if(count($homeValues) <= 4){
                                                                foreach($homeValues as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($homeValues as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($homeValues as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= $location? Url::to(["realestate/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?> 
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Home Buying Tips</li>
                                                    <?php
                                                    if(!empty($homeTips)){
                                                        if(count($homeTips) <= 4){
                                                            foreach($homeTips as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($homeTips as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 2){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($homeTips as $key => $menu){
                                                                        if($key > 2){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                  
                                                    <li class="divider"></li>
                                                    <li class="dropdown-header">Top Buy Home</li>
                                                    <li>
                                                        <p>
                                                            <a href="#">
                                                                <?php
                                                                if(!empty($buyImage)){
                                                                ?>
                                                                    <img src="<?= $buyImage->photo->imageUrl ?>" alt="For Buy Home"> 
                                                                <?php
                                                                }else{
                                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'img-responsive','height'=> '300px', 'width' => '300px']);
                                                                }
                                                                ?>
                                                            </a>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown mega-dropdown <?= $controller == "sell" ? 'active' : ''  ?>"> <a href="<?= Url::to(['sell/index']) ?>">SELL</a> <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Top Selling Home</li>
                                                    <li> 
                                                        <?php 
                                                        if(!empty($sellProperties)){
                                                        ?>
                                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <?php
                                                                foreach ($sellProperties as $key => $property) {
                                                                    if($key == 0){
                                                                        $active     =   'active';
                                                                    }else{
                                                                        $active     =   '';
                                                                    }
                                                                ?>
                                                                    <div class="item <?= $active ?>"> 
                                                                        <a href="javascript:void(0)">
                                                                        <?php
                                                                            $photosArr = $property->photos;
                                                                            if(is_array($photosArr) && count($photosArr) > 0){
                                                                                foreach($photosArr as $photoKey => $photoVal){
                                                                                    if($photoKey == 0){
                                                                                        if(isset($photoVal) && $photoVal != ''){
                                                                                            $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                                            echo Html::img($alias,['class' => 'img-responsive']);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'img-responsive','alt' => $property->formattedAddress,'height'=> '300px', 'width' => '300px']);
                                                                            }
                                                                            ?>
                                                                        </a>
                                                                        <h4><small><?php echo $property->formattedAddress; ?></small></h4>
                                                                        <div class="bannerbutton clearfix">
                                                                          <button class="btn btn-main" type="button"><?php echo Yii::$app->formatter->asCurrency($property->price); ?></button>
                                                                            <a class="btn btn-default nav-view-details-btn" href="<?php echo Url::to(['property/view', 'slug' => $property->slug]) ?>"><i class="fa fa-eye"></i> View Details</a>
                                                                        </div>
                                                                    </div>
                                                                <?php 
                                                                }
                                                                ?>
                                                                <!-- End Item --> 
                                                            </div>
                                                            <!-- End Carousel Inner --> 
                                                        </div>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <?php
                                                        if(!empty($homeSelling)){
                                                            if(count($homeSelling) <= 4){
                                                                foreach($homeSelling as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($homeSelling as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($homeSelling as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }?>
                                                            <li><a href="<?= Url::to(["condominium/search"]) ?>">Condominium</a></li>
                                                        <?php }
                                                        ?>
                                                        <li class="divider"></li>
                                                        <li class="dropdown-header">Community</li>
                                                        <?php
                                                        if(!empty($community)){
                                                            if(count($community) <= 4){
                                                                foreach($community as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($community as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($community as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Home Selling Tips</li>
                                                    <?php
                                                    if(!empty($sellingTips)){
                                                        if(count($sellingTips) <= 4){
                                                            foreach($sellingTips as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($sellingTips as $key => $menu){ 
                                                                if($key <= 3){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($sellingTips as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>
                                                        <p>
                                                            <a href="#">
                                                                <?php
                                                                if(!empty($sellImage)){
                                                                ?>
                                                                    <img src="<?= $sellImage->photo->imageUrl ?>" alt="For Sell Home"> 
                                                                <?php
                                                                }
                                                                ?>
                                                            </a>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown mega-dropdown <?= $controller == "rental" ? 'active' : ''  ?>"> 
                                <a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to(["rental/index"]) ?>">RENT</a>
                                <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Short Let</li>
                                                        <?php
                                                        if(!empty($shortLet)){
                                                            if(count($shortLet) <= 4){
                                                                foreach($shortLet as $key => $menu){ 
                                                                    if($menu->id ==73){
                                                                        ?>
                                                                        <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId."&rent_type=short_let"]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                        <?php
                                                                    }else{
                                                        ?>  
                                                                    <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                            }else{
                                                                foreach($shortLet as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                        if($menu->id ==73){
                                                                           ?>
                                                                           <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId."&rent_type=short_let"]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                    <?php
                                                                        }else{
                                                                            ?>
                                                                            <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                    
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul class="global-nav-list-unstyled">
                                                    <li class="dropdown-header">Apartments for Rent</li>
                                                    <?php
                                                    if(!empty($appointmentRent)){
                                                        if(count($appointmentRent) <= 4){
                                                            foreach($appointmentRent as $key => $menu){ 
                                                                if($menu->id ==73){
                                                                    ?>
                                                                    <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId."&rent_type=short_let"]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                    <?php
                                                                }else{
                                                    ?>  
                                                                <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                        }else{
                                                            foreach($appointmentRent as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                    if($menu->id ==73){
                                                                       ?>
                                                                       <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId."&rent_type=short_let"]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                    }else{
                                                                        ?>
                                                                        <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>

                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }?>
                                                        <li><a href="<?= Url::to(["condominium/search"]) ?>">Condominium</a></li>
                                                    <?php }
                                                    ?>
                                                </ul>
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="divider"></li>
                                                        <li class="dropdown-header">Common Searches</li>
                                                        <?php
                                                        if(!empty($commonSearch)){
                                                            if(count($commonSearch) <= 4){
                                                                foreach($commonSearch as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($commonSearch as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($commonSearch as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= $location? Url::to(["rental/search?location=".$locationId]):Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $location." ".$menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Landlord Tools</li>
                                                    <?php
                                                    if(!empty($landLordTools)){
                                                        if(count($landLordTools) <= 4){
                                                            foreach($landLordTools as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($landLordTools as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($landLordTools as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Rent Top 5 Homes</li>
                                                    <li>
                                                        <?php 
                                                        if(!empty($rentProperties)){
                                                        ?>
                                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <?php
                                                                foreach ($rentProperties as $key => $property) {
                                                                    if($key == 0){
                                                                        $active     =   'active';
                                                                    }else{
                                                                        $active     =   '';
                                                                    }
                                                                ?>
                                                                    <div class="item <?= $active ?>"> 
                                                                        <a href="javascript:void(0)">
                                                                        <?php
                                                                            $photosArr = $property->photos;
                                                                            if(is_array($photosArr) && count($photosArr) > 0){
                                                                                foreach($photosArr as $photoKey => $photoVal){
                                                                                    if($photoKey == 0){
                                                                                        if(isset($photoVal) && $photoVal != ''){
                                                                                            $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                                            echo Html::img($alias,['class' => 'img-responsive','alt' => $property->formattedAddress,'height'=> '300px', 'width' => '300px']);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'img-responsive','alt' => $property->formattedAddress,'height'=> '300px', 'width' => '300px']);
                                                                            }
                                                                            ?>
                                                                        </a>
                                                                        <h4><small><?php echo $property->formattedAddress; ?></small></h4>
                                                                        <div class="bannerbutton clearfix">
                                                                          <button class="btn btn-main" type="button"><?php echo Yii::$app->formatter->asCurrency($property->price); ?></button>
                                                                            <a class="btn btn-default nav-view-details-btn" href="<?php echo Url::to(['rental/view', 'slug' => $property->slug]) ?>"><i class="fa fa-eye"></i> View Details</a>
                                                                        </div>
                                                                    </div>
                                                                <?php 
                                                                }
                                                                ?>
                                                                <!-- End Item --> 
                                                            </div>
                                                            <!-- End Carousel Inner --> 
                                                        </div>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown mega-dropdown <?= $controller == "find-agent" ? 'active' : ''  ?>"> <a href="<?= Url::to(['find-agent/index']) ?>">FIND AGENT</a> <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Find MLS</li>
                                                        <?php
                                                        if(!empty($findMls)){
                                                            if(count($findMls) <= 4){
                                                                foreach($findMls as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($findMls as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($findMls as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Why Use MLS</li>
                                                    <?php
                                                    if(!empty($whyMls)){
                                                        if(count($whyMls) <= 4){
                                                            foreach($whyMls as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($whyMls as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($whyMls as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">How Use MLS</li>
                                                    <?php
                                                    if(!empty($howMls)){
                                                        if(count($howMls) <= 4){
                                                            foreach($howMls as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($howMls as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($howMls as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">News Around MLS</li>
                                                    <li> 
                                                        <p>
                                                            <a href="#">
                                                                <?php
                                                                if(!empty($findAgentImage)){
                                                                ?>
                                                                    <img src="<?= $findAgentImage->photo->imageUrl ?>" alt="Find Agent"> 
                                                                <?php
                                                                }else{
                                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['alt' => 'Find Agent']);
                                                                }
                                                                ?>
                                                            </a>
                                                        </p>
                                                    </li>
                                                    <li> <a href="javascript:void(0)">More News Around MLS</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown mega-dropdown <?= $controller == "hotel" || $controller == "holiday-package" ? 'active' : ''  ?>"> <a href="<?= Url::to(['hotel/index']) ?>">HOTELS & BnB</a> <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Top 5 Hotels</li>
                                                    <li>
                                                        <?php 
                                                        if(!empty($hotels)){
                                                        ?>
                                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <?php
                                                                foreach ($hotels as $key => $hotel) {
                                                                    if($key == 0){
                                                                        $active     =   'active';
                                                                    }else{
                                                                        $active     =   '';
                                                                    }
                                                                ?>
                                                                <div class="item <?= $active ?>">
                                                                    <a href="javascript:void(0)">
                                                                        <?php
                                                                        $photosArr = $hotel->photos;
                                                                        if(is_array($photosArr) && count($photosArr) > 0){
                                                                            foreach($photosArr as $photoKey => $photoVal){
                                                                                if($photoKey == 0){
                                                                                    if(isset($photoVal) && $photoVal != ''){
                                                                                        $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                                                        echo Html::img($alias,['class' => 'img-responsive']);
                                                                                    }
                                                                                }
                                                                            }
                                                                        }else{
                                                                            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['class' => 'img-responsive']);
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                    <h4><small><?php echo $hotel->name; ?></small></h4>
                                                                    <div class="bannerbutton clearfix">
                                                                      <button class="btn btn-main" type="button"><?= Yii::$app->formatter->asCurrency($hotel->price) ?></button>
                                                                        <button href="<?php echo Url::to(['hotel/view','slug' => $hotel->slug]) ?>" class="btn btn-default" type="button"><i class="fa fa-eye"></i> View Details</button>
                                                                    </div>
                                                                </div>
                                                                <!-- End Item --> 
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <!-- End Carousel Inner --> 
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Hotels</li>
                                                        <?php
                                                        if(!empty($hotelMenu)){
                                                            if(count($hotelMenu) <= 4){
                                                                foreach($hotelMenu as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($hotelMenu as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($hotelMenu as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Holiday Package</li>
                                                        <li><a href="<?= Url::to(["holiday-package/index"]) ?>">Package List</a></li>     
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Short Rentals Tools</li>
                                                    <?php
                                                    if(!empty($shortRentalTools)){
                                                        if(count($shortRentalTools) <= 4){
                                                            foreach($shortRentalTools as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($shortRentalTools as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($shortRentalTools as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    <li>
                                                        <p>
                                                            <a href="#">
                                                                <?php
                                                                if(!empty($hotelImage)){
                                                                ?>
                                                                    <img src="<?= $hotelImage->photo->imageUrl ?>" alt="Hotel"> 
                                                                <?php
                                                                }else{
                                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['alt' => 'Hotel']);
                                                                }
                                                                ?>
                                                            </a>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown mega-dropdown <?= $controller == "news" ? 'active' : ''  ?>"> <a href="<?php echo Url::to(['news/index','id' => 1]) ?>">NEWS & ADVICES</a> <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">News</li>
                                                        <?php
                                                        if(!empty($newsCategopry)){
                                                            if(count($newsCategopry) <= 4){
                                                                foreach($newsCategopry as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?php echo Url::to(['news/index','id' => $menu->id]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($newsCategopry as $key => $menu){ 
                                                                    if($key <= 2){
                                                                    ?>  
                                                                    <li><a href="<?php echo Url::to(['news/index','id' => $menu->id]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($newsCategopry as $key => $menu){
                                                                            if($key > 2){
                                                                        ?>   
                                                                            <li><a href="<?php echo Url::to(['news/index','id' => $menu->id]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?> 
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Advice</li>
                                                    <?php
                                                    if(!empty($adviceCategopry)){
                                                        if(count($adviceCategopry) <= 4){
                                                            foreach($adviceCategopry as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?php echo Url::to(['news/advice','id' => $menu->id]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($adviceCategopry as $key => $menu){ 
                                                                if($key <= 2){
                                                                ?>  
                                                                <li><a href="<?php echo Url::to(['news/advice','id' => $menu->id]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($adviceCategopry as $key => $menu){
                                                                        if($key > 2){
                                                                    ?>   
                                                                        <li><a href="<?php echo Url::to(['news/advice','id' => $menu->id]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Guides & More</li>
                                                   <?php
                                                    if(!empty($guideMore)){
                                                        if(count($guideMore) <= 4){
                                                            foreach($guideMore as $key => $menu){     
                                                    ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                            }
                                                        }else{
                                                            foreach($guideMore as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                ?>  
                                                                <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($guideMore as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Videos</li>
                                                    <li> 
                                                        <p>
                                                            <a href="#">
                                                                <?php
                                                                if(!empty($newsImage)){
                                                                ?>
                                                                    <img src="<?= $newsImage->photo->imageUrl ?>" alt="News"> 
                                                                <?php
                                                                }
                                                                ?>
                                                            </a>
                                                        </p>
                                                    </li>
                                                    <li> <a href="javascript:void(0)">Real Estate Videos</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown mega-dropdown <?= $controller == "connect" ? 'active' : ''  ?>"> <a href="<?= Url::to(['connect/about']) ?>">CONNECT US</a> <a href="javascript:void(0)" class="dropdown-toggle visible-xs" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Contact Us</li>
                                                        <?php
                                                        if(!empty($contactUs)){
                                                            if(count($contactUs) <= 4){
                                                                foreach($contactUs as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($contactUs as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($contactUs as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
<!--                                                        <li><a href="<?php echo Url::to(['site/about']) ?>">About Us</a></li>
                                                        <li><a href="javascript:void(0)">Locate us</a></li>
                                                        <li><a href="<?php echo Url::to(['site/contact']) ?>">Contact Us</a></li>-->
                                                    </ul>
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Property Tools</li>
                                                    <?php
                                                    if(!empty($propertyTool)){
                                                        if(count($propertyTool) <= 4){
                                                            foreach($propertyTool as $key => $menu){ 
                                                                if($menu->name == 'Request for Property'){
                                                                   
                                                                ?>
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                  
                                                                }else{
                                                                ?>
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }
                                                        }else{
                                                            foreach($propertyTool as $key => $menu){ 
                                                                //echo $key;
                                                                if($key <= 3){
                                                                    if($menu->name == 'Request for Property'){
                                                                    ?>
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                    }else{
                                                                    ?>
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <li class="more-menu">
                                                                <ul>
                                                                    <?php
                                                                    foreach($propertyTool as $key => $menu){
                                                                        if($key > 3){
                                                                    ?>   
                                                                        <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                            <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                            <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
<!--                                            <div class="col-sm-3">
                                                <ul>
                                                    <ul class="global-nav-list-unstyled">
                                                        <li class="dropdown-header">Locate Us</li>
                                                        <?php
                                                        if(!empty($locateUs)){
                                                            if(count($locateUs) <= 4){
                                                                foreach($locateUs as $key => $menu){     
                                                        ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                }
                                                            }else{
                                                                foreach($locateUs as $key => $menu){ 
                                                                    //echo $key;
                                                                    if($key <= 3){
                                                                    ?>  
                                                                    <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="more-menu">
                                                                    <ul>
                                                                        <?php
                                                                        foreach($locateUs as $key => $menu){
                                                                            if($key > 3){
                                                                        ?>   
                                                                            <li><a href="<?= Url::to([$menu->link ? $menu->link : "#"]) ?>"><?= $menu->name ?></a></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </li>
                                                                <li class="more-menu-link"><a href="javascript:void(0)">More</a></li>
                                                                <li class="less-menu-link"><a href="javascript:void(0)">Less</a></li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </ul>
                                            </div>-->
                                            <div class="col-sm-4">
                                                <ul>
                                                    <li class="dropdown-header">Contact Us</li>
                                                    <li>
                                                        <p>
                                                            <a href="#">
                                                                <?php
                                                                if(!empty($connectImage)){
                                                                ?>
                                                                    <img src="<?= $connectImage->photo->imageUrl ?>" alt="Connect Us"> 
                                                                <?php
                                                                }else{
                                                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png',['alt' => 'Connect Us']));
                                                                }
                                                                ?>
                                                            </a>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Header Bottom -->
</header>
<!-- End Header Section ==================================================-->


<?php
$js = "$('document').ready(function () {
    $('#google_translate_element').on('click', function () {

        // Change font family and color
        $('iframe').contents().find('.goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div, .goog-te-menu2 *')
            .css({
                'color': '#544F4B',
                'font-family': 'tahoma'
            });

        // Change hover effects
        $('iframe').contents().find('.goog-te-menu2-item div').hover(function () {
            $(this).css('background-color', '#F38256').find('span.text').css('color', 'white');
        }, function () {
            $(this).css('background-color', 'white').find('span.text').css('color', '#544F4B');
        });

        // Change Google's default blue border
        $('iframe').contents().find('.goog-te-menu2').css('border', '1px solid #F38256');

        // Change the iframe's box shadow
        $('.goog-te-menu-frame').css({
            '-moz-box-shadow': '0 3px 8px 2px #666666',
            '-webkit-box-shadow': '0 3px 8px 2px #666',
            'box-shadow': '0 3px 8px 2px #666'
        });
    });
    
    $('.sel_change_currency').on('change', function(){
        $.post('".Url::to(['site/convert-currency'])."', {selected_currency:$(this).val()}, function(response){
            location.reload();
        }, 'json');
    });
});";

$this->registerJs($js, View::POS_END);