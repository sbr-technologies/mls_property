<?php
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use yii\helpers\Html;
use common\models\TimezoneMaster;
use kartik\date\DatePicker;

?>
<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'],['prompt' => 'Select Status']) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    </div>
</div>


<?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => $model->isNewRecord?false:true]) ?>

<?php if($userType == 'Buyer'){
    echo $form->field($model, 'buyerID')->textInput(['maxlength' => true,'disabled' => true]);
}elseif($userType == 'Seller'){
    echo $form->field($model, 'sellerID')->textInput(['maxlength' => true,'disabled' => true]);
}elseif($userType == 'Agent'){
    echo $form->field($model, 'agentID')->textInput(['maxlength' => true,'disabled' => true]);
}elseif($userType == 'HotelOwner'){
    echo $form->field($model, 'hotelOwnerID')->textInput(['maxlength' => true,'disabled' => true]);
}?>
<?php // echo $form->field($model, 'workedWiths')->checkBoxList(['buyer' => 'buyer','seller' => 'seller']) ?>

<?= $form->field($model, 'gender')->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'],['prompt' => 'Select Gender']) ?>

<?php echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => Yii::$app->params['dateFormatJs']
    ]
]);?>
<?php
if ($model->isNewRecord) {
    $model->timezone = 'Africa/Lagos';
}
?>
<?= $form->field($model, 'timezone')->dropDownList(ArrayHelper::map(TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone']) ?>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'], ['prompt' => 'Select', 'class' => 'form-control user-occupation']) ?>
    </div>
    <div class="col-sm-6 user-other-ccupation-div" style="display:none;">
        <?= $form->field($model, 'occupation_other')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
    </div>
</div>

<?php 
    echo $this->render('//shared/_phone_fields', ['model' => $model, 'form' => $form]);
?>

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

<?php
$js = "$(function(){
    $('.user-occupation').on('change', function(){
        if($(this).val() == 'Other'){
            $('.user-other-ccupation-div').show();
        }else{
            $('.user-other-ccupation-div').hide().find('input').val('');
        }
    });
    });";

$this->registerJs($js, View::POS_END);