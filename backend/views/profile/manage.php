<?php 
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\helpers\Url;
use common\models\TimezoneMaster;
use kartik\date\DatePicker;


use common\models\CallingCodeMaster;
$this->title = 'Profile';
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete clearfix']]); ?>

    <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'],['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calling_code')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country']) ?>
    
    <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timezone')->dropDownList(ArrayHelper::map(TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone']) ?>
  
    <?= $form->field($model, 'gender')->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'],['prompt' => 'Select Gender']) ?>

    <?php echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => Yii::$app->params['dateFormatJs']
    ]
    ]);?>
  
    <?= $form->field($model, 'tagline')->textInput(['maxlength' => true]) ?>
    
    <?php 
        echo $this->render('//shared/_address_fields', ['model' => $model, 'form' => $form]);
    ?>
  
    <div class="form-group">
      <label class="control-label col-sm-3" for="user-zip_code">Profile Image</label>
      <div class="col-sm-9">
        <?php
        echo Html::img($model->getImageUrl($model::THUMBNAIL), [
            'class' => 'img-thumbnail',
        ]);
        ?>
      </div>

    </div>
  
    <?= $form->field($model, 'profileImage')->fileInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    

    <div class="form-group">
      <div class="col-sm-6 col-sm-push-5">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

 <?php 
//echo '<label>Password</label><br>';
//echo Editable::widget([
//    'name'=>'password', 
//    'asPopover' => true,
//    'value' => '*************',
//    'header' => 'Password',
//    'size'=>'md',
//    'formOptions' => ['action' => ['/proyecto/editable-proyecto']],
//    'options' => [
//        'class'=>'form-control', 
//        'placeholder'=>'Enter your new password',
//        ]
//]);
 
echo '<div class="row" style="margin-top:15px;"><div class="col-sm-6 col-sm-push-2"><div class="form-group text-center"><label>Change Password</label><br>'; 
$editable = Editable::begin([
    'model'=>$model,
    'attribute'=>'rawPassword',
    'asPopover' => true,
    'size'=>'md',
    'preHeader' => '<i class="glyphicon glyphicon-edit"></i> Change ',
    'header' => 'Password',
    'inputType' => Editable::INPUT_PASSWORD,
    'formOptions' => ['action' => ['/profile/update-password']],
    'displayValue' => '************',
    'options'=>['placeholder'=>'Enter new password']
]);
$form = $editable->getForm();
$editable->afterInput = 
    $form->field($model, 'passwordRepeat')->passwordInput(['placeholder'=>'Re-type password'])->label(false) . "\n";
Editable::end();
echo '</div></div></div>';
?>
</div>
