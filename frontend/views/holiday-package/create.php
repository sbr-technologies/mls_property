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
use common\models\CurrencyMaster;


$this->registerJsFile(
    '@web/js/holidaypackage.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->title = 'Create Holiday Package';

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Add New Holiday Package</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Holiday Management</a></li>
            <li class="active">Add New Holiday Package</li>
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
                        <li role="presentation" class="active"><a href="#holidayInfo" aria-controls="property" role="tab" data-toggle="tab">Package Details</a></li>
                        <li role="presentation"><a href="#packageLocation" aria-controls="packageLocation" role="tab" data-toggle="tab">Package Location</a></li>
                        <li role="presentation"><a href="#ImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Holiday Package Image</a></li>
                        <li role="presentation"><a href="#metaTag" aria-controls="metaTag" role="tab" data-toggle="tab">Meta Tag</a></li>
                        <li role="presentation"><a href="#holidayFeature" aria-controls="holidayFeature" role="tab" data-toggle="tab">Feature</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'frm_geocomplete','id' => 'frm_capture_holiday_data']]); ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="holidayInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(HolidayPackageCategory::find()->all(), 'id', 'title'), ['prompt' => 'Select Package']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(CurrencyMaster::find()->active()->all(), 'id', 'name')) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'package_amount')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'no_of_days')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($model, 'no_of_nights')->textInput(['maxlength' => true,'class'=> 'form-control']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'description')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'hotel_transport_info')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php echo $form->field($model, 'departureDate')->widget(DateTimePicker::classname(), [
                                                    'options' => ['placeholder' => 'Check In','class'=> 'form-control'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => Yii::$app->params['dateTimeFormatJs'],
                                                    ]
                                                ]);?>
                                            </div>
                                            <div class="col-sm-6">
                                               <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'inclusion')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'exclusions')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'payment_policy')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?= $form->field($model, 'cancellation_policy')->textarea(['class'=> 'small-height-textarea','style'=> 'resize:none;']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="packageLocation">
                            <div class="hotel-form">
                                <?php 
                                    echo $this->render('_holiday-source-address', ['model' => $model, 'form' => $form]);
                                ?>
                                <?php 
                                    echo $this->render('_holiday-destination-address', ['model' => $model, 'form' => $form]);
                                ?>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="ImageInfo">
                        	<div class="form-sec-box">
                                <div class="hotel-form">
    
                                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    
                                    <?php 
                                        echo $this->render('//shared/_photo-gallery', ['model' => $model]);
                                    ?>
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
                        <div role="tabpanel" class="tab-pane" id="holidayFeature">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Features:</h5>
                                    <div class="form-sec-box">
                                        <div class="row">
                                            <?php 
                                            $tempFeatrue    =   new \common\models\HolidayPackageFeature();
                                            $tempItem       =   new \common\models\HolidayPackageFeatureItem(); 
                                            ?>
                                            <div class="col-sm-12 dv_holiday_feature_info_container">
                                                
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="text-center">
                                                <button name="" type="button" class="btn_add_holiday_feature_info btn btn-default add-landmark-btn red-btn"><span>+</span> Add New Feature</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center">
                            <?= Html::a(Yii::t('app', 'Cancel'),['holiday-package/list'],['class' => $model->isNewRecord ? 'btn btn-default gray-btn' : 'btn btn-primary gray-btn']) ?>
                            <?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default red-btn bnt_save_holiday_package' : 'btn btn-primary gray-btn']) ?>
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

<div style="display: none" class="dv_holiday_feature_block_template">
    <div class="item new add-form-popup">
        <div class="form-group col-sm-11">
            <?= Html::activeHiddenInput($tempFeatrue, '[curTime]id')?>
            <div class="form-group">
                <?= Html::activeLabel($tempFeatrue, '[curTime]holiday_package_type_id')?>
            <?= Html::activeDropDownList($tempFeatrue, '[curTime]holiday_package_type_id', ArrayHelper::map(HolidayPackageType::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
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

