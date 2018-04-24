<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageBooking */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Holiday Package Booking',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="holiday-package-booking-update">


    <?= $this->render('_form', [
        'model' => $model,
        'holidayGuestModels' => $holidayGuestModels
    ]) ?>

</div>
