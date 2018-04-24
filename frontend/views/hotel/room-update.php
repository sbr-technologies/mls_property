<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;
use common\models\User;
use common\models\RoomType;


$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->registerJsFile(
    '@web/js/hotel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->title = 'Update Room';

/* @var $this yii\web\View */
/* @var $roomModel common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Update Room</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Hotel Management</a></li>
            <li class="active">Update Room</li>
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
                    <span class="error">* fields are required</span>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#roomInfo" aria-controls="property" role="tab" data-toggle="tab">Room Details</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => '','id' => 'frm_capture_room_data']]); ?>
                    <?= $form->field($roomModel, 'hotel_id')->hiddenInput(['maxlength' => true,'value' => $hotel_id])->label(false) ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="hotelInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($roomModel, 'room_type_id')->dropDownList(ArrayHelper::map(RoomType::find()->all(), 'id', 'name'), ['prompt' => 'Select Room type','id' => 'room_type_id', 'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($roomModel, 'name')->textInput(['maxlength' => true, 'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($roomModel, 'floor_name')->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($roomModel, 'ac')->dropDownList([$roomModel::AVAILABLE_AC => 'Yes', $roomModel::AVAILABLE_NON_AC => 'No'],['prompt' => 'Select AC Avaialblity', 'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($roomModel, 'status')->dropDownList([$roomModel::STATUS_ACTIVE => 'Active', $roomModel::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status', 'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($roomModel, 'inclusion')->textarea(['rows' => 6, 'class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($roomModel, 'amenities')->textarea(['rows' => 6, 'class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center">
                            <?= Html::resetButton($roomModel->isNewRecord ? Yii::t('app', 'Cancel') : Yii::t('app', 'Cancel'), ['class' => 'btn btn-primary gray-btn', 'onclick' => 'parent.history.back();']) ?>
                            <?= Html::button($roomModel->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $roomModel->isNewRecord ? 'btn btn-default red-btn bnt_save_room' : 'btn btn-primary gray-btn bnt_update_room']) ?>
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
