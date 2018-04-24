<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;


$this->registerJsFile(
    '@web/js/feedback.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Update Testimonial';
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Edit Testimonial</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Feedback & Review</a></li>
            <li class="active">Edit Testimonial</li>
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
            <div class="manage-profile-form-sec new-property-form-sec">
                 <div class="manage-profile-tab-bar">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#feedback_info" aria-controls="general_info" role="tab" data-toggle="tab">Feedback Details</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => '','id' => 'frm_feedback_data']]); ?>
                    <div class="tab-content">
                       <div role="tabpanel" class="tab-pane active" id="feedback_info">
                           <div class="col-sm-12 form-sec">
                               <div class="row">
                                   <div class="form-group">
                                       <div class="col-sm-12">
                                            <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <div class="col-sm-12">
                                           <?= $form->field($model, 'description')->textArea(['maxlength' => true,'class'=> 'form-control']) ?>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <div class="col-sm-4">
                                           <?= $form->field($model, 'rating')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                       </div>
                                   </div>
                                  
                               </div>
                                <div class="form-group text-center">
                                    <?= Html::resetButton($model->isNewRecord ? Yii::t('app', 'Cancel') : Yii::t('app', 'Cancel'), ['class' => $model->isNewRecord ? 'btn btn-default gray-btn' : 'btn btn-primary gray-btn']) ?>
                                    <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn' : 'btn btn-primary bnt_update_feedback gray-btn']) ?>
                                </div>
                           </div> 
                       </div>
                    </div> 
                <?php ActiveForm::end(); ?>
            </div>
            <!-- Manage Profile Form -->
        </div>
    </section>
    <!-- Main content -->
</div>
<!-- End right Section ==================================================-->
