<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageBooking */

$this->title = Yii::t('app', 'Create Holiday Package Booking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-package-booking-create">


    <?= $this->render('_form', [
        'model' => $model,
        'holidayGuestModels'   => $holidayGuestModels
    ]) ?>

</div>
