<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $roomModel common\models\Hotel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Hotel',
]) . $roomModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $roomModel->name, 'url' => ['room-view', 'id' => $roomModel->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');


?>
<div class="hotel-update">


    <?= $this->render('_room-form', [
        'roomModel'             => $roomModel, 
        'hotel_id'              => $hotel_id,
    ]) ?>

</div>
