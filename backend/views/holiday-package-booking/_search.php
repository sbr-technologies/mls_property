<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageBookingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-package-booking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'booking_generated_id') ?>

    <?= $form->field($model, 'holiday_package_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'departure_date') ?>

    <?php // echo $form->field($model, 'departure_location') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'payment_mode') ?>

    <?php // echo $form->field($model, 'card_last_4_digit') ?>

    <?php // echo $form->field($model, 'no_of_adult') ?>

    <?php // echo $form->field($model, 'no_of_children') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
