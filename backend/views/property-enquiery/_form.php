<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mdm\admin\models\User;
use common\models\Property;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyEnquiery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-enquiery-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<label>-->
        <?= Html::tag('h2', $model->property->formattedAddress. ' ( '. $model->property->title. ' )')?>
    <!--</label>-->
    <?php
//    echo $form->field($model, 'model_id')->widget(Select2::classname(), [
//        'initValueText' => ($model->isNewRecord? '': $model->property->title), // set the initial display text
//        'options' => ['placeholder' => 'Search for a Property ...'],
////                    'disabled' => true,
//        'pluginOptions' => [
//            'allowClear' => true,
//            'minimumInputLength' => 3,
//            'language' => [
//                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
//            ],
//            'ajax' => [
//                'url' => Url::to(['property/index-json']),
//                'dataType' => 'json',
//                'data' => new JsExpression('function(params) { return {q:params.term, type:"d"}; }')
//            ],
//            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
//            'templateResult' => new JsExpression('function(city) { return city.text; }'),
//            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
//        ],
//    ]);
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'onkeypress'=>'return isNumberKey(event)','maxlength' => '10']) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'assign_to')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['prompt' => 'Select User']) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive',$model::STATUS_PENDING => 'Pending'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
