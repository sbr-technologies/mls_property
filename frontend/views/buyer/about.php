<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\StaticPage;
use yii\helpers\ArrayHelper;
use common\models\PropertyType;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->title = 'About';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>About</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Buyer About</li>
        </ol>
    </section>
    <!-- Content Title Sec -->
    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="sucmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="failmsgdiv"></span>
            </div>
            <!-- Manage Profile Form -->
            <div class="manage-profile-form-sec">
                <div class="manage-profile-tab-bar">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about-me" aria-controls="buy" role="tab" data-toggle="tab">About Me</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about-me">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['buyer/update-about'],'options' => ['id' => 'update_about_form']]); ?>
                        <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                        <div class="col-sm-9 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'price_range')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Price Range (last 24 months)']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'duration')->dropDownList(['1 month'=>'1 month','3 months'=>'3 months', '6 months'=>'6 months','1 Year'=>'1 Year', '1 year+'=>'1 year+'],['prompt' => 'Select Experience duration','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'uses')->dropDownList(['Occupant'=>'Occupant','Rent'=>'Rent', 'Investment'=>'Investment','Others'=>'Others'],['prompt' => 'Select Use As','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'occupation')->dropDownList(['Business Owner'=>'Business Owner','Employment'=>'Employment','Others'=>'Others'],['prompt' => 'Select Occupation','class' => 'selectpicker']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'salary_income')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Price Range (last 24 months)','onkeypress'=>'']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'need_agent')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'contact_me')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'propertyTypeIds')->checkBoxList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title')) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
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