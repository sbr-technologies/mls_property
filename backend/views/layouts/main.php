<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    
    $this->registerJsFile(
        '@web/js/jquery.form.js',
        ['depends' => [
            \yii\web\JqueryAsset::className(),
            \yii\bootstrap\BootstrapPluginAsset::ClassName()
            ]
       ]
    );
   
//    $this->registerCssFile(
//        '@web/js/plugins/bootstrap-datepicker/css/datepicker.css',
//        ['depends' => [\yii\web\JqueryAsset::className()]]
//    );
//    
//    $this->registerJsFile(
//        '@web/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
//        ['depends' => [\yii\web\JqueryAsset::className()]]
//    );
    
  
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
    <div id="mls_bs_modal_one" class="modal fade inner_popup_form" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="loading"></div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
