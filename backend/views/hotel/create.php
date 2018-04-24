<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Hotel */

$this->title = Yii::t('app', 'Create Hotel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    '@web/js/hotel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

<div class="hotel-create">


    <?= $this->render('_form', [
        'model' => $model,
        'metaTagModel'      =>  $metaTagModel,
        'facilityModel'     =>  $facilityModel,
        'facilityRoomModel' =>  $facilityRoomModel,
    ]) ?>

</div>
