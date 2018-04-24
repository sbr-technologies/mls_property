<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\PaymentTypeMaster;
use common\models\ServiceCategory;

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
            <!--<li role="presentation"><a href="#service_categories" aria-controls="service_categories" role="tab" data-toggle="tab">Service Categories</a></li>-->
        </ul>    
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
                <?php 
                    echo $this->render('//shared/_user-general-info-form', ['model' => $model, 'form' => $form, 'userType' => 'HotelOwner']);
                ?>

                <?= $form->field($model, 'payment_type_id')->dropDownList(ArrayHelper::map(PaymentTypeMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Payment Type']) ?>

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
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
