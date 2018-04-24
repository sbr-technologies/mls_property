<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Rental */

$this->title = Yii::t('app', 'Create Rental');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rentals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    '@web/js/rental.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/moment/moment.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->registerCssFile(
    '@web/js/plugins/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
		
$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<div class="rental-create">

    <?= $this->render('_form', [
        'model' => $model,
        'localInfoModel'    =>  $localInfoModel,
        'metaTagModel'      =>  $metaTagModel,
        'rentalTypeModel'   =>  $rentalTypeModel,
        'featureModel'      =>  $featureModel,
        'featureItemModel'  =>  $featureItemModel,
        'openHouseModel'    =>  $openHouseModel,
    ]) ?>

</div>
