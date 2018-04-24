<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Hotel;
use common\models\User;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\HotelBooking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hotel-booking-form">

    <?php $form = ActiveForm::begin(); ?>
  
        <div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
      <li role="presentation"><a href="#guest_info" aria-controls="guest_info" role="tab" data-toggle="tab">Guest Info</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general_info">

    <?= $form->field($model, 'hotel_id')->dropDownList(ArrayHelper::map(Hotel::find()->all(), 'id', 'name'), ['prompt' => 'Select Hotel']) ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['prompt' => 'Select User']) ?>

    <?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'checkIn')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'Check In'],
	'pluginOptions' => [
            'autoclose' => true,
            'format' => Yii::$app->params['dateTimeFormatJs'],
	]
    ]);?>

    <?php echo $form->field($model, 'checkOut')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'Check Out'],
	'pluginOptions' => [
            'autoclose' => true,
            'format' => Yii::$app->params['dateTimeFormatJs'],
	]
    ]);?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    </div>
      <div role="tabpanel" class="tab-pane" id="guest_info">
        <?php echo $this->render('_form_guest', ['model' => $model, 'guestModels' => $guestModels, 'form' => $form])?>
      </div>
    </div> 
    </div>    
          
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$tmpGuest = new common\models\HotelBookingGuest();
?>
<div style="display: none" class="dv_hotel_booking_guest_info_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tmpGuest, '[curTime]id')?>
        <div class="form-group">
          <?= Html::activeLabel($tmpGuest, '[curTime]first_name')?>
          <?= Html::activeTextInput($tmpGuest, '[curTime]first_name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpGuest, '[curTime]middle_name')?>
          <?= Html::activeTextInput($tmpGuest, '[curTime]middle_name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpGuest, '[curTime]last_name')?>
          <?= Html::activeTextInput($tmpGuest, '[curTime]last_name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpGuest, '[curTime]gender')?>
          <?= Html::activeDropDownList($tmpGuest, '[curTime]gender', [$tmpGuest::GENDER_MALE => 'Male', $tmpGuest::GENDER_FEMALE => 'Female'], ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpGuest, '[curTime]age')?>
          <?= Html::activeTextInput($tmpGuest, '[curTime]age', ['class' => 'form-control'])?>
        </div>

      <div class="">
        <?= Html::activeHiddenInput($tmpGuest, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
      </div>
    </div>
</div>