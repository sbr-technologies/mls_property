<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;
use common\models\User;
use common\models\HolidayPackageCategory;
use kartik\datetime\DateTimePicker;
use common\models\HolidayPackageType;

$this->title = 'View Holiday Package Itinerary';

/* @var $this yii\web\View */
/* @var $itineraryModel common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>View Holiday Package Itinerary</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Holiday Management</a></li>
            <li class="active">View Holiday Package Itinerary</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <!-- Manage Profile Form -->
            <div class="manage-profile-form-sec new-property-form-sec">
                <div class="manage-profile-tab-bar">
                    <span class="error">* fields are required</span>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#itineraryInfo" aria-controls="itineraryInfo" role="tab" data-toggle="tab">Itinerary Details</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="itineraryInfo">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Days :</label>
                                            <?= $itineraryModel->days_name  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Title :</label>
                                            <?= $itineraryModel->title  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="">Description :</label>
                                            <?= $itineraryModel->description  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Address :</label>
                                            <?= $itineraryModel->address  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">City :</label>
                                            <?= $itineraryModel->city  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">State :</label>
                                            <?= $itineraryModel->state  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Country :</label>
                                            <?= $itineraryModel->country  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php 
                                                echo $this->render('//shared/_photo-gallery', ['model' => $itineraryModel]);
                                            ?>
                                        </div>
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
