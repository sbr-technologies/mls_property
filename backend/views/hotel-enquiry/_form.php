<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Hotel;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\HotelEnquiry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-enquiry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hotel_id')->dropDownList(ArrayHelper::map(Hotel::find()->all(), 'id', 'name'), ['prompt' => 'Select Hotel']) ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['prompt' => 'Select User']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'enquiry_at')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
