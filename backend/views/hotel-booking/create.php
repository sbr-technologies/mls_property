<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HotelBooking */

$this->title = Yii::t('app', 'Create Hotel Booking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-booking-create">


    <?= $this->render('_form', [
        'model' => $model, 'guestModels' => $guestModels
    ]) ?>

</div>
