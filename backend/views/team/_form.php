<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Agency;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Team */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="team-form">
    <?php $form = ActiveForm::begin(); ?>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#team_info" aria-controls="general_info" role="tab" data-toggle="tab">Team Info</a></li>
            <?php
              if(!$model->isNewRecord){
              ?>
              <!--<li role="presentation"><a href="#associated_agency" aria-controls="associated_sellers" role="tab" data-toggle="tab">Associated Agency</a></li>-->
           <?php
              }
           ?>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="team_info">
                <?php
                echo $form->field($model, 'agency_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Agency::find()->active()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select an agency'],
                    'pluginOptions' => [
//                        'allowClear' => true
                    ],
                ]);
                ?>
                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
