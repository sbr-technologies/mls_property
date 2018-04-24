<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
      <li role="presentation"><a href="#criteria_worksheet" aria-controls="criteria_worksheet" role="tab" data-toggle="tab">Criteria Worksheet</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="general_info">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>

        <?php 
            echo $this->render('//shared/_user-general-info-form', ['model' => $model, 'form' => $form, 'userType' => 'Buyer']);
        ?>
        <?= $form->field($model, 'intrest_in')->dropDownList(['Buying a Property' => 'Buying a Property', 'Rent a Property' => 'Rent a Property', 'Both' => 'Both'],['prompt' => 'Interest in']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
        <div role="tabpanel" class="tab-pane active" id="criteria_worksheet">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>

            <?php 
                echo $this->render('_criteria-worksheet', ['model' => $worksheetModel, 'form' => $form]);
            ?>
            <div class="form-group text-center">
                <?= Html::submitButton($worksheetModel->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $worksheetModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
