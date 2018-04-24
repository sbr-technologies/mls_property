<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Hotel */

$this->title = Yii::t('app', 'Create Room');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    '@web/js/hotel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

<div class="hotel-create">
    <?= $this->render('_room-form', [
        'roomModel'             => $roomModel, 
        'hotel_id'              => $hotel_id,
    ]) ?>

</div>
