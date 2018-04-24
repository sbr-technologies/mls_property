<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ServiceCategory;

/* @var $this yii\web\View */
/* @var $model common\models\PermissionMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permission-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'serviceCategoryIds')->checkboxList(ArrayHelper::map(ServiceCategory::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
