<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ServiceCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\PlanMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service_category_id')->dropDownList(ArrayHelper::map(ServiceCategory::find()->all(), 'id', 'name'), ['prompt' => 'Select Service Category']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'amount')->textInput() ?>
    
    <?= $form->field($model, 'amount_for_3_months')->textInput() ?>
    
    <?= $form->field($model, 'amount_for_6_months')->textInput() ?>
    
    <?= $form->field($model, 'amount_for_12_months')->textInput() ?>
    
    <?= $form->field($model, 'number_of_standard_listing')->textInput(['placeholder' => 'Leave blank for Unlimited']) ?>
    
    <?= $form->field($model, 'number_of_premium_listing')->textInput(['placeholder' => 'Leave blank for Unlimited']) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
