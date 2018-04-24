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


$this->title = 'View Holiday Package';

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>View Holiday Package</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Holiday Management</a></li>
            <li class="active">View Holiday Package</li>
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
                        <li role="presentation" class="active"><a href="#holidayInfo" aria-controls="property" role="tab" data-toggle="tab">Package Details</a></li>
                        <li role="presentation"><a href="#packageLocation" aria-controls="packageLocation" role="tab" data-toggle="tab">Package Location</a></li>
                        <li role="presentation"><a href="#ImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Holiday Package Image</a></li>
                        <li role="presentation"><a href="#metaTag" aria-controls="metaTag" role="tab" data-toggle="tab">Meta Tag</a></li>
                        <li role="presentation"><a href="#holidayFeature" aria-controls="holidayFeature" role="tab" data-toggle="tab">Feature</a></li>
                    </ul>
                </div>
                <?php $form = ActiveForm::begin(['options' => ['class' => '','id' => 'frm_capture_holiday_data']]); ?>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="holidayInfo">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Category Name :</label>
                                                <?= $model->category->title  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Name :</label>
                                                <?= $model->name  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="">Package Amount :</label>
                                                <?= $model->package_amount  ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="">No. of Days :</label>
                                                <?= $model->no_of_days  ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="">No. of Nights :</label>
                                                <?= $model->no_of_nights  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Description :</label>
                                                <?= $model->description  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Hotel Transport Info:</label>
                                                <?= $model->hotel_transport_info  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Departure Date :</label>
                                                <?= date("d-m-Y",$model->departure_date)  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Status :</label>
                                                <?= $model->status  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Inclusion :</label>
                                                <?= $model->inclusion  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Exclusions :</label>
                                                <?= $model->exclusions  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Payment Policy :</label>
                                                <?= $model->payment_policy  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Cancellation Policy :</label>
                                                <?= $model->cancellation_policy  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="packageLocation">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <h5>Source Address </h5>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Source Address :</label>
                                                <?= $model->source_address  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Source City :</label>
                                                <?= $model->source_city  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Source State :</label>
                                                <?= $model->source_state  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Source Country</label>
                                                <?= $model->source_country  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Destination Address </h5>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Destination Address :</label>
                                                <?= $model->destination_address  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Destination City :</label>
                                                <?= $model->destination_city  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Destination State :</label>
                                                <?= $model->destination_state  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Destination Country :</label>
                                                <?= $model->destination_country  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="ImageInfo">
                            <div class="hotel-form">
                                <?php 
                                    echo $this->render('//shared/_photo-gallery', ['model' => $model]);
                                ?>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="metaTag">
                            <div class="col-sm-12 form-sec">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">Page Title :</label>
                                                <?= $metaTagModel->page_title  ?>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="">Keyword :</label>
                                                <?= $metaTagModel->keywords  ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Description :</label>
                                        <?= $metaTagModel->description  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="holidayFeature">
                            <div class="col-sm-12 form-sec">
                                <?php 
                                //yii\helpers\VarDumper::dump($featureModel); exit;
                                //yii\helpers\VarDumper::dump($featureModel,4,12); exit;
                                if(is_array($packageFeature) && count($packageFeature) > 0){
                                    foreach($packageFeature as $feature){
                                ?>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <label for="">Feature Name</label>
                                                    <?= $feature->holidayPackageType->name  ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="">Feature List</label>
                                                    <?php 
                                                    $itemListArr   =   $feature->holidayPackageFeatureItems;

                                                    foreach($itemListArr as $k => $item){
                                                        //yii\helpers\VarDumper::dump($item->name); exit;
                                                    ?>
                                                    <div class="col-sm-4">
                                                        <label for="">Items<?= $k ?> :</label>
                                                        <?= $item->name  ?>    
                                                    </div>
                                                    <?php
                                                    }
                                                    ?> 
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
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
