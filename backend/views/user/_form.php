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

    <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
  <!--<input type="text" name="country" class="country" />-->
    <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->all(), 'id', 'title'), ['prompt' => 'Select User type']) ?>

    <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'],['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calling_code')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country']) ?>
    
    <?= $form->field($model, 'workedWiths')->checkBoxList(['buyer' => 'buyer','seller' => 'seller']) ?>
    
    <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'],['prompt' => 'Select Gender']) ?>

    <?= $form->field($model, 'dob')->textInput() ?>
  
    <?= $form->field($model, 'tagline')->textInput(['maxlength' => true]) ?>
    
    <?php 
        echo $this->render('//shared/_address_fields', ['model' => $model, 'form' => $form]);
    ?>
  
    <?php 
    echo Html::img($model->getImageUrl($model::THUMBNAIL), [
      'class'=>'img-thumbnail', 
    ]);
    ?>
  
    <?= $form->field($model, 'profileImage')->fileInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
