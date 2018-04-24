<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Menu;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(Menu::find()->where(['parent_id' => NULL])->active()->all(), 'id', 'name'), ['prompt' => 'Select Menu']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'id' => 'name']) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'id' => 'slug','readonly' => 'readonly']) ?>
    
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
