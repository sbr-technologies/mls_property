<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PhotoGallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="photo-gallery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image_file_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_file_extension')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'original_file_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
