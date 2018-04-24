<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use frontend\helpers\AuthHelper;
$user = Yii::$app->user->identity;
/* @var $this \yii\web\View */
/* @var $content string */


$this->registerCssFile(
    '@web/css/all-skins.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/css/font-awesome.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);
$this->registerCssFile(
    '@web/css/style.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);

$this->registerCssFile(
    '@web/css/site.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);

$this->registerCssFile(
    '@web/css/responsive.css',
    ['depends' => [
            yii\web\YiiAsset::className(),
            yii\bootstrap\BootstrapAsset::className(),
        ]
    ]
);


//$this->registerJsFile(
//    '@web/plugins/slimScroll/jquery.slimscroll.min.js',
//    ['depends' => [
//        \yii\web\JqueryAsset::className(),
//        \yii\bootstrap\BootstrapPluginAsset::ClassName()
//        ]
//   ]
//);

$this->registerJsFile(
    '@web/plugins/sweetalert.min.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
$this->registerJsFile(
    '@web/js/jquery.form.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
$this->registerJsFile(
    '@web/js/app.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
$this->registerJsFile(
    '@web/js/ajax-loader.js',
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


if(AuthHelper::is('buyer')){
    $profileUrl   =   'buyer/profile';
}else if(AuthHelper::is('agent', true)){
    $profileUrl   =   'agent/profile';
}else if(AuthHelper::is('seller')){
    $profileUrl   =   'seller/profile';
}else if(AuthHelper::is('hotel')){
    $profileUrl   =   'hotel-owner/profile';
}else if(AuthHelper::is('agency')){
    $profileUrl   =   'agency/profile';
}
?>

<?php
if (!Yii::$app->user->isGuest) {
    $js =' function updateNotificationDiv(){
              if($.active > 0){
                return false;
              }  
                
              $.post("' . Yii::$app->urlManager->createUrl('/user/notification') . '" , null ,
                    function(resp){
                        var vhtm = $(resp).html();
                         $(".notification_holder").html(vhtm);
                    }
            );
           }
           var notifUrl = "' . Yii::$app->urlManager->createUrl('/user/clear-notification') . '";
           ';
    $this->registerJs($js, \yii\web\View::POS_HEAD, 'edit_img');
}

$this->registerJsFile(
    '@web/js/notification.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
?>

<!-- Start Header Section ==================================================-->
<header class="main-header"> 
    <!-- Logo --> 
    <a href="<?= Yii::$app->homeUrl?>" class="logo"> 
        <span class="logo-mini"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/logo-icon.png" alt=""></span> 
        <span class="logo-lg"><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/logo.png" alt=""></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation"> 
        <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span></a>
        <!-- Top Search -->
<!--        <div class="col-sm-4 top-search">
            <form class="navbar-form" action="" method="">
                <div class="input-group add-on">
                    <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>-->
        <!-- Top Search -->

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications -->
                <?= $this->render('_notification') ?>
                <!-- Notifications -->

                <!-- User Account -->
                <li class="dropdown user user-menu"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><span class="hidden-xs"><?= $user->commonName?></span> <img src="<?php echo $user->getImageUrl(User::THUMBNAIL)?>" class="user-image" alt="User Image"></a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header"> <img src="<?php echo $user->getImageUrl(User::THUMBNAIL)?>" class="img-circle" alt="User Image">
                            <p> <?= $user->fullName. ' - '. $user->profile->title?>
                              <small>Member since <?= Yii::$app->formatter->asDate($user->created_at, 'long')?></small> </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
<!--                            <div class="col-xs-4 text-center"> <a href="javascript:void(0)">Followers</a> </div>
                            <div class="col-xs-4 text-center"> <a href="javascript:void(0)">Sales</a> </div>
                            <div class="col-xs-4 text-center"> <a href="javascript:void(0)">Friends</a> </div>-->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">  
                                <?= Html::a('Profile', [$profileUrl], ['class' => 'btn btn-success btn-flat'])?>
                            </div>
                            <div class="pull-right"> 
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- User Account -->
            </ul>
        </div>
    </nav>
</header>
<!-- End Header Section ==================================================-->

