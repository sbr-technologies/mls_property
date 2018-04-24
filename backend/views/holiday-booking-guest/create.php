<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HolidayBookingGuest */

$this->title = Yii::t('app', 'Create Holiday Booking Guest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Booking Guests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-booking-guest-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
