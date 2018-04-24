<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\User;
use common\models\Profile;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Hotel */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#hotelInfo" aria-controls="property" role="tab" data-toggle="tab">Hotel Details</a></li>
    <li role="presentation"><a href="#hotelImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Hotel Image</a></li>
    <li role="presentation"><a href="#metaTag" aria-controls="settings" role="tab" data-toggle="tab">Meta Tag</a></li>
    <li role="presentation"><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Hotel Facility</a></li>
    <li role="presentation"><a href="#roomFacility" aria-controls="facility" role="tab" data-toggle="tab">Room Facility</a></li>
  </ul>
<?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete']]); ?>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="hotelInfo">
            <div class="hotel-form">
                
                <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['id' => [5, 6]])->all(), 'id', 'title'), ['prompt' => 'Select User type','id' => 'profile_id']) ?>
                
                <?php
                echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'initValueText' => ($model->isNewRecord? '': $model->user->fullName), // set the initial display text
                    'options' => ['placeholder' => 'Search for a User ...'],
//                    'disabled' => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['user/index']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term, type:"d", profile_id:$("#profile_id").val()}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],
                ]);
                ?>
                
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'tagline')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($model, 'days_no')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($model, 'night_no')->textInput(['maxlength' => true]) ?>
                <?php 
                    echo $this->render('//shared/_address_fields', ['model' => $model, 'form' => $form]);
                ?>

                <?= $form->field($model, 'estd')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="hotelImageInfo">
            <div class="hotel-form">

                <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

                <?php 
                    echo $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true]);
                ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="metaTag">
            <?php echo $this->render('//shared/_meta-form', ['metaTagModel' => $metaTagModel, 'form' => $form])?>
        </div>
        <div role="tabpanel" class="tab-pane" id="facility">
            <?php echo $this->render('_form_facility_info', ['model' => $model, 'facilityModel' => $facilityModel, 'form' => $form])?>
        </div>
        <div role="tabpanel" class="tab-pane" id="roomFacility">
            <?php echo $this->render('_form_room_facility_info', ['model' => $model, 'facilityRoomModel' => $facilityRoomModel, 'form' => $form])?>
        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php
$tempfac    = new \common\models\HotelFacility();
$tempRoomfac    = new \common\models\RoomFacility();
?>
<div style="display: none" class="dv_property_facility_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempfac, '[curTime]id')?>
        
        <div class="form-group">
          <?= Html::activeLabel($tempfac, '[curTime]title')?>
          <?= Html::activeTextInput($tempfac, '[curTime]title', ['class' => 'form-control'])?>
        </div>
        
      <div class="">
        <?= Html::activeHiddenInput($tempfac, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
      </div>
      
    </div>
</div>

<div style="display: none" class="dv_property_room_facility_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempRoomfac, '[curTime]id')?>
        
        <div class="form-group">
          <?= Html::activeLabel($tempRoomfac, '[curTime]title')?>
          <?= Html::activeTextInput($tempRoomfac, '[curTime]title', ['class' => 'form-control'])?>
        </div>
        
        <div class="form-group">
          <?= Html::activeLabel($tempRoomfac, '[curTime]description')?>
          <?= Html::activeTextarea($tempRoomfac, '[curTime]description', ['class' => 'form-control'])?>
        </div>
        
      <div class="">
        <?= Html::activeHiddenInput($tempRoomfac, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
      </div>
      
    </div>
</div>