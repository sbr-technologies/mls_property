<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\HolidayPackageCategory;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-package-category-form">

    <?php $form = ActiveForm::begin(); ?>
  
    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(HolidayPackageCategory::find()->where(['parent_id' => null])->all(), 'id', 'title'), ['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>