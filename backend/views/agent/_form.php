<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\Agency;
use common\models\ServiceCategory;
use common\models\PaymentTypeMaster;
use common\models\Team;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
          <li role="presentation"><a href="#service_categories" aria-controls="service_categories" role="tab" data-toggle="tab">Service Categories</a></li>
          <?php
            if(!$model->isNewRecord){
            ?>
            <!--<li role="presentation"><a href="#associated_sellers" aria-controls="associated_sellers" role="tab" data-toggle="tab">Associated Sellers</a></li>-->
         <?php
            }
         ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
                <?php
                echo $form->field($model, 'agency_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Agency::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select Agency'],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
                ?>
                <?php 
                    echo $this->render('//shared/_user-general-info-form', ['model' => $model, 'form' => $form, 'userType' => 'Agent']);
                ?>
                <?php if(!$model->isNewRecord){?>
                <?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map(Team::find()->where(['agency_id' => $model->agency_id])->active()->all(), 'id', 'name'), ['prompt' => 'Select Team']) ?>
                <?php }?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="service_categories">
                <?= $form->field($model, 'services')->checkBoxList(ArrayHelper::map(ServiceCategory::find()->all(), 'id', 'name')) ?>
                
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php
            if(!$model->isNewRecord){
            ?>
<!--            <div role="tabpanel" class="tab-pane" id="associated_sellers">
                <?php 
                    echo $this->render('_form-seller-association', ['model' => $model,'sellerDataProvider' => $sellerDataProvider, 'form' => $form]);
                ?>
            </div>-->
            <?php
            }
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
