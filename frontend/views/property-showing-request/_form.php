<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Property;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyShowingRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-showing-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['prompt' => 'Select User']) ?>

    <?= $form->field($model, 'property_id')->dropDownList(ArrayHelper::map(Property::find()->all(), 'id', 'title'), ['prompt' => 'Select Property']) ?>

    <?= $form->field($model, 'schedule')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reply')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
