<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Advertisement;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementBanner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertisement-banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'frm_update_banner_info']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'text_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?php if($model->isNewRecord){?>  
    <?= $form->field($model, 'imageFiles[]')->fileInput(['accept' => 'image/*']) ?>
    <?php }?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
