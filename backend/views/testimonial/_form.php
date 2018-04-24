<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model common\models\Testimonial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testimonial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        echo $form->field($model, 'user_id')->widget(Select2::classname(), [
            'initValueText' => ($model->isNewRecord? '': $model->user->fullName), // set the initial display text
            'options' => ['placeholder' => 'Search for a User ...'],
//                    'disabled' => true,
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => Url::to(['user/index']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"d"}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            ],
        ]);
        ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'rating')->widget(StarRating::classname(), [
        'pluginOptions' => ['size'=>'lg']
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_APPROVED => 'Active', $model::STATUS_BLOCKED => 'Inactive'],['prompt' => 'Select Status']) ?>
                            
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
