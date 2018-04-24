<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'View Hotel';
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>View Hotel</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Hotel Management</a></li>
            <li class="active">View Hotel</li>
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
                        <li role="presentation" class="active"><a href="#hotelInfo" aria-controls="property" role="tab" data-toggle="tab">Hotel Details</a></li>
                        <li role="presentation"><a href="#hotelImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Hotel Image</a></li>
                        <li role="presentation"><a href="#metaTag" aria-controls="settings" role="tab" data-toggle="tab">Meta Tag</a></li>
                        <li role="presentation"><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Hotel Facility</a></li>
                        <li role="presentation"><a href="#roomFacility" aria-controls="facility" role="tab" data-toggle="tab">Room Facility</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="hotelInfo">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Name :</label>
                                            <?= $model->name  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Tag line :</label>
                                            <?= $model->tagline  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">Price:</label>
                                            <?= $model->price  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">No of Days:</label>
                                            <?= $model->days_no  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">No of Night:</label>
                                            <?= $model->night_no  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <label for="">Description:</label>
                                            <?= $model->description  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">Established:</label>
                                            <?= $model->estd  ?>
                                        </div>
                                    </div>
                                </div>


                                <h5>Hotel Location:</h5>
                                <div class="form-group form-sec-box">
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="">Country:</label>
                                            <?= $model->country  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">State:</label>
                                            <?= $model->state  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Town:</label>
                                            <?= $model->town  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Area:</label>
                                            <?= $model->area  ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="">Street Address:</label>
                                            <?= $model->street_address  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Street #:</label>
                                            <?= $model->street_number  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Apartment or Unit #:</label>
                                            <?= $model->appartment_unit  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Sub Area:</label>
                                            <?= $model->sub_area  ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="">Zip Code:</label>
                                            <?= $model->zip_code  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Local Govt. Area:</label>
                                            <?= $model->local_govt_area  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Urban Town Area:</label>
                                            <?= $model->urban_town_area  ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">District:</label>
                                            <?= $model->district  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="hotelImageInfo">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="">Uploaded Images:</label>
                                <div class="add-property-upload-images">
                                    <?php 
                                        echo $this->render('//shared/_photo-gallery', ['model' => $model]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="metaTag">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Page Title:</label>
                                            <?= $metaTagModel->page_title  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Key Words:</label>
                                            <?= $metaTagModel->keywords  ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Description:</label>
                                    <?= $metaTagModel->description  ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="facility">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Hotel Facility Information:</h5>
                                <?php
                                if(isset($facilityModel) && is_array($facilityModel) && count($facilityModel) > 0){
                                ?>
                                <div class="form-sec-box">
                                    <div class="row">
                                        <?php
                                            foreach($facilityModel as $facility){
                                        ?>
                                        <div class="form-group col-sm-6">
                                            <?= $facility->title  ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                }else{
                                ?>
                                    <div class="alert alert-info margine10top">
                                        <i class="fa fa-info"></i>					
                                        No Record found.
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="roomFacility">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Hotel Facility Information:</h5>
                                <?php
                                if(isset($facilityRoomModel) && is_array($facilityRoomModel) && count($facilityRoomModel) > 0){
                                ?>
                                <div class="form-sec-box">
                                    <div class="row">
                                        <?php
                                            foreach($facilityRoomModel as $room){
                                        ?>
                                        <div class="form-group col-sm-6">
                                            <?= $room->title ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <?= $room->description ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                }else{
                                ?>
                                    <div class="alert alert-info margine10top">
                                        <i class="fa fa-info"></i>					
                                        No Record found.
                                    </div>
                                <?php
                                }
                                ?>
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
