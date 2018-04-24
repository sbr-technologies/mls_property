<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput() ?>

    <?= $form->field($model, 'lng')->textInput() ?>

    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'near_buy_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'metric_type_id')->textInput() ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_of_room')->textInput() ?>

    <?= $form->field($model, 'no_of_balcony')->textInput() ?>

    <?= $form->field($model, 'no_of_bathroom')->textInput() ?>

    <?= $form->field($model, 'lift')->textInput() ?>

    <?= $form->field($model, 'furnished')->textInput() ?>

    <?= $form->field($model, 'water_availability')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_of_electricity')->textInput() ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_video_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_type_id')->textInput() ?>

    <?= $form->field($model, 'property_category_id')->textInput() ?>

    <?= $form->field($model, 'construction_status_id')->textInput() ?>

    <?= $form->field($model, 'watermark_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
