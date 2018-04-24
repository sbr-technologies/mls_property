<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\HolidayPackage;
use common\models\User;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageBooking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-package-booking-form">

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

                <?= $form->field($model, 'holiday_package_id')->dropDownList(ArrayHelper::map(HolidayPackage::find()->all(), 'id', 'name'), ['prompt' => 'Select Package']) ?>

                <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['prompt' => 'Select User']) ?>

                <?php echo $form->field($model, 'departureDate')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Departure Date'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => Yii::$app->params['dateTimeFormatJs'],
                    ]
                ]);?>

                <?= $form->field($model, 'departure_location')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="guest_info">
              <?php echo $this->render('_form_guest', ['model' => $model, 'holidayGuestModels' => $holidayGuestModels, 'form' => $form])?>
            </div>
        </div> 
    </div>   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php 
$tmpHolidayGuest = new \common\models\HolidayBookingGuest();
?>
<div style="display: none" class="dv_hotel_booking_guest_info_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tmpHolidayGuest, '[curTime]id')?>
        <div class="form-group">
          <?= Html::activeLabel($tmpHolidayGuest, '[curTime]first_name')?>
          <?= Html::activeTextInput($tmpHolidayGuest, '[curTime]first_name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpHolidayGuest, '[curTime]middle_name')?>
          <?= Html::activeTextInput($tmpHolidayGuest, '[curTime]middle_name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpHolidayGuest, '[curTime]last_name')?>
          <?= Html::activeTextInput($tmpHolidayGuest, '[curTime]last_name', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpHolidayGuest, '[curTime]gender')?>
          <?= Html::activeDropDownList($tmpHolidayGuest, '[curTime]gender', [$tmpHolidayGuest::GENDER_MALE => 'Male', $tmpHolidayGuest::GENDER_FEMALE => 'Female'], ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
          <?= Html::activeLabel($tmpHolidayGuest, '[curTime]age')?>
          <?= Html::activeTextInput($tmpHolidayGuest, '[curTime]age', ['class' => 'form-control'])?>
        </div>

      <div class="">
        <?= Html::activeHiddenInput($tmpHolidayGuest, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
      </div>
    </div>
</div>
