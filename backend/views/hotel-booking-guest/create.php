<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HotelBookingGuest */

$this->title = Yii::t('app', 'Create Hotel Booking Guest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Booking Guests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-booking-guest-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
