<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\PropertyType;
use common\models\PropertyCategory;
use common\models\MetricType;
use common\models\ConstructionStatusMaster;
use common\models\User;
use common\models\Profile;
use yii\web\JsExpression;
use kartik\select2\Select2;
use common\models\TimezoneMaster;
use kartik\date\DatePicker;

use common\models\LocationLocalInfoTypeMaster;
use common\models\RentalPlanType;
use common\models\CurrencyMaster;
use common\models\RentalFeatureMaster;
use common\models\ElectricityType;


/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
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

$this->registerJsFile(
    '@web/public_main/js/rental.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/moment/moment.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->registerCssFile(
    '@web/js/plugins/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
		
$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'Create Rental Property';
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Add New Property</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
            <li class="active">Add New Property</li>
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
                    <span class="row col-sm-12 form-group error">* fields are required</span>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#property" aria-controls="property" role="tab" data-toggle="tab">Basic Location Info <span class="error">*</span></a></li>
                        <li role="presentation"><a href="#localInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Property and Landmark <span class="error">*</span></a></li>
                        <li role="presentation"><a href="#price-info" aria-controls="price-info" role="tab" data-toggle="tab">Price and Other Info <span class="error">*</span></a></li>
                        <li role="presentation"><a href="#meta-info" aria-controls="metaTag" role="tab" data-toggle="tab">Meta Tag <span class="error">*</span></a></li>
                        <li role="presentation"><a href="#rentalPlan" aria-controls="rentalPlan" role="tab" data-toggle="tab">Rental Plan <span class="error">*</span></a></li>
                        <li role="presentation"><a href="#rentalFeature" aria-controls="rentalPlan" role="tab" data-toggle="tab">Rental Feature <span class="error">*</span></a></li>
                        <li role="presentation"><a href="#open-Houses" aria-controls="open-Houses" role="tab" data-toggle="tab">Open House</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['method' => 'post','options' => ['class' => 'frm_geocomplete','id' => 'frm_capture_rental_property_data']]); ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="property">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                            	<div class="row">
                                                    <div class="col-sm-12">
                                                        <?= $form->field($model, 'location')->textInput(['maxlength' => true, 'class'=> 'form-control','id' => 'property_location_geocomplete']) ?>
                                                    </div>
                                                    <div class="col-sm-12 map-view-upper">
                                                        <?= $form->field($model, 'lat')->hiddenInput(['class' => 'lat'])->label(false) ?>
                                                        <?= $form->field($model, 'lng')->hiddenInput(['class' => 'lng'])->label(false) ?>
                                                        <label for="">Map View:</label>
                                                        <div id="dv_property_map_canvas" style="min-height: 105px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'description')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none; height:190px;']) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <h5>Property Location:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <?= $form->field($model, 'country')->textInput(['maxlength' => true, 'class' => 'country form-control']) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <?= Html::activeHiddenInput($model, 'state', ['class' => 'administrative_area_level_1_short']) ?>
                                                <?= $form->field($model, 'state_long')->textInput(['class' => 'administrative_area_level_1 form-control']) ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'class' => 'locality form-control']) ?>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <?= $form->field($model, 'address1')->textInput(['maxlength' => true, 'class' => 'name small-height-textarea']) ?>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <?= $form->field($model, 'address2')->textInput(['maxlength' => true, 'class' => 'route small-height-textarea']) ?>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <?= $form->field($model, 'land_mark')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true, 'class' => 'postal_code form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="localInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'metric_type_id')->dropDownList(ArrayHelper::map(MetricType::find()->all(), 'id', 'name'), ['prompt' => 'Select Metric Type','class' => 'selectpicker']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'size')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'size_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'lot_area')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'lot_area_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'no_of_room')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'no_of_room_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'no_of_balcony')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'no_of_balcony_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'no_of_bathroom')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'no_of_bathroom_max')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'lift')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>
                                            </div>

                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'furnished')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>
                                            </div>

                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'water_availability')->radioList(['1'=>'Yes',2=>'No'],['class' => 'custom-inline-radio']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <?= $form->field($model, 'electricityTypeIds')->checkBoxList(ArrayHelper::map(ElectricityType::find()->all(), 'id', 'name')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'pet_friendly')->dropDownList([$model::PET_FRIENDLY_YES => 'Yes', $model::PET_FRIENDLY_NO => 'No'],['prompt' => 'Select']) ?>
                                            </div>

                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'in_unit_laundry')->dropDownList([$model::UNIT_LAUNDRY_YES => 'Yes', $model::UNIT_LAUNDRY_NO => 'No'],['prompt' => 'Select']) ?>
                                            </div>

                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'pools')->dropDownList([$model::POOLS_YES => 'Yes', $model::POOLS_NO => 'No'],['prompt' => 'Select']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'studio')->dropDownList([$model::PET_FRIENDLY_YES => 'Yes', $model::PET_FRIENDLY_NO => 'No'],['prompt' => 'Select']) ?>
                                            </div>

                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'homes')->dropDownList([$model::HOMES_YES => 'Yes', $model::HOMES_NO => 'No'],['prompt' => 'Select']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Location Local Information:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php 
                                            $tempLoc = new \common\models\RentalLocationLocalInfo();
                                            ?>
                                            <div class="col-sm-12 rental_local_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="text-center">
                                                <button name="" type="button" class="btn_add_rental_property_local_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add New Location Local Info</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="price-info">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(CurrencyMaster::find()->active()->all(), 'id', 'name'),['class'=>'selectpicker']) ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'rental_category')->dropDownList(['' => 'Select Rental Category', 'Rent' => 'Rent', 'Short Rent' => 'Short Rent']) ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'price_for')->dropDownList(['' => 'Select Price for', 'per Day' => 'per Day', 'per Month' => 'per Month', 'per Year' => 'per Year']) ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'service_fee_for')->dropDownList(['' => 'Select Price for', 'per Day' => 'per Day', 'per Month' => 'per Month', 'per Year' => 'per Year']) ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'service_fee')->textInput() ?>
                                        </div>

                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'other_fee_for')->dropDownList(['' => 'Select Price for', 'per Day' => 'per Day', 'per Month' => 'per Month', 'per Year' => 'per Year']) ?>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <?= $form->field($model, 'other_fee')->textInput() ?>
                                        </div>
                                    </div>

                                    <div class="add-property-upload-sec">
                                        <div class="form-group col-sm-4">
                                            <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

                                            <div class="add-property-upload-images">
                                              <?php 
                                                echo $this->render('//shared/_photo-gallery', ['model' => $model]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <?= $form->field($model, 'property_video_link')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'property_type_id')->dropDownList(ArrayHelper::map(PropertyType::find()->where(['property_category_id' => 1])->all(), 'id', 'title'), ['prompt' => 'Select Property Type','class'=>'selectpicker']) ?>
                                            </div>

                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'construction_status_id')->dropDownList(ArrayHelper::map(ConstructionStatusMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Construction Status','class'=>'selectpicker']) ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php 
                            if($model->isNewRecord){
                                $metaTagModel->page_title = '[title]';
                            }
                        ?>
                        <div role="tabpanel" class="tab-pane" id="meta-info">
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
                        
                        <div role="tabpanel" class="tab-pane" id="rentalPlan">
                            <div class="form-sec-box">
                                <div class="row">
                                    <?php 
                                    $tempLoc = new \common\models\RentalPlan();
                                    ?>
                                    <div class="col-sm-12 rental_plan_info_container">

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="text-center">
                                        <button name="" type="button" class="btn_add_rental_plan_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add New Rental Plan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="rentalFeature">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Rental Features:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php 
                                            $tempFeatrue    =   new \common\models\RentalFeature();
                                            $tempItem       =   new \common\models\RentalFeatureItem(); 
                                            ?>
                                            <div class="col-sm-12 dv_rental_feature_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="text-center">
                                                <button name="" type="button" class="btn_add_rental_feature_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add New Rental Feature</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="open-Houses">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Open Houses Information:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                        	<div class="col-sm-3">
                                            	<?= $form->field($openHouseModel, "startdate")->textInput(['maxlength' => true,'class' => 'form-control datepkr']) ?>
                							</div>
                                            <div class="col-sm-3">
                                            	<?= $form->field($openHouseModel, "enddate")->textInput(['maxlength' => true,'class' => 'form-control datepkr']) ?>
											</div>
                                            <div class="col-sm-3">
                                            	<?= $form->field($openHouseModel, "starttime")->textInput(['maxlength' => true,'class' => 'form-control timepicker']) ?>
											</div>
                                            <div class="col-sm-3">
                                            	<?= $form->field($openHouseModel, "endtime")->textInput(['maxlength' => true,'class' => 'form-control timepicker']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <?= Html::a(Yii::t('app', 'Cancel'),['rental/rental-list'],['class' => $model->isNewRecord ? 'btn btn-default gray-btn' : 'btn btn-primary gray-btn']) ?>
                            <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn bnt_save_rental_property' : 'btn btn-primary gray-btn']) ?>
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
$tempLoc    = new \common\models\RentalLocationLocalInfo();
$tempRental = new \common\models\RentalPlan();
$tempFeatrue =  new common\models\RentalFeature();
$tempItem   =   new \common\models\RentalFeatureItem();
?>

<div style="display: none" class="dv_rental_local_info_block_template">
    <div class="item new add-form-popup">
        <div class="form-group col-sm-6">
            <div class="row">
                <?= Html::activeHiddenInput($tempLoc, '[curTime]id')?>
                <?= Html::activeHiddenInput($tempLoc, '[curTime]lat', ['class' => 'lat_curTime'])?>
                <?= Html::activeHiddenInput($tempLoc, '[curTime]lng', ['class' => 'lat_curTime'])?>
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempLoc, '[curTime]local_info_type_id')?>
                    <?= Html::activeDropDownList($tempLoc, '[curTime]local_info_type_id', ArrayHelper::map(LocationLocalInfoTypeMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Local Location', 'class' => 'form-control'])?>
                </div>

                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempLoc, '[curTime]title')?>
                    <?= Html::activeTextInput($tempLoc, '[curTime]title', ['class' => 'form-control'])?>
                </div>
                
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempLoc, '[curTime]location')?>
                    <?= Html::activeTextInput($tempLoc, '[curTime]location', ['class' => 'form-control geocomplete_local_info_curTime'])?>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-6">
            <div class="row">
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempLoc, '[curTime]description')?>
                    <?= Html::activeTextarea($tempLoc, '[curTime]description', ['class' => 'form-control'])?>
                </div>
            </div>
        </div>
        <div class="">
            <?= Html::activeHiddenInput($tempLoc, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

<div style="display: none" class="dv_property_rental_plan_block_template">
    <div class="item new add-form-popup">
        <div class="form-group col-sm-6">
            <div class="row">
                <?= Html::activeHiddenInput($tempRental, '[curTime]id')?>
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempRental, '[curTime]rental_plan_id')?>
                    <?= Html::activeDropDownList($tempRental, '[curTime]rental_plan_id', ArrayHelper::map(RentalPlanType::find()->all(), 'id', 'name'), ['prompt' => 'Select Plan', 'class' => 'form-control'])?>
                </div>
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempRental, '[curTime]name')?>
                    <?= Html::activeTextInput($tempRental, '[curTime]name', ['class' => 'form-control'])?>
                </div>
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempRental, '[curTime]bed')?>
                    <?= Html::activeTextInput($tempRental, '[curTime]bed', ['class' => 'form-control', 'onkeypress'=>'return isNumberKeyWithDot(event)'])?>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-6">
            <div class="row">
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempRental, '[curTime]bath')?>
                    <?= Html::activeTextInput($tempRental, '[curTime]bath', ['class' => 'form-control', 'onkeypress'=>'return isNumberKeyWithDot(event)'])?>
                </div>
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempRental, '[curTime]size')?>
                    <?= Html::activeTextInput($tempRental, '[curTime]size', ['class' => 'form-control', 'onkeypress'=>'return isNumberKeyWithDot(event)'])?>
                </div>
                <div class="form-group col-sm-12">
                    <?= Html::activeLabel($tempRental, '[curTime]price')?>
                    <?= Html::activeTextInput($tempRental, '[curTime]price', ['class' => 'form-control', 'onkeypress'=>'return isNumberKeyWithDot(event)'])?>
                </div>
            </div>
        </div>
        <div class="">
            <?= Html::activeHiddenInput($tempRental, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

<div style="display: none" class="dv_rental_feature_block_template">
    <div class="item new add-form-popup">
        <div class="form-group col-sm-12">
            <?= Html::activeHiddenInput($tempFeatrue, '[curTime]id')?>
            <div class="form-group">
                <?= Html::activeLabel($tempFeatrue, '[curTime]feature_master_id')?>
                <?= Html::activeDropDownList($tempFeatrue, '[curTime]feature_master_id', ArrayHelper::map(RentalFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
            </div>
            <div class="form-group">
                <?= Html::activeHiddenInput($tempItem, '[curTime][1]id')?>
                <?= Html::activeLabel($tempItem, '[curTime][1]name')?>
                <?= Html::activeTextInput($tempItem, '[curTime][1]name', ['class' => 'form-control'])?>
            </div>
            <div class="form-group">
                <?= Html::activeHiddenInput($tempItem, '[curTime][2]id')?>
                <?= Html::activeLabel($tempItem, '[curTime][2]name')?>
                <?= Html::activeTextInput($tempItem, '[curTime][2]name', ['class' => 'form-control'])?>
            </div>
            <div class="form-group">
                <?= Html::activeHiddenInput($tempItem, '[curTime][3]id')?>
                <?= Html::activeLabel($tempItem, '[curTime][3]name')?>
                <?= Html::activeTextInput($tempItem, '[curTime][3]name', ['class' => 'form-control'])?>
            </div>
            <div class="form-group">
                <?= Html::activeHiddenInput($tempItem, '[curTime][4]id')?>
                <?= Html::activeLabel($tempItem, '[curTime][4]name')?>
                <?= Html::activeTextInput($tempItem, '[curTime][4]name', ['class' => 'form-control'])?>
            </div>
            <div class="form-group">
                <?= Html::activeHiddenInput($tempItem, '[curTime][5]id')?>
                <?= Html::activeLabel($tempItem, '[curTime][5]name')?>
                <?= Html::activeTextInput($tempItem, '[curTime][5]name', ['class' => 'form-control'])?>
            </div>
        </div>     
        <div class="">
            <?= Html::activeHiddenInput($tempFeatrue, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>