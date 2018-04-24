<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RentalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rental-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'address1') ?>

    <?php // echo $form->field($model, 'address2') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'zip_code') ?>

    <?php // echo $form->field($model, 'land_mark') ?>

    <?php // echo $form->field($model, 'near_buy_location') ?>

    <?php // echo $form->field($model, 'metric_type_id') ?>

    <?php // echo $form->field($model, 'size_range') ?>

    <?php // echo $form->field($model, 'lot_area_range') ?>

    <?php // echo $form->field($model, 'room_range') ?>

    <?php // echo $form->field($model, 'balcony_range') ?>

    <?php // echo $form->field($model, 'bathroom_range') ?>

    <?php // echo $form->field($model, 'lift') ?>

    <?php // echo $form->field($model, 'studio') ?>

    <?php // echo $form->field($model, 'pet_friendly') ?>

    <?php // echo $form->field($model, 'in_unit_laundry') ?>

    <?php // echo $form->field($model, 'pools') ?>

    <?php // echo $form->field($model, 'homes') ?>

    <?php // echo $form->field($model, 'furnished') ?>

    <?php // echo $form->field($model, 'water_availability') ?>

    <?php // echo $form->field($model, 'status_of_electricity') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'currency_symbol') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'property_video_link') ?>

    <?php // echo $form->field($model, 'property_type_id') ?>

    <?php // echo $form->field($model, 'property_category_id') ?>

    <?php // echo $form->field($model, 'construction_status_id') ?>

    <?php // echo $form->field($model, 'watermark_image') ?>

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
