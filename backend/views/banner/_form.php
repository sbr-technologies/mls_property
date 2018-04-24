<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\BannerType;
use yii\helpers\ArrayHelper;
use common\models\Property;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(BannerType::find()->active()->all(), 'id', 'title'), ['prompt' => 'Select Banner type']) ?>
    
    <?= $form->field($model, 'property_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Property::find()->active()->all(), 'id', 'title'),
        'options' => ['placeholder' => 'Select a property',],
        'pluginOptions' => [],
    ])?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'text_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
    <?php if($model->isNewRecord){?>
        <?= $form->field($model, 'imageFiles[]')->fileInput(['accept' => 'image/*']) ?>
    <?php }?>
    <?php 
        if(!$model->isNewRecord){
            echo $this->render('//shared/_photo-gallery', ['model' => $model, 'single' => true]);
        }
    ?>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
