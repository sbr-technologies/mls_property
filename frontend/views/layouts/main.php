<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\BootstrapPluginAsset;


AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

	
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?=Yii::$app->urlManager->baseUrl?>/favicon.ico" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="skin-black sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">
            <?= $this->render(
                'header.php'
            ) ?>
            <?= $this->render(
                'leftmenu.php'
            ) ?>
          <div class="layout-alert-wrapper">
            <?= Alert::widget() ?>
          </div>
            <?= $content ?>
            <?= $this->render(
                'footer.php'
            ) ?>
        </div>
      
<div id="mls_bs_modal_one" class="modal fade login-register-popup" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="loading"></div>
        </div>
    </div>
</div>
<div id="mls_bs_modal_two" class="modal fade login-register-popup" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="loading"></div>
        </div>
    </div>
</div>

<div id="mls_bs_modal_lg" class="modal fade login-register-popup" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="loading"></div>
        </div>
    </div>
</div>
      
<?php 
    if(!Yii::$app->session->has('tz')){
        $js = "$(function(){
        var d = new Date()
        var tzOffset = d.getTimezoneOffset();
        $.post('" . Yii::$app->urlManager->createUrl(['site/ping']) . "', {tz_offset:tzOffset}, function(resp){
        }, 'json');
        });";
        $this->registerJs($js, \yii\web\View::POS_END);
    }
?>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
