<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CurrencyMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ex_ngn')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ex_usd')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ex_cny')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ex_eur')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ex_gbp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ex_zar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
