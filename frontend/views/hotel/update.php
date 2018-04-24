<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Url;
use common\models\User;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/hotel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->title = 'Edit Hotel';

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Edit Hotel</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Hotel Management</a></li>
            <li class="active">Edit Hotel</li>
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
                        <li role="presentation" class="active"><a href="#hotelInfo" aria-controls="property" role="tab" data-toggle="tab">Hotel Details</a></li>
                        <li role="presentation"><a href="#hotelImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Hotel Image</a></li>
                        <li role="presentation"><a href="#metaTag" aria-controls="settings" role="tab" data-toggle="tab">Meta Tag</a></li>
                        <li role="presentation"><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Hotel Facility</a></li>
                        <li role="presentation"><a href="#roomFacility" aria-controls="facility" role="tab" data-toggle="tab">Room Facility</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete','id' => 'frm_capture_hotel_data']]); ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="hotelInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'tagline')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'days_no')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'night_no')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <?= $form->field($model, 'description')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'estd')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5>Hotel Location:</h5>
                                    <div class="form-sec-box">
                                        <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model])?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="hotelImageInfo">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                                    <div class="add-property-upload-images">
                                        <?php
                                            echo $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true]);
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
                                                <?= $form->field($metaTagModel, 'page_title')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                            </div>

                                            <div class="col-sm-6">
                                                <?= $form->field($metaTagModel, 'keywords')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($metaTagModel, 'description')->textarea(['class'=>'small-height-textarea', 'style' => 'resize:none;']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="facility">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Hotel Facility Information:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php
                                            if(isset($facilityModel) && is_array($facilityModel) && count($facilityModel) > 0){
                                                foreach($facilityModel as $facility){
                                                ?>
                                                    <div class="item new">
                                                        <div class="form-group col-sm-10">
                                                            <div class="row">
                                                                <?= Html::activeHiddenInput($facility, '[curTime]id')?>
                                                                <div class="form-group col-sm-12">
                                                                  <?= Html::activeLabel($facility, '[curTime]title')?>
                                                                  <?= Html::activeTextInput($facility, '[curTime]title', ['class' => 'form-control'])?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-2">
                                                            <?= Html::activeHiddenInput($facility, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
                                                            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                                                        </div>
                                                    </div>
                                                <?php
                                                }         
                                            }
                                            $tempfac    = new \common\models\HotelFacility();
                                            ?>
                                            <div class="row property_facility_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group text-center">
                                                <button name="" type="button" class="btn_add_property_facility_info btn btn-default add-landmark-btn"><span>+</span> Add New Hotel Facility</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane" id="roomFacility">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Room Facility Information:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php
                                            if(isset($facilityRoomModel) && is_array($facilityRoomModel) && count($facilityRoomModel) > 0){
                                                foreach($facilityRoomModel as $room){
                                                ?>
                                                    <div class="item new">
                                                        <div class="form-group col-sm-11">
                                                            <div class="row">
                                                                <?= Html::activeHiddenInput($room, '[curTime]id')?>

                                                                <div class="form-group col-sm-7">
                                                                  <?= Html::activeLabel($room, '[curTime]title')?>
                                                                  <?= Html::activeTextInput($room, '[curTime]title', ['class' => 'form-control'])?>
                                                                </div>

                                                                <div class="form-group col-sm-5">
                                                                  <?= Html::activeLabel($room, '[curTime]description')?>
                                                                  <?= Html::activeTextarea($room, '[curTime]description', ['class' => 'form-control','rows'=> '3','style' => 'resize:none;'])?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-1">
                                                          <?= Html::activeHiddenInput($room, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
                                                          <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                                                        </div>
                                                    </div>
                                                <?php
                                                }         
                                            }
                                            $tempRoomfac    = new \common\models\RoomFacility();
                                            ?>
                                            <div class="row property_room_facility_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group text-center">
                                                <button name="" type="button" class="btn_add_property_room_facility_info btn btn-default add-landmark-btn"><span>+</span> Add New Room Facility</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group text-center">
                            <?= Html::a(Yii::t('app', 'Cancel'),['hotel/list'],['class' => $model->isNewRecord ? 'btn btn-default gray-btn' : 'btn btn-primary gray-btn']) ?>
                            <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn' : 'btn btn-primary bnt_update_hotel gray-btn']) ?>
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

<?php
$tempfac        = new \common\models\HotelFacility();
$tempRoomfac    = new \common\models\RoomFacility();
?>

<div style="display: none" class="dv_property_facility_block_template">
    <div class="item new">
        <div class="form-group col-sm-10">
            <div class="row">
                <?= Html::activeHiddenInput($tempfac, '[curTime]id')?>
                <div class="form-group col-sm-12">
                  <?= Html::activeLabel($tempfac, '[curTime]title')?>
                  <?= Html::activeTextInput($tempfac, '[curTime]title', ['class' => 'form-control'])?>
                </div>
            </div>
        </div>
        
        <div class="form-group col-sm-2">
            <?= Html::activeHiddenInput($tempfac, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

<div style="display: none" class="dv_property_room_facility_block_template">
    <div class="item new">
        <div class="form-group col-sm-11">
            <div class="row">
                <?= Html::activeHiddenInput($tempRoomfac, '[curTime]id')?>
        
                <div class="form-group col-sm-7">
                  <?= Html::activeLabel($tempRoomfac, '[curTime]title')?>
                  <?= Html::activeTextInput($tempRoomfac, '[curTime]title', ['class' => 'form-control'])?>
                </div>

                <div class="form-group col-sm-5">
                  <?= Html::activeLabel($tempRoomfac, '[curTime]description')?>
                  <?= Html::activeTextarea($tempRoomfac, '[curTime]description', ['class' => 'form-control','rows'=> '3','style' => 'resize:none;'])?>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-1">
          <?= Html::activeHiddenInput($tempRoomfac, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
          <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>