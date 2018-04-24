<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\RoomType;
use common\models\HotelRoom;


/* @var $this yii\web\View */
/* @var $roomModel common\models\Hotel */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- Nav tabs -->
  
<?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
    <?= $form->field($roomModel, 'hotel_id')->hiddenInput(['maxlength' => true,'value' => $hotel_id])->label(false) ?>
    <div class="tab-content">
        <div class="hotel-form">
            <?= $form->field($roomModel, 'room_type_id')->dropDownList(ArrayHelper::map(RoomType::find()->all(), 'id', 'name'), ['prompt' => 'Select Room type','id' => 'profile_id']) ?>

            <?= $form->field($roomModel, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($roomModel, 'floor_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($roomModel, 'inclusion')->textarea(['rows' => 6]) ?>
            
            <?= $form->field($roomModel, 'amenities')->textarea(['rows' => 6]) ?>

            <?= $form->field($roomModel, 'ac')->dropDownList([$roomModel::AVAILABLE_AC => 'Yes', $roomModel::AVAILABLE_NON_AC => 'No'],['prompt' => 'Select AC Avaialblity']) ?>

            <?= $form->field($roomModel, 'status')->dropDownList([$roomModel::STATUS_ACTIVE => 'Active', $roomModel::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
        </div>
        
        <div class="form-group">
            <?= Html::submitButton($roomModel->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $roomModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
