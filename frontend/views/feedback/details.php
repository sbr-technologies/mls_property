<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'View Testimonial';
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>View Testimonial</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Feedback & Review</a></li>
            <li class="active">View Testimonial</li>
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
                 <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="feedback_info">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="">Title :</label>
                                        <?= $model->title  ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="">Description:</label>
                                        <?= $model->description  ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="">Rating:</label>
                                        <?= $model->rating ?>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                 </div> 
            </div>
            <!-- Manage Profile Form -->
        </div>
    </section>
    <!-- Main content -->
</div>
<!-- End right Section ==================================================-->
