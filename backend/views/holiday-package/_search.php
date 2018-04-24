<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'package_amount') ?>

    <?php // echo $form->field($model, 'no_of_days') ?>

    <?php // echo $form->field($model, 'no_of_nights') ?>

    <?php // echo $form->field($model, 'hotel_transport_info') ?>

    <?php // echo $form->field($model, 'departure_date') ?>

    <?php // echo $form->field($model, 'inclusion') ?>

    <?php // echo $form->field($model, 'exclusions') ?>

    <?php // echo $form->field($model, 'payment_policy') ?>

    <?php // echo $form->field($model, 'cancellation policy') ?>

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
