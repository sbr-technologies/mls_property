<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use common\models\PropertyCategory;
use common\models\PropertyType;
use common\models\Profile;


$this->title = 'Request a Property';
$this->params['breadcrumbs'][] = $this->title;
?>

<section>
    <div class="property-request-top-part">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Post a Property Request</h2>
                    <p>Complete the form below and we'll get our Estate Agents on your case!</p>
                    <p><strong>All data in the form will be displayed on our website.</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Photo Upload Sec -->
                    <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                        <span class="sucmsgdiv"></span>
                    </div>
                    <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                        <span class="failmsgdiv"></span>
                    </div>
                    <div class="property-request-sec">
                        <?php $form = ActiveForm::begin(['id' => 'property_request_form']); ?>
                            <div class="property-request-box">
                                <h3>Property Details</h3>
                                <div class="property-request-box-inner">
                                    <div class="form-group text-center">
                                        <div class="top-select-part">
                                            <div class="top-select-highlight"><i class="fa fa-home" aria-hidden="true"></i> Looking to:</div>
                                            <?= $form->field($model, 'property_category')->dropDownList($propertyCategory, ['prompt' => 'Select Property Category', 'id' => 'property_category'])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-file-code-o" aria-hidden="true"></i> Type:</label>
                                            <?= $form->field($model, 'property_type_id')->dropDownList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'), ['prompt' => 'Select Property Type', 'id' => 'property_type_id'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-bed" aria-hidden="true"></i> No. of Bedrooms:</label>
                                            <?= $form->field($model, 'no_of_bed_room')->textInput(['maxlength' => true,'class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-money" aria-hidden="true"></i> Budget From:</label>
                                            <?= $form->field($model, 'budget_from')->textInput(['maxlength' => true,'class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)'])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-money" aria-hidden="true"></i> Budget To:</label>
                                            <?= $form->field($model, 'budget_to')->textInput(['maxlength' => true,'class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-map" aria-hidden="true"></i> State:</label>
                                            <?= $form->field($model, 'state')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-map-marker" aria-hidden="true"></i> Town (e.g. Abuja):</label>
                                            <?= $form->field($model, 'locality')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-compass" aria-hidden="true"></i> Area :</label>
                                            <?= $form->field($model, 'area')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-comments-o" aria-hidden="true"></i> Comments:</label>
                                            <?= $form->field($model, 'comment')->textarea(['style' => 'resize:none;'])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="property-request-box">
                                <h3>Requested By</h3>
                                <div class="property-request-box-inner">
                                    <div class="form-group text-center">
                                        <div class="top-select-part">
                                            <div class="top-select-highlight"><i class="fa fa-user" aria-hidden="true"></i> I am :</div>
                                            <?= $form->field($model, 'user_id')->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $userModel->id])->label(false) ?>
                                            <?= $form->field($userModel, 'profile_id')->radioList(ArrayHelper::map(Profile::find()->where(['id' => [3, 4, 5]])->all(), 'id', 'title'),['id' => 'RadioGroup1_0'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-user-circle-o" aria-hidden="true"></i> Name :</label>
                                            <?= $form->field($userModel, 'first_name')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-envelope" aria-hidden="true"></i> Email:</label>
                                            <?= $form->field($userModel, 'email')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-phone" aria-hidden="true"></i> Phone:</label>
                                            <?= $form->field($userModel, 'mobile1')->textInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <?= $form->field($model, 'verifyCode')->widget(Captcha::classname(), [
                                            'captchaAction' => 'site/captcha',
                                        ]) ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><i class="fa fa-calendar-o" aria-hidden="true"></i> How soon ? </label>
                                            <?php echo $form->field($model, 'scheduleDate')->widget(DatePicker::classname(), [
                                                'options' => ['placeholder' => 'Enter Schedule date ...'],
                                                'pluginOptions' => [
                                                    'autoclose'=>true,
                                                    'format' => Yii::$app->params['dateFormatJs']
                                                ]
                                            ])->label(false);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send Request') : Yii::t('app', 'Send Request'), ['class' => $model->isNewRecord ? 'btn btn-primary btn-lg red-btn' : 'btn btn-primary btn-lg red-btn']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>