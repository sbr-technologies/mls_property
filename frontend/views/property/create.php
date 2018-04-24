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
use common\models\LocationLocalInfoTypeMaster;
use common\models\FactMaster;
use common\models\PropertyFeatureMaster;
use common\models\CurrencyMaster;
use common\models\GeneralFeatureMaster;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use frontend\helpers\AuthHelper;
use kartik\date\DatePicker;
use common\models\Agent;
use kartik\select2\Select2;
use common\models\Property;
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
    '@web/js/property.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/multiselect.js',
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
$propertyTypes = PropertyType::find()->active()->all();
//\yii\helpers\VarDumper::dump($propertyTypes,4,12); exit;
$this->title = 'Create Property';
$range      =   [
                    1   => 1,
                    2   => 2,
                    3   => 3,
                    4   => 4,
                    5   => 5,
                    6   => 6,
                    7   => 7,
                    8   => 8,
                    9   => 9,
                    10  =>  "10+",
                ];
$roomRange      =   [
                    0   => 0,
                    1   => 1,
                    2   => 2,
                    3   => 3,
                    4   => 4,
                    5   => 5,
                    6   => 6,
                    7   => 7,
                    8   => 8,
                    9   => 9,
                    10  =>  "10+",
                ];
$output     =   [
                    'name'      =>  'Name',
                    'Address'   =>  'Address',
                    'Phone 1'   =>  'Phone 1',
                    'Phone 2'   =>  'Phone 2',
                    'Phone 3'   =>  'Phone 3',
                    'Email 1'   =>  'Email 1',
                    'Email 2'   =>  'Email 2',
                ];
$user = Yii::$app->user->identity;
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
                    <span class="error">* fields are required</span>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#locationInfo" aria-controls="location-info" role="tab" data-toggle="tab">Basic & Location Infor<span class="error">*</span></a></li>
                        <li role="presentation"><a href="#landMark" aria-controls="land-mark" role="tab" data-toggle="tab">Property Info & Land Mark<span class="error">*</span></a></li>
                        <li role="presentation"><a href="#priceInfo" aria-controls="price-info" role="tab" data-toggle="tab">Price & Other Info<span class="error">*</span></a></li>
                        <li role="presentation"><a href="#photoVirtual" aria-controls="photo-virtual" role="tab" data-toggle="tab">Property Photos, Virtual Tour & Docs</a></li>
                        <li role="presentation"><a href="#features" aria-controls="feature" role="tab" data-toggle="tab">Features</a></li>
                        <li role="presentation"><a href="#FeatureGallery" aria-controls="propertyFeature" role="tab" data-toggle="tab">Features Gallery</a></li>
                        <li role="presentation"><a href="#metaInfo" aria-controls="meta-info" role="tab" data-toggle="tab">Meta Info<span class="error">*</span></a></li>
                        <li role="presentation"><a href="#taxHistory" aria-controls="tax-history" role="tab" data-toggle="tab">Tax Information</a></li>
                        <li role="presentation"><a href="#mediaInfo" aria-controls="media-info" role="tab" data-toggle="tab">Social Media Info</a></li>
                        <li role="presentation"><a href="#openHouses" aria-controls="open-Houses" role="tab" data-toggle="tab">Open House</a></li>
                        <li role="presentation"><a href="#contactInfo" aria-controls="open-Houses" role="tab" data-toggle="tab">Sales Contact Info</a></li>
                        <li role="presentation"><a href="#showingInfo" aria-controls="open-Houses" role="tab" data-toggle="tab">Showing Information</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['method' => 'post','options' => ['class' => 'frm_geocomplete','id' => 'frm_capture_property_data']]); ?>
                    <?= $form->field($model, 'save_incomplete')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'save_incomplete'])->label(false) ?>
                    <?= $form->field($model, 'parent_id')->hiddenInput(['id' => 'parent_id'])->label(false) ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="locationInfo">
                            <div class="col-sm-12 form-sec">
                                <?php if(AuthHelper::is('agency')){
                                    $agency = $user->agency;
                                ?>
                                <div class="row">
                                    <div class="form-group">
                                        <?php  echo $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(Agent::find()->where(['agency_id' => $agency])->active()->orderBy(['first_name' => SORT_ASC])->all(), 'id', 'fullName'), ['prompt' => 'Select Agent'])->label('Agent') ?>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'parent_id')->widget(Select2::className(), [
                                                    'data' => ArrayHelper::map(Property::find()->where(['is_multi_units_apt' => 1, 'parent_id' => null])->all(), 'id', 'building_name'),
                                                    'options' => ['placeholder' => 'Select an Apartment', 'class' => 'form-control sel_parent_id'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                            ])?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?php  echo $form->field($model, 'property_category_id')->dropDownList(ArrayHelper::map(PropertyCategory::find()->orderBy(['sort_order' => SORT_ASC])->all(), 'id', 'title'), ['prompt' => 'Select Property Category', 'id' => 'property_category_id','onchange' => 'showHideDiv(this.value)']) ?>
                                        </div>
                                        <div class="col-sm-3"><span class="span-error">*</span>
                                            <?php  echo $form->field($model, 'propertyTypeId[]')->dropDownList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'),['multiple' => true ,'id' => 'property_type_id_multiselect', 'class' => 'selectpicker']) ?>
                                            <?= $form->field($model, 'property_type_id')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'property_type_id'])->label(false) ?>
                                        </div>

                                        <div class="col-sm-3"><span class="span-error span-error1">*</span>
                                            <?= $form->field($model, 'constructionStatusId[]')->dropDownList(ArrayHelper::map(ConstructionStatusMaster::find()->all(), 'id', 'title'), ['multiple' => true ,'id' => 'construction_status_id_multiselect','class'=>'selectpicker']) ?>
                                            <?= $form->field($model, 'construction_status_id')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'construction_status_id'])->label(false) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?php
                                                $model->market_status = common\models\Property::MARKET_ACTIVE;
                                            ?>
                                            <?= $form->field($model, 'market_status')->dropDownList([$model::MARKET_ACTIVE => 'Active', $model::MARKET_NOTACTIVE => 'Not Active', $model::MARKET_PENDING => 'Pending', $model::MARKET_SOLD => 'Sold', $model::MARKET_COMPS_SOLD => 'Comps Sold', $model::MARKET_CANCELLED => 'Cancelled', $model::MARKET_EXPIRED => 'Expired', $model::MARKET_NOT_AVAILABLE => 'Not Available for Sale', Property::MARKET_LEASED => 'Leased', Property::MARKET_NOT_AVAILABLE_FOR_LEASE => 'Not available for Lease', $model::MARKET_INCOMPLETE => 'Incomplete'],['prompt' => 'Select Status','id' => 'market_status','onchange' => 'showHideSoldDiv(this.value)']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group" id="soldDataDiv" style="display:none;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                            <?php
                                            echo $form->field($model, 'soldDate')->widget(DatePicker::classname(), [
                                                'options' => ['placeholder' => 'DD/MM/YYYY'],
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => Yii::$app->params['dateFormatJs'],
                                                    'endDate' => "+0d",
                                                    'todayHighlight' => true,
                                                ]
                                            ]);
                                            ?>
                                            </div>
                                            <div class="col-sm-6">
                                            <?= $form->field($model, 'sold_price')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'sole_mandate')->checkbox()?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($model, 'preimum_lisitng')->checkbox()?>
                                            </div>
                                            <?php
                                            if(AuthHelper::is('seller')){
                                            ?>
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'is_seller_information_show')->checkbox()?>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'description')->textarea(['class'=> 'form-control','style'=> 'resize:none;', 'rows' => 2]) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php 
                                                $model->setlistedDate();
                                                echo $form->field($model, 'listedDate')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'DD/MM/YYYY', 'disabled' => true],
                                                    'removeButton' => false,
                                                    'pluginOptions' => [
                                                        'autoclose'=>true,
                                                        'format' => Yii::$app->params['dateFormatJs'],
//                                                        'endDate' => "+0d",
                                                        'defaultDate' => "new Date()",
                                                        'todayHighlight' => true,
                                                    ]
                                                ]);?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php echo $form->field($model, 'expiredDate')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'DD/MM/YYYY'],
                                                    'removeButton' => false,
                                                    'pluginOptions' => [
                                                        'autoclose'=>true,
                                                        'format' => Yii::$app->params['dateFormatJs'],
                                                        'startDate' => "0d",
                                                        'endDate' => "+90d",
                                                        'todayHighlight' => true,
                                                    ]
                                                ]);?>
                                            </div>
                                        </div>
                                    </div>

                                    <h5>Property Location:</h5>
                                    <div class="">
                                        <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model])?>
                                    </div>
                                    <h5>GPS Location</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                            <?= $form->field($model, 'lat')->textInput(['maxlength' => true, 'class' => 'form-control', 'onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                            <?= $form->field($model, 'lng')->textInput(['maxlength' => true, 'class' => 'form-control', 'onkeypress'=>'return isNumberKeyWithDot(event)']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="landMark">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <?php if($model->isNewRecord){
                                                $model->metric_type_id = 1;
                                            }?>
                                            <?= $form->field($model, 'metric_type_id')->dropDownList(ArrayHelper::map(MetricType::find()->all(), 'id', 'name'), ['prompt' => 'Select Metric Type','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'lot_size')->textInput(['maxlength' => true,'class'=> 'form-control', 'placeholder' => 'e.g 100']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'building_size')->textInput(['maxlength' => true,'class'=> 'form-control', 'placeholder' => 'e.g 100']) ?>
                                            <?php //echo $form->field($model, 'building_size', ['template' => '{label} <span class="sqm">sqm</span> <div class="row"><div class="col-sm-12">{input}{error}{hint}</div></div>']); ?>
                                            <?php //echo $form->field($model, 'building_size')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'house_size')->textInput(['maxlength' => true,'class'=> 'form-control', 'placeholder' => 'e.g 100']) ?>
                                            <?php //echo $form->field($model, 'house_size', ['template' => '{label} <span class="sqm">sqm</span> <div class="row"><div class="col-sm-12">{input}{error}{hint}</div></div>' ]); ?>
                                            <?php //echo $form->field($model, 'house_size')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>
<!--                                        <div class="col-sm-3">
                                            <?php //echo $form->field($model, 'appartment_units')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            <?php //echo $form->field($model, 'house_size', ['template' => '{label} <span class="sqm">sqm</span> <div class="row"><div class="col-sm-12">{input}{error}{hint}</div></div>' ]); ?>
                                            <?php //echo $form->field($model, 'house_size')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'no_of_room')->dropDownList($roomRange,['prompt' => 'Select No of Rooms','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'no_of_bathroom')->dropDownList($range,['prompt' => 'Select No of Bathroom','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'no_of_toilet')->dropDownList($range,['prompt' => 'Select No of Toilet','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'no_of_garage')->dropDownList($range,['prompt' => 'Select No of Garage','class' => 'selectpicker']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'no_of_boys_quater')->dropDownList($range,['prompt' => 'Select No of Boys Quater','class' => 'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                        <div class="col-sm-4">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <?= $form->field($model, 'year_built')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">    
                                    <h5>Location Directories:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php 
                                            $tempLoc = new \common\models\PropertyLocationLocalInfo();
                                            ?>
                                            <div class="property_local_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="text-center">
                                                <button name="" type="button" class="btn_add_property_local_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add new Location Directory</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="priceInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row form-group">
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(CurrencyMaster::find()->active()->all(), 'id', 'name'), ['class'=>'selectpicker']) ?>
                                    </div>
                                    
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'price')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div id="priceForDiv"></div>
                                    </div>
                                </div>
                                <div id="salePropertyDiv" style="display:none;">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'tax')->textInput(['maxlength' => true,'placeholder' => 'Per Annum']) ?>
                                        </div>
                                        
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'tax_for')->dropDownList(['Per Annum' => 'Per Annum'],['class' => 'selectpicker']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'insurance')->textInput(['maxlength' => true,'placeholder' => 'Per Annum']) ?>
                                        </div>
                                        
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'insurance_for')->dropDownList(['Per Annum' => 'Per Annum'],['class' => 'selectpicker']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'hoa_fees')->textInput(['maxlength' => true,'placeholder' => 'Per Annum']) ?>
                                        </div>

                                        

                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'hoa_for')->dropDownList(['Per Annum' => 'Per Annum'],['class' => 'selectpicker']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="serviceOtherDiv" style="display:none;">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'service_fee')->textInput(['class' => 'form-control clearValCls']) ?>
                                        </div>

                                        

                                        <div class="form-group col-sm-6">
                                            <div id="serviceForDiv"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <?= $form->field($model, 'other_fee')->textInput(['class' => 'form-control clearValCls']) ?>
                                        </div>

                                        

                                        <div class="form-group col-sm-6">
                                            <div id="otherForDiv"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div id="contactTermDiv"></div>
                                </div>
                                
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="photoVirtual">
                            <div class="row">
                                <div class="add-property-upload-sec">
                                    <div class="form-group col-sm-6">
                                        <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true]) ?>

                                    </div>
                                    <div class="form-group col-sm-6">
                                        <?= $form->field($model, 'virtual_link')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="add-property-upload-sec">
                                    <div class="form-group col-sm-6">
                                        <?= $form->field($model, 'documentFiles[]')->fileInput(['multiple' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="features">
                            <div class="row">
                                <div class="col-sm-4 form-sec">
                                    <h5>General Features:</h5>
                                    <div class="form-sec-box">
                                        <div class="">
                                            <?php
                                                $genralFeatureModel->general = $genralFeatures;
                                                $genralFeatureModel->exterior = $genralFeatures;
                                                $genralFeatureModel->interior = $genralFeatures;
                                            ?>
                                            <?= $form->field($genralFeatureModel, 'general')->checkBoxList(ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'general'])->all(), 'id', 'name')) ?>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 form-sec">
                                    <h5>Exterior Features:</h5>
                                    <div class="form-sec-box">
                                        <div class="">
                                            <?= $form->field($genralFeatureModel, 'exterior')->checkBoxList(ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'exterior'])->all(), 'id', 'name')) ?>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 form-sec">
                                    <h5>Interior Features:</h5>
                                    <div class="form-sec-box">
                                        <div class="">
                                            <?= $form->field($genralFeatureModel, 'interior')->checkBoxList(ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'interior'])->all(), 'id', 'name')) ?>  
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="FeatureGallery">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Property Features:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php 
                                            $tempFeatrue    =   new \common\models\PropertyFeature();
                                            $tempItem       =   new \common\models\PropertyFeatureItem(); 
                                            ?>
                                            <div class="item add-form-popup">
                                                <div class="form-group col-sm-12">
                                                    <?= Html::activeHiddenInput($tempFeatrue, '[0]id')?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[0]feature_master_id')?>
                                                                <?php 
                                                                $tempFeatrue->feature_master_id = 2;
                                                                $tempFeatureName    =   $tempFeatrue->featureMaster->name; 
                                                                ?>
                                                                <?= Html::activeDropDownList($tempFeatrue, '[0]feature_master_id',ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[0]imageFiles[]')?>
                                                            <?= Html::activeFileInput($tempFeatrue, '[0]imageFiles[]',['multiple' => true])?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[0][1]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[0][1]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[0][1]name', ['class' => 'form-control', 'placeholder' => 'e.g '.$tempFeatureName.' 1'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[0][1]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[0][1]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[0][1]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[0][2]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[0][2]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[0][2]name', ['class' => 'form-control', 'placeholder' => 'e.g '.$tempFeatureName.' 2'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[0][2]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[0][2]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[0][2]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[0][3]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[0][3]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[0][3]name', ['class' => 'form-control', 'placeholder' => 'e.g '.$tempFeatureName.' 3'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[0][3]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[0][3]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[0][3]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            
                                            <div class="item add-form-popup">
                                                <div class="form-group col-sm-12">
                                                    <?= Html::activeHiddenInput($tempFeatrue, '[1]id')?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[1]feature_master_id')?>
                                                                <?php 
                                                                $tempFeatrue->feature_master_id = 6;
                                                                //$tempFeatureName2    =   $tempFeatrue->featureMaster->name; echo $tempFeatureName2;
                                                                ?>
                                                                <?= Html::activeDropDownList($tempFeatrue, '[1]feature_master_id',ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[1]imageFiles[]')?>
                                                            <?= Html::activeFileInput($tempFeatrue, '[1]imageFiles[]',['multiple' => true])?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[1][1]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[1][1]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[1][1]name', ['class' => 'form-control', 'placeholder' => 'e.g Bathroom 1'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[1][1]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[1][1]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[1][1]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[1][2]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[1][2]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[1][2]name', ['class' => 'form-control', 'placeholder' => 'e.g Bathroom 2'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[1][2]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[1][2]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[1][2]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[1][3]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[1][3]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[1][3]name', ['class' => 'form-control', 'placeholder' => 'e.g Bathroom 3'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[1][3]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[1][3]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[1][3]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            <div class="item add-form-popup">
                                                <div class="form-group col-sm-12">
                                                    <?= Html::activeHiddenInput($tempFeatrue, '[2]id')?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[2]feature_master_id')?>
                                                                <?php 
                                                                $tempFeatrue->feature_master_id = 3;
                                                                ?>
                                                                <?= Html::activeDropDownList($tempFeatrue, '[2]feature_master_id',ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[2]imageFiles[]')?>
                                                            <?= Html::activeFileInput($tempFeatrue, '[2]imageFiles[]',['multiple' => true])?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[2][1]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[2][1]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[2][1]name', ['class' => 'form-control', 'placeholder' => 'e.g Living Room 1'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[2][1]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[2][1]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[2][1]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[2][2]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[2][2]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[2][2]name', ['class' => 'form-control', 'placeholder' => 'e.g Living Room 2'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[2][2]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[2][2]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[2][2]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[2][3]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[2][3]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[2][3]name', ['class' => 'form-control', 'placeholder' => 'e.g Living Room 3'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[2][3]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[2][3]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[2][3]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            
                                            <div class="item add-form-popup">
                                                <div class="form-group col-sm-12">
                                                    <?= Html::activeHiddenInput($tempFeatrue, '[3]id')?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[3]feature_master_id')?>
                                                                <?php 
                                                                $tempFeatrue->feature_master_id = 7;
                                                                ?>
                                                                <?= Html::activeDropDownList($tempFeatrue, '[3]feature_master_id',ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[3]imageFiles[]')?>
                                                            <?= Html::activeFileInput($tempFeatrue, '[3]imageFiles[]',['multiple' => true])?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[3][1]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[3][1]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[3][1]name', ['class' => 'form-control', 'placeholder' => 'e.g Dining 1'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[3][1]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[3][1]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[3][1]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[3][2]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[3][2]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[3][2]name', ['class' => 'form-control' , 'placeholder' => 'e.g Dining 2'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[3][2]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[3][2]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[3][2]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[3][3]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[3][3]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[3][3]name', ['class' => 'form-control', 'placeholder' => 'e.g Dining 3'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[3][3]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[3][3]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[3][3]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            <div class="item add-form-popup">
                                                <div class="form-group col-sm-12">
                                                    <?= Html::activeHiddenInput($tempFeatrue, '[4]id')?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[4]feature_master_id')?>
                                                                <?php 
                                                                $tempFeatrue->feature_master_id = 1;
                                                                ?>
                                                                <?= Html::activeDropDownList($tempFeatrue, '[4]feature_master_id',ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= Html::activeLabel($tempFeatrue, '[4]imageFiles[]')?>
                                                            <?= Html::activeFileInput($tempFeatrue, '[4]imageFiles[]',['multiple' => true])?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[4][1]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[4][1]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[4][1]name', ['class' => 'form-control' , 'placeholder' => 'e.g Bedroom 1'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[4][1]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[4][1]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[4][1]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[4][2]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[4][2]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[4][2]name', ['class' => 'form-control', 'placeholder' => 'e.g Bedroom 2'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[4][2]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[4][2]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[4][2]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeHiddenInput($tempItem, '[4][3]id')?>
                                                                        <?= Html::activeLabel($tempItem, '[4][3]name')?>
                                                                        <?= Html::activeTextInput($tempItem, '[4][3]name', ['class' => 'form-control', 'placeholder' => 'e.g Bedroom 3'])?>
                                                                    </div>
                                                                    <div class="form-group col-sm-12">
                                                                        <?= Html::activeLabel($tempItem, '[4][3]size')?>
                                                                        <?= Html::activeTextInput($tempItem, '[4][3]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                                        <?= Html::activeTextarea($tempItem, '[4][3]description', ['class' => 'form-control limit_text_area_20','rows' => 5, 'style' =>'resize:none;'])?>
                                                                        <input type="hidden" class="txt_countdown" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>     
                                            </div>
                                            <div class="dv_property_feature_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="text-center">
                                                <button name="" type="button" class="btn_add_property_feature_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add new Feature Gallery</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="metaInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php if($metaTagModel->isNewRecord){
                                                    $metaTagModel->page_title = '[title]';
                                                }?>
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
                        <div role="tabpanel" class="tab-pane" id="taxHistory">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Property Tax Information:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php 
                                            $tempTax    = new \common\models\PropertyTaxHistory();   
                                            ?>
                                            <div class="item new add-form-popup">
                                                <div class="form-group col-sm-12">
                                                    <div class="row">
                                                        <?= Html::activeHiddenInput($tempTax, '[0]id')?>
                                                        <div class="form-group col-sm-6">
                                                          <?= Html::activeLabel($tempTax, '[0]year')?>
                                                          <?= Html::activeTextInput($tempTax, '[0]year', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)','maxlength' => '4'])?>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                          <?= Html::activeLabel($tempTax, '[0]taxes')?>
                                                          <?= Html::activeTextInput($tempTax, '[0]taxes', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)'])?>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                </div>   
                                                
                                                <div class="form-group col-sm-12">
                                                    <div class="row">
                                                        <?= Html::activeHiddenInput($tempTax, '[1]id')?>
                                                        <div class="form-group col-sm-6">
                                                          <?= Html::activeLabel($tempTax, '[1]year')?>
                                                          <?= Html::activeTextInput($tempTax, '[1]year', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)','maxlength' => '4'])?>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                          <?= Html::activeLabel($tempTax, '[1]taxes')?>
                                                          <?= Html::activeTextInput($tempTax, '[1]taxes', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)'])?>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                </div> 
                                                
                                                <div class="form-group col-sm-12">
                                                    <div class="row">
                                                        <?= Html::activeHiddenInput($tempTax, '[2]id')?>
                                                        <div class="form-group col-sm-6">
                                                          <?= Html::activeLabel($tempTax, '[2]year')?>
                                                          <?= Html::activeTextInput($tempTax, '[2]year', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)','maxlength' => '4'])?>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                          <?= Html::activeLabel($tempTax, '[2]taxes')?>
                                                          <?= Html::activeTextInput($tempTax, '[2]taxes', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)'])?>
                                                        </div>
                                                    </div>
                                                    <hr class="style16">
                                                </div> 
                                            </div>
                                            
                                            <div class="col-sm-12 property_tax_history_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="text-center">
                                                <button name="" type="button" class="btn_add_property_tax_history btn btn-default add-landmark-btn red-btn"><span>+</span> Add New Tax History</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="mediaInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Social Media Link:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="">Facebook</label>
                                                <?= Html::textInput('SocialMediaLink[facebook][url]', isset($agentSocialMediaModel['facebook']['url']) ? $agentSocialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($agentSocialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="">Twitter:</label>
                                                <?= Html::textInput('SocialMediaLink[twitter][url]', isset($agentSocialMediaModel['twitter']['url']) ? $agentSocialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($agentSocialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="">Instagram:</label>
                                                <?= Html::textInput('SocialMediaLink[instagram][url]', isset($agentSocialMediaModel['instagram']['url']) ? $agentSocialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($agentSocialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="">Linkedin:</label>
                                                <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($agentSocialMediaModel['linkedin']['url']) ? $agentSocialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($agentSocialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="">Blog:</label>
                                                <?= Html::textInput('SocialMediaLink[blog][url]', isset($agentSocialMediaModel['blog']['url']) ? $agentSocialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($agentSocialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="">Pinterest:</label>
                                                <?= Html::textInput('SocialMediaLink[pinterest][url]', isset($agentSocialMediaModel['pinterest']['url']) ? $agentSocialMediaModel['pinterest']['url'] : '', ['class' => 'form-control pinterest readonlyCls','placeholder' => 'Enter Pinterest ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[pinterest][name]', isset($agentSocialMediaModel['pinterest']['url']) ? 'pinterest' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Pinterest ID']) ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="">Google:</label>
                                                <?= Html::textInput('SocialMediaLink[goolge][url]', isset($agentSocialMediaModel['goolge']['url']) ? $agentSocialMediaModel['goolge']['url'] : '', ['class' => 'form-control goolge readonlyCls','placeholder' => 'Enter Goolge ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[goolge][name]', isset($agentSocialMediaModel['goolge']['url']) ? 'goolge' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Goolge ID']) ?>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="">RSS Feed:</label>
                                                <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($agentSocialMediaModel['rss_feed']['url']) ? $agentSocialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control rss_feed readonlyCls','placeholder' => 'Enter Rss Feed ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($agentSocialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Rss Feed ID']) ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="">You tube :</label>
                                                <?= Html::textInput('SocialMediaLink[youtube][url]', isset($agentSocialMediaModel['youtube']['url']) ? $agentSocialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($agentSocialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="openHouses">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Open House :</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <div class="col-sm-6">
                                            	<?= $form->field($openHouseModel, "startdate")->textInput(['maxlength' => true,'class' => 'form-control datepkr']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                            	<?= $form->field($openHouseModel, "enddate")->textInput(['maxlength' => true,'class' => 'form-control datepkr']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($openHouseModel, "starttime")->textInput(['maxlength' => true,'class' => 'form-control timepicker']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                            	<?= $form->field($openHouseModel, "endtime")->textInput(['maxlength' => true,'class' => 'form-control timepicker']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="contactInfo">
                            <!--<h5>Add New Property Contact:</h5>-->
                            <?= $this->render('_sales-contacts', ['form' => $form, 'newModel' => $contactModel, 'allModels' => []]);?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="showingInfo">
                            <div class="item new add-form-popup col-sm-12">
                                <div class="row admin-box-title">
                                    <h3>Showing Contact Person 1</h3>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[0]first_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[0]middle_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[0]last_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[0]email')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[0]phone1')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[0]phone2')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[0]phone3')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <?= $form->field($propertyShowingContact, '[0]key_location')->textInput(['maxlength' => true,'class'=> 'form-control','id' => 'geocomplete_key1']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <?= $form->field($propertyShowingContact, '[0]showing_instruction')->textarea(['maxlength' => true,'class'=> 'form-control', 'rows' => 5 ,'style' => 'resize:none;']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="item new add-form-popup col-sm-12">
                                <div class="row admin-box-title">
                                    <h3>Showing Contact Person 2</h3>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[1]first_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[1]middle_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[1]last_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[1]email')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[1]phone1')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[1]phone2')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[1]phone3')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <?= $form->field($propertyShowingContact, '[1]key_location')->textInput(['maxlength' => true,'class'=> 'form-control','id' => 'geocomplete_key2']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <?= $form->field($propertyShowingContact, '[1]showing_instruction')->textarea(['maxlength' => true,'class'=> 'form-control', 'rows' => 5 ,'style' => 'resize:none;']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="item new add-form-popup col-sm-12">
                                <div class="row admin-box-title">
                                    <h3>Showing Contact Person 3</h3>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[2]first_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[2]middle_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[2]last_name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <?= $form->field($propertyShowingContact, '[2]email')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[2]phone1')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[2]phone2')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <?= $form->field($propertyShowingContact, '[2]phone3')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <?= $form->field($propertyShowingContact, '[2]key_location')->textInput(['maxlength' => true,'class'=> 'form-control','id' => 'geocomplete_key3']) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <?= $form->field($propertyShowingContact, '[2]showing_instruction')->textarea(['maxlength' => true,'class'=> 'form-control', 'rows' => 5 ,'style' => 'resize:none;']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <?= Html::a(Yii::t('app', 'Cancel'),['property/'],['class' => $model->isNewRecord ? 'btn btn-default gray-btn' : 'btn btn-primary ']) ?>
                            <?= Html::button($model->isNewRecord ? Yii::t('app', 'Save Incomplete') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary  bnt_save_incomplete_property red-btn' : 'btn btn-primary red-btn']) ?>
                            <?= Html::button($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success  bnt_save_property red-btn' : 'btn btn-primary red-btn']) ?>
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
$tempLoc                = new \common\models\PropertyLocationLocalInfo();
$tempTax                = new \common\models\PropertyTaxHistory(); 
?>

<div style="display: none" class="dv_local_info_block_template">
    <div class="item new add-form-popup">
        <div class="form-group col-sm-6">
            <?= Html::activeHiddenInput($tempLoc, '[curTime]id')?>
            <?= Html::activeHiddenInput($tempLoc, '[curTime]lat', ['class' => 'lat_curTime'])?>
            <?= Html::activeHiddenInput($tempLoc, '[curTime]lng', ['class' => 'lng_curTime'])?>
            <div class="form-group">
                <?= Html::activeLabel($tempLoc, '[curTime]local_info_type_id')?>
                <?= Html::activeDropDownList($tempLoc, '[curTime]local_info_type_id', ArrayHelper::map(LocationLocalInfoTypeMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Local Location', 'class' => 'form-control'])?>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($tempLoc, '[curTime]title')?>
                <?= Html::activeTextInput($tempLoc, '[curTime]title', ['class' => 'form-control'])?>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($tempLoc, '[curTime]location')?>
                <?= Html::activeTextInput($tempLoc, '[curTime]location', ['class' => 'form-control geocomplete_local_info_curTime'])?>
            </div>
        </div>
        <div class="form-group col-sm-6">
            <div class="form-group">
                <?= Html::activeLabel($tempLoc, '[curTime]description')?>
                <?= Html::activeTextarea($tempLoc, '[curTime]description', ['class' => 'form-control','style' => 'resize:none;','rows' => 8])?>
            </div>
        </div>
        <div class="">
            <?= Html::activeHiddenInput($tempLoc, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

<div style="display: none" class="dv_property_tax_history_block_template">
    <div class="item new add-form-popup">
        <div class="form-group">
            <div class="row">
                <?= Html::activeHiddenInput($tempTax, '[curTime]id')?>
                <div class="form-group col-sm-6">
                  <?= Html::activeLabel($tempTax, '[curTime]year')?>
                  <?= Html::activeTextInput($tempTax, '[curTime]year', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)','maxlength' => '4'])?>
                </div>
                <div class="form-group col-sm-6">
                  <?= Html::activeLabel($tempTax, '[curTime]taxes')?>
                  <?= Html::activeTextInput($tempTax, '[curTime]taxes', ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)'])?>
                </div>
            </div>
        </div>     
        <div class="">
            <?= Html::activeHiddenInput($tempTax, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>

<div style="display: none" class="dv_property_feature_block_template">
    <div class="item new add-form-popup">
        <div class="form-group col-sm-12">
            <?= Html::activeHiddenInput($tempFeatrue, '[curTime]id')?>
            <div class="form-group">
            	<div class="row">
                    <div class="col-sm-6">
                        <?= Html::activeLabel($tempFeatrue, '[curTime]feature_master_id')?>
                        <?= Html::activeDropDownList($tempFeatrue, '[curTime]feature_master_id', ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                    </div>
                    <div class="col-sm-6">
                        <?= Html::activeLabel($tempFeatrue, '[curTime]imageFiles[]')?>
                    <?= Html::activeFileInput($tempFeatrue, '[curTime]imageFiles[]',['multiple' => true])?>
                    </div>
                </div>
            </div>
            <hr class="style16">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    	<div class="row">
                            <div class="form-group col-sm-12">
                                <?= Html::activeHiddenInput($tempItem, '[curTime][1]id')?>
                                <?= Html::activeLabel($tempItem, '[curTime][1]name')?>
                                <?= Html::activeTextInput($tempItem, '[curTime][1]name', ['class' => 'form-control'])?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= Html::activeLabel($tempItem, '[curTime][1]size')?>
                                <?= Html::activeTextInput($tempItem, '[curTime][1]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                <?= Html::activeTextarea($tempItem, '[curTime][1]description', ['class' => 'form-control limit_text_area_20','rows' => 3, 'style' =>'resize:none;'])?>
                                <input type="hidden" class="txt_countdown" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="style16">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    	<div class="row">
                            <div class="form-group col-sm-12">
                        	<?= Html::activeHiddenInput($tempItem, '[curTime][2]id')?>
				<?= Html::activeLabel($tempItem, '[curTime][2]name')?>
                                <?= Html::activeTextInput($tempItem, '[curTime][2]name', ['class' => 'form-control'])?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= Html::activeLabel($tempItem, '[curTime][2]size')?>
                                <?= Html::activeTextInput($tempItem, '[curTime][2]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                        	<?= Html::activeTextarea($tempItem, '[curTime][2]description', ['class' => 'form-control limit_text_area_20','rows' => 3, 'style' =>'resize:none;'])?>
                                <input type="hidden" class="txt_countdown" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="style16">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    	<div class="row">
                            <div class="form-group col-sm-12">
                        	<?= Html::activeHiddenInput($tempItem, '[curTime][3]id')?>
				<?= Html::activeLabel($tempItem, '[curTime][3]name')?>
                                <?= Html::activeTextInput($tempItem, '[curTime][3]name', ['class' => 'form-control'])?>
                            </div>
                            <div class="form-group col-sm-12">
                                <?= Html::activeLabel($tempItem, '[curTime][3]size')?>
                                <?= Html::activeTextInput($tempItem, '[curTime][3]size', ['class' => 'form-control','placeholder' => 'e.g 10X10'])?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                <?= Html::activeTextarea($tempItem, '[curTime][3]description', ['class' => 'form-control limit_text_area_20','rows' => 3, 'style' =>'resize:none;'])?>
                                <input type="hidden" class="txt_countdown" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <div class="">
            <?= Html::activeHiddenInput($tempFeatrue, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
            <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>
<?php
$js = "$(function(){
        $(document).on('keydown', '.limit_text_area_20', function(){
            limitText($(this), $(this).next('.txt_countdown'), 20);
        });
        $(document).on('keyup', '.limit_text_area_20', function(){
            limitText($(this), $(this).next('.txt_countdown'), 20);
        });
        
        $('#property-parent_id').on('change', function(){
            location.href='".Url::to(['property/create'])."?parent_id='+ $(this).val();
        });
        
        
        ".($model->parent_id?"$('#property_address_field_depdrop_state').prop('disabled', true);
            $('#property_address_field_depdrop_country').prop('disabled', true);
            $('#property_address_field_depdrop_town').prop('disabled', true);
            $('#property_address_field_depdrop_area').prop('disabled', true);
            $('#property_address_field_depdrop_zip_code').prop('disabled', true);
            $('#property_address_field_depdrop_local_govt_area').prop('disabled', true);
            $('#property_address_field_depdrop_district').prop('disabled', true);
            $('#property-street_address').prop('disabled', true);
            $('#property-street_number').prop('disabled', true);
            $('#property-sub_area').prop('disabled', true);
            $('#property-urban_town_area').prop('disabled', true);
            ":'')."
        
    });";

$this->registerJs($js, View::POS_END);