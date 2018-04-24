<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Hotel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Hotel',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->registerJsFile(
    '@web/js/hotel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<div class="hotel-update">


    <?= $this->render('_form', [
        'model'             => $model,
        'metaTagModel'      =>  $metaTagModel,
        'facilityModel'     =>  $facilityModel,
        'facilityRoomModel' =>  $facilityRoomModel,
    ]) ?>

</div>
