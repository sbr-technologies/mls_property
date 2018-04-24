<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HotelBooking */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Hotel Booking',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="hotel-booking-update">


    <?= $this->render('_form', [
        'model' => $model, 'guestModels' => $guestModels
    ]) ?>

</div>
