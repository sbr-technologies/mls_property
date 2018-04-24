<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use common\models\TimezoneMaster;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
//use frontend\helpers\AuthHelper;

use common\models\Profile;
use common\models\PropertyType;
use common\models\PropertyCategory;
use common\models\ConstructionStatusMaster;
use common\models\MetricType;
use common\models\User;
use common\models\LocationLocalInfoTypeMaster;
use common\models\FactMaster;
use common\models\PropertyFeatureMaster;
use common\models\CurrencyMaster;
use common\models\GeneralFeatureMaster;
use common\models\Property;

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
/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#locationInfo" aria-controls="location-info" role="tab" data-toggle="tab">Basic & Location Infor<span class="error">*</span></a></li>
    <li role="presentation"><a href="#landMark" aria-controls="land-mark" role="tab" data-toggle="tab">Property Info & Land Mark<span class="error">*</span></a></li>
    <li role="presentation"><a href="#priceInfo" aria-controls="price-info" role="tab" data-toggle="tab">Price & Other Info<span class="error">*</span></a></li>
    <li role="presentation"><a href="#photoVirtual" aria-controls="price-info" role="tab" data-toggle="tab">Property Photos, Virtual Tour & Docs<span class="error">*</span></a></li>
    <li role="presentation"><a href="#features" aria-controls="feature" role="tab" data-toggle="tab">Features</a></li>
    <li role="presentation"><a href="#FeatureGallery" aria-controls="propertyFeature" role="tab" data-toggle="tab">Features Gallery</a></li>
    <li role="presentation"><a href="#metaInfo" aria-controls="meta-info" role="tab" data-toggle="tab">Meta Info<span class="error">*</span></a></li>
    <li role="presentation"><a href="#taxHistory" aria-controls="tax-history" role="tab" data-toggle="tab">Tax Information</a></li>
    <li role="presentation"><a href="#mediaInfo" aria-controls="media-info" role="tab" data-toggle="tab">Social Media Info</a></li>
    <li role="presentation"><a href="#openHouses" aria-controls="open-Houses" role="tab" data-toggle="tab">Open House</a></li>
    <li role="presentation"><a href="#contactInfo" aria-controls="open-Houses" role="tab" data-toggle="tab">Sales Contact Info</a></li>
    <li role="presentation"><a href="#showingInfo" aria-controls="open-Houses" role="tab" data-toggle="tab">Showing Information</a></li>
</ul>
<?php $form = ActiveForm::begin(['method' => 'post','options' => ['class' => 'frm_geocomplete','id' => 'frm_capture_property_data']]); ?>
    <?= $form->field($model, 'save_incomplete')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'save_incomplete'])->label(false) ?>
    <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'id'])->label(false) ?>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="locationInfo">
            <div class="col-sm-12 form-sec">
                <div class="row">           
                    <div class="row">
                        <div class="col-sm-6">
                            <?=
                            $form->field($model, 'parent_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map(Property::find()->where(['is_multi_units_apt' => 1, 'parent_id' => null])->all(), 'id', 'building_name'),
                                'options' => ['placeholder' => 'Select an Apartment', 'class' => 'form-control sel_parent_id'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 add-required">
                                <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map(Profile::find()->where(['id' => [4, 5]])->all(), 'id', 'title'), ['prompt' => 'Select User type','id' => 'profile_id']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                                    'initValueText' => ($model->isNewRecord? '': $model->user->fullName), // set the initial display text
                                    'options' => ['placeholder' => 'Search for a User ...'],
                //                    'disabled' => true,
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumInputLength' => 3,
                                        'language' => [
                                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                        ],
                                        'ajax' => [
                                            'url' => Url::to(['user/index']),
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term, type:"d", profile_id:$("#profile_id").val()}; }')
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <?php  echo $form->field($model, 'property_category_id')->dropDownList(ArrayHelper::map(PropertyCategory::find()->orderBy(['sort_order' => SORT_ASC])->all(), 'id', 'title'), ['prompt' => 'Select Property Category', 'id' => 'property_category_id','onchange' => 'showHideDiv(this.value)']) ?>
                            </div>
                            <div class="col-sm-3 add-required">
                                <?php  echo $form->field($model, 'propertyTypeId[]')->dropDownList(ArrayHelper::map(PropertyType::find()->all(), 'id', 'title'),['multiple' => true ,'id' => 'property_type_id_multiselect', 'class' => 'selectpicker']) ?>
                                <?= $form->field($model, 'property_type_id')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'property_type_id'])->label(false) ?>
                            </div>

                            <div class="col-sm-3 add-required">
                                <?= $form->field($model, 'constructionStatusId[]')->dropDownList(ArrayHelper::map(ConstructionStatusMaster::find()->all(), 'id', 'title'), ['multiple' => true ,'id' => 'construction_status_id_multiselect','class'=>'selectpicker']) ?>
                                <?= $form->field($model, 'construction_status_id')->hiddenInput(['maxlength' => true,'class'=> 'form-control','id' => 'construction_status_id'])->label(false) ?>
                            </div>

                            <div class="col-sm-3">
                                <?= $form->field($model, 'market_status')->dropDownList([$model::MARKET_ACTIVE => 'Active', $model::MARKET_NOTACTIVE => 'Not Active', $model::MARKET_PENDING => 'Pending', $model::MARKET_SOLD => 'Sold', $model::MARKET_COMPS_SOLD => 'Comps Sold', $model::MARKET_CANCELLED => 'Cancelled', $model::MARKET_EXPIRED => 'Expired', $model::MARKET_NOT_AVAILABLE => 'Not Available for Sale', Property::MARKET_LEASED => 'Leased', Property::MARKET_NOT_AVAILABLE_FOR_LEASE => 'Not available for Lease', $model::MARKET_INCOMPLETE => 'Incomplete'],['prompt' => 'Select Status','id' => 'market_status','onchange' => 'showHideSoldDiv(this.value)']) ?>
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
                            <div class="col-sm-6">
                                <?= $form->field($model, 'is_seller_information_show')->checkbox()?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'description')->textarea(['class'=> 'form-control','style'=> 'resize:none;']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php 
                                $model->setlistedDate();
                                echo $form->field($model, 'listedDate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'DD/MM/YYYY'],
                                    'removeButton' => false,
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => Yii::$app->params['dateFormatJs'],
                                        'endDate' => "0d",
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
                                        'endDate' => "+180d",
                                        'todayHighlight' => true,
                                    ]
                                ]);?>
                            </div>
                        </div>
                    </div>
                    <h3>Property Location:</h3>
                    <div class="form-sec-box">
                        <?php echo $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model]) ?>
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
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <?= $form->field($model, 'no_of_room')->dropDownList($range,['prompt' => 'Select No of Rooms','class' => 'selectpicker']) ?>
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
                    <h3>Location Directories:</h3>
                    <?php echo $this->render('_form_local_info', ['model' => $model, 'localInfoModel' => $localInfoModel, 'form' => $form])?>
                    <div class="form-sec-box">
                        <div class="row form-group">
                            
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <button name="" type="button" class="btn_add_property_local_info btn btn-default red-btn"><span>+</span> Add new Location Directory</button>
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
                <div class="row" id="soldDataDiv" style="display:none;">
                    <div class="col-sm-6">
                        <?php echo $form->field($model, 'soldDate')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'DD/MM/YYYY'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => Yii::$app->params['dateFormatJs'],
                                'endDate' => "+0d",
                                'todayHighlight' => true,
                            ]
                        ]);?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'sold_price')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="photoVirtual">
            <div class="row">
                <div class="form-group col-sm-6">
                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true]) ?>
                </div>
                <div class="form-group col-sm-6">
                    <?= $form->field($model, 'virtual_link')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                </div>
            </div>
            <?php 
            if(!$model->isNewRecord){
            ?>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <div id="orderedImageDiv">
                            <?php
                                echo $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true,'update' => true]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        Total <label class="label label-info"># <?= count($model->photos) ?> Images</label> Available
                    </div>
                    <div class="form-group col-sm-6" style="text-align:right;">
                        <?= Html::button(Yii::t('app', '<i class="fa fa-random"></i> Reorder Images') , ['class' => 'btn btn-success bnt_reorder_image','title' => 'Order Image']) ?>
                    </div>
                </div>
            <?php 
            }
            ?>
            <div class="row">
                <div class="form-group col-sm-6">
                    <?= $form->field($model, 'documentFiles[]')->fileInput(['multiple' => true]) ?>
                </div>
            </div>
            <?php 
            if(!$model->isNewRecord){
            ?>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <?php
                            echo $this->render('//shared/_document-gallery', ['model' => $model, 'delete' => true,'update' => true]);
                        ?>
                    </div>
                </div>
            <?php 
            }
            ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="features">
            <div class="col-sm-4 form-sec">
                <div class="form-sec-box">
                    <div class="row">
                        <?php 
                        $genralFeature->general     =   $generalArr;
                        echo $form->field($genralFeature, 'general')->checkBoxList(ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'general'])->all(), 'id', 'name')) ?>  
                    </div>
                </div>
            </div>
            <div class="col-sm-4 form-sec">
                <div class="form-sec-box">
                    <div class="row">
                        <?php 
                        $genralFeature->exterior     =   $generalArr;
                        echo $form->field($genralFeature, 'exterior')->checkBoxList(ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'exterior'])->all(), 'id', 'name')) ?>  
                    </div>
                </div>
            </div>
            <div class="col-sm-4 form-sec">
                <div class="form-sec-box">
                    <div class="row">
                        <?php 
                        $genralFeature->interior     =   $generalArr;
                        echo $form->field($genralFeature, 'interior')->checkBoxList(ArrayHelper::map(GeneralFeatureMaster::find()->where(['type' => 'interior'])->all(), 'id', 'name')) ?>  
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="FeatureGallery">
            <div class="row form-group">
                <?php 
                if($model->isNewRecord){
                
                    echo $this->render('_form_feature_gallery_info', ['model' => $model, 'featureModel' => $featureModel, 'featureItemModel' => $featureItemModel, 'form' => $form]);
                }else{
                    echo $this->render('_form_feature_gallery_info', ['model' => $model, 'featureModel' => $featureModel, 'form' => $form]);
                }             
                ?>
                <div class="clearfix"></div>
                <div class="text-center">
                    <button name="" type="button" class="btn_add_property_feature_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add new Feature Gallery</button>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="metaInfo">
            <div class="col-sm-12 form-sec">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <?php if($model->isNewRecord){$metaTagModel->page_title = '[title]';} ?>
                            <?= $form->field($metaTagModel, 'page_title')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($metaTagModel, 'keywords')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $form->field($metaTagModel, 'description')->textarea(['class'=>'form-control', 'style' => 'resize:none;']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="taxHistory">
            <div class="row form-group">
                <?php echo $this->render('_form_tax_info', ['model' => $model, 'taxHistoryModel' => $taxHistoryModel, 'form' => $form])?>
                <div class="col-sm-12 property_tax_history_container">
                    
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <button name="" type="button" class="btn_add_property_tax_history btn btn-default add-landmark-btn red-btn"><span>+</span> Add New Tax History</button>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="mediaInfo">
            <div class="col-sm-12 form-sec">
                <div class="row">
                    <div class="form-sec-box">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Facebook</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['facebook'])){ 
                                    echo Html::textInput('SocialMediaLink[facebook][url]', isset($agentSocialMediaArr['facebook']['url']) ? $agentSocialMediaArr['facebook']['url'] : '', ['class' => 'form-control social_facebook ','placeholder' => 'Enter Facebook ID']);
                                    echo Html::hiddenInput('SocialMediaLink[facebook][name]', isset($agentSocialMediaArr['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control ','placeholder' => 'Enter Facebook ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[facebook][url]', isset($agentSocialMediaModel['facebook']['url']) ? $agentSocialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook ','placeholder' => 'Enter Facebook ID']);
                                    echo Html::hiddenInput('SocialMediaLink[facebook][name]', isset($agentSocialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control ','placeholder' => 'Enter Facebook ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Twitter:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['twitter'])){ 
                                    echo Html::textInput('SocialMediaLink[twitter][url]', isset($agentSocialMediaArr['twitter']['url']) ? $agentSocialMediaArr['twitter']['url'] : '', ['class' => 'form-control social_twitter ','placeholder' => 'Enter Twitter ID']);
                                    echo Html::hiddenInput('SocialMediaLink[twitter][name]', isset($agentSocialMediaArr['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control ','placeholder' => 'Enter Twitter ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[twitter][url]', isset($agentSocialMediaModel['twitter']['url']) ? $agentSocialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter ','placeholder' => 'Enter Twitter ID']);
                                    echo Html::hiddenInput('SocialMediaLink[twitter][name]', isset($agentSocialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control ','placeholder' => 'Enter Twitter ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Instagram:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['instagram'])){ 
                                    echo Html::textInput('SocialMediaLink[instagram][url]', isset($agentSocialMediaArr['instagram']['url']) ? $agentSocialMediaArr['instagram']['url'] : '', ['class' => 'form-control social_instagram ','placeholder' => 'Enter Instagram ID']);
                                    echo Html::hiddenInput('SocialMediaLink[instagram][name]', isset($agentSocialMediaArr['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control ','placeholder' => 'Enter Instagram ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[instagram][url]', isset($agentSocialMediaModel['instagram']['url']) ? $agentSocialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram ','placeholder' => 'Enter Instagram ID']);
                                    echo Html::hiddenInput('SocialMediaLink[instagram][name]', isset($agentSocialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control ','placeholder' => 'Enter Instagram ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Linkedin:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['linkedin'])){ 
                                    echo Html::textInput('SocialMediaLink[linkedin][url]', isset($agentSocialMediaArr['linkedin']['url']) ? $agentSocialMediaArr['linkedin']['url'] : '', ['class' => 'form-control social_linkedin ','placeholder' => 'Enter Linkedin ID']);
                                    echo Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($agentSocialMediaArr['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control ','placeholder' => 'Enter Linkedin ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[linkedin][url]', isset($agentSocialMediaModel['linkedin']['url']) ? $agentSocialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin ','placeholder' => 'Enter Linkedin ID']);
                                    echo Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($agentSocialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control ','placeholder' => 'Enter Linkedin ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Blog:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['blog'])){ 
                                    echo Html::textInput('SocialMediaLink[blog][url]', isset($agentSocialMediaArr['blog']['url']) ? $agentSocialMediaArr['blog']['url'] : '', ['class' => 'form-control social_blog ','placeholder' => 'Enter Blog ID']);
                                    echo Html::hiddenInput('SocialMediaLink[blog][name]', isset($agentSocialMediaArr['blog']['url']) ? 'blog' : '', ['class' => 'form-control ','placeholder' => 'Enter Blog ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[blog][url]', isset($agentSocialMediaModel['blog']['url']) ? $agentSocialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog ','placeholder' => 'Enter Blog ID']);
                                    echo Html::hiddenInput('SocialMediaLink[blog][name]', isset($agentSocialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control ','placeholder' => 'Enter Blog ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Pinterest:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['pinterest'])){ 
                                    echo Html::textInput('SocialMediaLink[pinterest][url]', isset($agentSocialMediaArr['pinterest']['url']) ? $agentSocialMediaArr['pinterest']['url'] : '', ['class' => 'form-control social_pinterest ','placeholder' => 'Enter Pinterest ID']);
                                    echo Html::hiddenInput('SocialMediaLink[pinterest][name]', isset($agentSocialMediaArr['pinterest']['url']) ? 'pinterest' : '', ['class' => 'form-control ','placeholder' => 'Enter Pinterest ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[pinterest][url]', isset($agentSocialMediaModel['pinterest']['url']) ? $agentSocialMediaModel['pinterest']['url'] : '', ['class' => 'form-control social_pinterest ','placeholder' => 'Enter Pinterest ID']);
                                    echo Html::hiddenInput('SocialMediaLink[pinterest][name]', isset($agentSocialMediaModel['pinterest']['url']) ? 'pinterest' : '', ['class' => 'form-control ','placeholder' => 'Enter Pinterest ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Google:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['goolge'])){ 
                                    echo Html::textInput('SocialMediaLink[goolge][url]', isset($agentSocialMediaArr['goolge']['url']) ? $agentSocialMediaArr['goolge']['url'] : '', ['class' => 'form-control social_goolge ','placeholder' => 'Enter Goolge ID']);
                                    echo Html::hiddenInput('SocialMediaLink[goolge][name]', isset($agentSocialMediaArr['goolge']['url']) ? 'goolge' : '', ['class' => 'form-control ','placeholder' => 'Enter Goolge ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[goolge][url]', isset($agentSocialMediaModel['goolge']['url']) ? $agentSocialMediaModel['goolge']['url'] : '', ['class' => 'form-control social_goolge ','placeholder' => 'Enter Goolge ID']);
                                    echo Html::hiddenInput('SocialMediaLink[goolge][name]', isset($agentSocialMediaModel['goolge']['url']) ? 'goolge' : '', ['class' => 'form-control ','placeholder' => 'Enter Goolge ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">RSS Feed:</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['rss_feed'])){ 
                                    echo Html::textInput('SocialMediaLink[rss_feed][url]', isset($agentSocialMediaArr['rss_feed']['url']) ? $agentSocialMediaArr['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed ','placeholder' => 'Enter Rss Feed ID']);
                                    echo Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($agentSocialMediaArr['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control ','placeholder' => 'Enter Rss Feed ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[rss_feed][url]', isset($agentSocialMediaModel['rss_feed']['url']) ? $agentSocialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed ','placeholder' => 'Enter Rss Feed ID']);
                                    echo Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($agentSocialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control ','placeholder' => 'Enter Rss Feed ID']) ;
                                }
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">You tube :</label>
                                <?php 
                                if(!empty($agentSocialMediaArr['youtube'])){ 
                                    echo Html::textInput('SocialMediaLink[youtube][url]', isset($agentSocialMediaArr['youtube']['url']) ? $agentSocialMediaArr['youtube']['url'] : '', ['class' => 'form-control social_youtube ','placeholder' => 'Enter Youtube ID']);
                                    echo Html::hiddenInput('SocialMediaLink[youtube][name]', isset($agentSocialMediaArr['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control ','placeholder' => 'Enter Youtube ID']) ;
                                }else{ 
                                    echo Html::textInput('SocialMediaLink[youtube][url]', isset($agentSocialMediaModel['youtube']['url']) ? $agentSocialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube ','placeholder' => 'Enter Youtube ID']);
                                    echo Html::hiddenInput('SocialMediaLink[youtube][name]', isset($agentSocialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control ','placeholder' => 'Enter Youtube ID']) ;
                                }
                                ?>
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
            <div class="form-sec-box"> 
                <div class="row">
                    <div id="contactInfoDiv">
                        <?= $this->render('_sales-contacts', ['form' => $form, 'newModel' => $contactModel, 'allModels' => $contactModels]);?>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="showingInfo">
            <?php 
            if($model->isNewRecord){
            ?>
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
            <?php
            }else{
                if(isset($propertyShowingContact) && is_array($propertyShowingContact) && count($propertyShowingContact) > 0){ //echo 12; exit;
                    foreach($propertyShowingContact as $showingKey => $showingContact){
                        $nextshowingKey     =   $showingKey+1;
                ?>
                        <div class="item new add-form-popup col-sm-12">
                            <div class="row admin-box-title">
                                <h3>Showing Contact Person <?= $nextshowingKey ?></h3>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <?= $form->field($showingContact, "[$showingKey]first_name")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <?= $form->field($showingContact, "[$showingKey]middle_name")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <?= $form->field($showingContact, "[$showingKey]last_name")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <?= $form->field($showingContact, "[$showingKey]email")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <?= $form->field($showingContact, "[$showingKey]phone1")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <?= $form->field($showingContact, "[$showingKey]phone2")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <?= $form->field($showingContact, "[$showingKey]phone3")->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <?= $form->field($showingContact, "[$showingKey]key_location")->textInput(['maxlength' => true,'class'=> 'form-control','id' => "geocomplete_key$nextshowingKey"]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <?= $form->field($showingContact, "[$showingKey]showing_instruction")->textarea(['maxlength' => true,'class'=> 'form-control', 'rows' => 5 ,'style' => 'resize:none;']) ?>
                                </div>
                            </div>
                        </div>
                <?php 
                    }
                }
            }
            ?>
        </div>
        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php
$tempLoc        =   new \common\models\PropertyLocationLocalInfo();
$tempTax        =   new \common\models\PropertyTaxHistory(); 
$tempFeatrue    =   new \common\models\PropertyFeature();
$tempItem       =   new \common\models\PropertyFeatureItem(); 
?>

<div style="display: none" class="dv_local_info_block_template">
    <div class="item row new add-form-popup">
        <div class="form-group col-sm-6">
            <?= Html::activeHiddenInput($tempLoc, '[curTime]id')?>
            <?= Html::activeHiddenInput($tempLoc, '[curTime]lat', ['class' => 'lat_curTime'])?>
            <?= Html::activeHiddenInput($tempLoc, '[curTime]lng', ['class' => 'lat_curTime'])?>
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
                                <?php // echo Html::activeLabel($tempItem, '[curTime][1]description')?>
                                <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                <?= Html::activeTextarea($tempItem, '[curTime][1]description', ['class' => 'form-control','rows' => 3, 'style' =>'resize:none;'])?>
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
                        	<?= Html::activeTextarea($tempItem, '[curTime][2]description', ['class' => 'form-control','rows' => 3, 'style' =>'resize:none;'])?>
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
                                <?= Html::activeTextarea($tempItem, '[curTime][3]description', ['class' => 'form-control','rows' => 3, 'style' =>'resize:none;'])?>
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
            location.href='".Url::to(['property/create'])."&parent_id='+ $(this).val();
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