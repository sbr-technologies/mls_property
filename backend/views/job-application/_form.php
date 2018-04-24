<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JobApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calling_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'dob')->textInput() ?>

    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
