<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;
use common\models\PhotoGallery;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'View Advertisement';
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>View Advertisement</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Advertisement Management</a></li>
            <li class="active">View Advertisement</li>
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
                        <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
                        <li role="presentation"><a href="#ad_banners" aria-controls="ad_banners" role="tab" data-toggle="tab">Banners</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general_info">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">Title :</label>
                                            <?= $model->title  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Description :</label>
                                            <?= $model->description  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Link:</label>
                                            <?= $model->link  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">No of Banner:</label>
                                            <?= $model->no_of_banner  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Profiles:</label>
                                            <?= implode('<br/>------<br/>', ArrayHelper::getColumn($model->profiles, 'title')) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="ad_banners">
                        <div class="row">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Title :</label>
                                        <?= $advBanner->title  ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Description:</label>
                                        <?= $advBanner->description  ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Text Color:</label>
                                        <?= $advBanner->text_color ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="">Uploaded Images:</label>
                                <div class="add-property-upload-images">
                                    <?= Html::img($advBanner->photo->getImageUrl(PhotoGallery::THUMBNAIL), ['width' => 60]); ?>
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
