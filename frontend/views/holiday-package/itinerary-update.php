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

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/holidaypackage.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

for ($dd = 1; $dd <= 30; $dd++){
    $daysNameArr[$dd." Day"] = $dd." Day";
}
$this->title = 'Update Holiday Package Itinerary';

/* @var $this yii\web\View */
/* @var $itineraryModel common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Update Holiday Package Itinerary</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Holiday Management</a></li>
            <li class="active">Update Holiday Package Itinerary</li>
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
                        <li role="presentation" class="active"><a href="#itineraryInfo" aria-controls="itineraryInfo" role="tab" data-toggle="tab">Itinerary Details</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete','id' => 'frm_capture_itinerary_data']]); ?>
                <?= $form->field($itineraryModel, 'holiday_package_id')->hiddenInput(['maxlength' => true,'value' => $holiday_package_id])->label(false) ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="itineraryInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'days_name')->dropDownList($daysNameArr,['prompt'=>'Select']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'title')->textInput(['maxlength' => true]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'description')->textarea(['rows' => 6]) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'location')->textInput(['maxlength' => true, 'id' => 'geocomplete']) ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'address')->textInput(['maxlength' => true, 'class' => 'name form-control']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'city')->textInput(['maxlength' => true, 'class' => 'locality form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, 'state')->textInput(['maxlength' => true, 'class' => 'administrative_area_level_1_short form-control']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                               <?= $form->field($itineraryModel, 'country')->textInput(['maxlength' => true, 'class' => 'country form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($itineraryModel, "imageFiles[]")->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <?php 
                                                    echo $this->render('//shared/_photo-gallery', ['model' => $itineraryModel, 'delete' => true]);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group text-center">
                            <?= Html::resetButton($roomModel->isNewRecord ? Yii::t('app', 'Cancel') : Yii::t('app', 'Cancel'), ['class' => 'btn btn-primary gray-btn', 'onclick' => 'parent.history.back();']) ?>
                            <?= Html::button($itineraryModel->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $itineraryModel->isNewRecord ? 'btn btn-default red-btn bnt_save_package_itinerary' : 'btn btn-primary gray-btn bnt_update_package_itinerary']) ?>
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
