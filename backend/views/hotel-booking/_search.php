<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HotelBookingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-booking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'booking_generated_id') ?>

    <?= $form->field($model, 'hotel_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'room') ?>

    <?php // echo $form->field($model, 'check_in_date') ?>

    <?php // echo $form->field($model, 'check_out_date') ?>

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
