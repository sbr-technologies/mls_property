
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\Agency;
use kartik\date\DatePicker;
use common\models\Team;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'Agency Profile';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Manage Profile</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Manage Profile</li>
        </ol>
    </section>
    <!-- Content Title Sec -->
    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <!-- Photo Upload Sec -->
            <?php echo $this->render('//shared/_my_profile_top.php')?>
            <!-- Photo Upload Sec -->
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">�</span></button>
                <span class="sucmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">�</span></button>
                <span class="failmsgdiv"></span>
            </div>
            <!-- Manage Profile Form -->
            <div class="manage-profile-form-sec">
                <div class="manage-profile-tab-bar">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about_agency_tab" aria-controls="about_agency_tab" role="tab" data-toggle="tab">About Agency</a></li>
                        <li role="presentation"><a href="#about_broker_tab" aria-controls="about_broker_tab" role="tab" data-toggle="tab">About Broker</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about_agency_tab">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['agency/manage-agency'],'options' => ['id' => 'update_agency_form']]); ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Agency Name']) ?>

                            <?= $form->field($model, 'tagline')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Tag Line']) ?>

                            <?= $form->field($model, 'agencyID')->textInput(['maxlength' => true,'class'=>'form-control', 'placeholder' => 'Auto generated', 'disabled' => true]) ?>

                            <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true,'class'=>'form-control', 'placeholder' => 'Enter Owner Name']) ?>
                                
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'class'=>'form-control', 'placeholder' => 'Enter Owner Name']) ?>
                                
                            <?= $form->field($model, 'web_address')->textInput(['maxlength' => true,'class'=>'form-control', 'placeholder' => 'Enter Web Address']) ?>
                                
                            <?= $form->field($model, 'about')->textarea(['maxlength' => true,'class'=>'form-control txt_about readonlyCls','placeholder'=>'Enter About Agency','rows' => 3,'style'=>'resize:none;'])?>
                                
                            <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $model])?>
                                
                            <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model])?>
                                
                            <?= $this->render('//shared/_social_link_fields', ['socialMedia' => $socialMedia])?>
                                
                            <?= $form->field($model, 'imageFiles')->fileInput(['multiple' => false,'calss'=> 'form-control txt_agency_photo readonlyCls', 'accept' => 'image/*']) ?>
                            <div class="add-property-upload-images" id="uploadImageDispaly">
                                <?php
                                    echo $this->render('//shared/_photo-gallery', ['model' => $model, 'size' => common\models\PhotoGallery::MEDIUM]);
                                ?>
                            </div>
                            <div class="add-upload-images">
                                <img src="" style="display:none;" class="agency_image" height="150px"/>
                            </div>
                            <div class="form-group">
                                <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary bnt_save_agency' : 'btn btn-success bnt_save_agency']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="about_broker_tab">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['agency/update-profile'],'options' => ['id' => 'update_broker_form']]); ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <?= $form->field($brokerModel, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'], ['prompt' => 'Select'], ['class' => 'selectpicker']) ?>
                            </div>

                            <div class="col-sm-3">
                                <?= $form->field($brokerModel, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter First Name']) ?>
                            </div>

                            <div class="col-sm-3">
                                <?= $form->field($brokerModel, 'middle_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Middle Name']) ?>
                            </div>

                            <div class="col-sm-3">
                                <?= $form->field($brokerModel, 'last_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Last Name']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                $brokerIsAgent = $brokerModel->broker_is_agent;
                                if ($brokerModel->broker_is_agent === null) {
                                    $brokerModel->broker_is_agent = 1;
                                }
                                ?>
                                <?= $form->field($brokerModel, 'broker_is_agent')->checkbox() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'short_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Short Name']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'email')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                            </div>
                        </div>
                        <?php if ($brokerIsAgent == 1) { ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $form->field($brokerModel, 'agentID')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($brokerModel, 'gender')->dropDownList([$brokerModel::GENDER_MALE => 'Male', $brokerModel::GENDER_FEMALE => 'Female'], ['prompt' => 'Select Gender']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                echo $form->field($brokerModel, 'birthday')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'DD/MM/YYYY'],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => Yii::$app->params['dateFormatJs']
                                    ]
                                ]);
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                if ($brokerModel->isNewRecord) {
                                    $brokerModel->timezone = 'Africa/Lagos';
                                }
                                ?>
                                <?= $form->field($brokerModel, 'timezone')->dropDownList(ArrayHelper::map(\common\models\TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'], ['prompt' => 'Select'], ['class' => 'selectpicker']) ?>
                            </div>
                            <div class="col-sm-6" style="display:none;" id="otherOccupationDiv">
                                <?= $form->field($brokerModel, 'occupation_other')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                            </div>
                        </div>
                        <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $brokerModel])?>
                        
                        <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $brokerModel])?>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'exp_year')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Years of Experience', 'onkeypress' => 'return isNumberKeyWithDot(event)']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'price_range')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Activity Range (e.g 1-100)', 'onkeypress' => 'return isNumberWithHyphen(event)']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'specialization')->textarea(['style' => 'resize:none;', 'rows' => 5]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($brokerModel, 'area_served')->textarea(['style' => 'resize:none;', 'rows' => 5]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($brokerModel, 'about')->textarea(['style' => 'resize:none;', 'rows' => 3]) ?>
                            </div>
                        </div>
                        
                        <?= $this->render('//shared/_social_link_fields', ['socialMedia' => $brokerSocialMedia])?>
                        
                        <div class="form-group">
                            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <!-- Manage Profile Form -->
        </div>
    </section>
    
    <!-- Main content -->
</div>
<?php
$js = "$(function(){
    $('#agent-occupation').on('change', function(){
        if($(this).val() == 'Other'){
            $('#otherOccupationDiv').show();
        }else{
            $('#otherOccupationDiv').hide().find('input').val('');
        }
    });
    });";

$this->registerJs($js, View::POS_END);