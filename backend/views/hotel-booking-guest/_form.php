<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HotelBookingGuest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-booking-guest-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'frm_update_guest']]); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'],['prompt' => 'Select Gender']) ?>

    <?= $form->field($model, 'age')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
