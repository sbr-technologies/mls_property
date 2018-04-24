<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\PropertyCategory;
use common\models\PropertyType;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property_category')->dropDownList([
                                                'Rent'      =>  'Rent',
                                                'Sale'      =>  'Sale',
                                                'Short Let' =>  'Short Let',
                                                'Buy'       =>  'Buy',
                                            ], ['prompt' => 'Select Property Category', 'id' => 'property_category'])->label(false) ?>

    <?php //echo $form->field($model, 'property_type_id')->dropDownList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'), ['prompt' => 'Select Property Type']) ?>
    <?php // echo $model->property_category_id;die();?>
    
    <?= $form->field($model, 'property_type_id')->dropDownList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'), ['prompt' => 'Select Property Type', 'id' => 'property_type_id'])->label(false) ?>

    <?= $form->field($model, 'budget_from')->textInput(['maxlength' => true, 'onkeypress'=>'return isNumberKey(event)']) ?>
    
    <?= $form->field($model, 'budget_to')->textInput(['maxlength' => true, 'onkeypress'=>'return isNumberKey(event)']) ?>

    <?= $form->field($model, 'no_of_bed_room')->textInput(['maxlength' => true, 'onkeypress'=>'return isNumberKey(event)']) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'locality')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
    <?php 
    if($model->schedule){
            $model->schedule = Yii::$app->formatter->asDate($model->schedule);
    }
    ?>
    <?= $form->field($model, 'schedule')->widget(DatePicker::classname(), [
                                                'options' => ['placeholder' => 'Select Date'],
                                                'pluginOptions' => [
                                                    'autoclose'=>true,
                                                    'format' => Yii::$app->params['dateFormatJs']
                                                ]
                                            ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
