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
use common\models\GeneralFeatureMaster;
use frontend\helpers\AuthHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyAR-AyVns1IfLo5DoeSKms1xJ9XDuN4qCc"></script>
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



$this->title = 'View Property';
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>View Property</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
            <li class="active">View Property</li>
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
                        <li role="presentation"><a href="#contactInfo" aria-controls="open-Houses" role="tab" data-toggle="tab">Contacts Info</a></li>
                        <li role="presentation"><a href="#showingInfo" aria-controls="open-Houses" role="tab" data-toggle="tab">Showing Information</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="locationInfo">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Property Category</label>
                                            <?= $model->propertyCategory->title  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Property Type</label>
                                            <?php 
                                            if(!empty($model->propertyTypeIds)){
                                                foreach($model->propertyTypeIds as $propertyType){
                                                   echo $propertyType->title.",";
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Construction Status</label>
                                            <?php 
                                            if(!empty($model->constructionStatus)){
                                                foreach($model->constructionStatus as $construction){
                                                   echo $construction->title.","; 
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Market Status:</label>
                                            <?= $model->market_status  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Sole Mandate:</label>
                                            <?= $model->soleMandate  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Premium Listing :</label>
                                            <?= $model->preimumLisitng  ?>
                                        </div>
                                        <?php
                                        if(AuthHelper::is('seller')){
                                        ?>
                                            <div class="col-sm-6">
                                                <label for="">Hide seller information ans authorize MLS Properties to handle showings and be the broker :</label>
                                                <?= $model->isSellerInformationShow  ?>
                                            </div>
                                        <?php 
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Title :</label>
                                            <?= $model->title  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Reference ID:</label>
                                            <?= $model->reference_id  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Date Listed :</label>
                                            <?= $model->listedDate  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Date Expiring:</label>
                                            <?= $model->expiredDate  ?>
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
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                   <label for="">Latitude:</label>
                                                    <?= $model->lat  ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="">Longitude:</label>
                                                    <?= $model->lng  ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5>Property Location:</h5>
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

                    <div role="tabpanel" class="tab-pane" id="landMark">
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-sm-3">
                                    <label for="">Metric Type:</label>
                                    <?= $model->metricType->name  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    
                                </div>
                                <div class="form-group col-sm-3">
                                    
                                </div>
                                <div class="form-group col-sm-3">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-sm-4">
                                    <label for="">Lot Size:</label>
                                    <?= $model->lot_size  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Building Size:</label>
                                    <?= $model->building_size  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">House/Unit #:</label>
                                    <?= $model->house_size ?>
                                </div>
<!--                                <div class="form-group col-sm-3">
                                    <label for="">Apartment/Unit :</label>
                                    <?php //echo$model->appartment_units  ?>
                                </div>-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-sm-3">
                                    <label for="">No of Room:</label>
                                    <?= $model->no_of_room  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="">No of Bathroom:</label>
                                    <?= $model->no_of_bathroom  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="">No of Toilets:</label>
                                    <?= $model->no_of_toilet  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="">No of Garage:</label>
                                    <?= $model->no_of_garage  ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-sm-4">
                                    <label for="">No of Boys Quarter:</label>
                                    <?= $model->no_of_boys_quater  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    
                                </div>
                                <div class="form-group col-sm-4">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-sm-4">
                                    <label for="">Year Built:</label>
                                    <?= $model->year_built  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    
                                </div>
                                <div class="form-group col-sm-4">

                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <h3>Location Directories:</h3>
                            <?php
                            if(isset($localInfoModel) && is_array($localInfoModel) && count($localInfoModel) > 0){
                            ?>
                                <div class="form-sec-box">
                                    <div class="row">
                                        <?php
                                        foreach($localInfoModel as $localInfo){
                                        ?>
                                        <div class="col-sm-6">
                                            <div class="bank-details-box">
                                                <h3><?= $localInfo->title ?></h3>
                                                <h6><?= $localInfo->location ?></h6>
                                                <p><?= $localInfo->description ?></p>
                                                <!--<a href="javascript:void(0)" class="bank-details-remove">Remove</a>-->
                                            </div>
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

                    <div role="tabpanel" class="tab-pane" id="priceInfo">
                        <div class="col-sm-12">
                            <div class="row form-group">
                                <div class="form-group col-sm-4">
                                    <label for=""> Currency :</label>
                                    <?php 
                                        if(!empty($model->currency_id)){
                                            echo $model->currency->name;
                                        }
                                    ?>
                                </div>
                                <div class="form-group col-sm-4">
                                </div>
                                <div class="form-group col-sm-4">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <label for=""> Price :</label>
                                    <?= $model->price  ?>
                                </div>
                                <div class="col-sm-4">

                                </div>
                                <div class="col-sm-4">
                                    <label for=""> Payment Term :</label>
                                    <?= $model->price_for  ?>
                                </div>
                            </div>
                            <div id="salePropertyDiv">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for=""> Tax :</label>
                                        <?= $model->tax  ?>
                                    </div>
                                    <div class="form-group col-sm-4">

                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for=""> Tax For:</label>
                                        <?= $model->tax_for  ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for=""> Insurance:</label>
                                        <?= $model->insurance  ?>
                                    </div>
                                    <div class="form-group col-sm-4">

                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for=""> Insurance For:</label>
                                        <?= $model->insurance_for  ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for=""> Home Owner Association Fee (HOA):</label>
                                        <?= $model->hoa_fees  ?>
                                    </div>

                                    <div class="form-group col-sm-4">

                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for=""> HOA For:</label>
                                        <?= $model->hoa_for  ?>
                                    </div>
                                </div>
                            </div>
                            <div id="serviceOtherDiv" >
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for=""> Service Fee :</label>
                                        <?= $model->service_fee  ?>
                                    </div>

                                    <div class="form-group col-sm-4">

                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for=""> Service Payment Term :</label>
                                        <?= $model->service_fee_payment_term  ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for=""> Other Fee :</label>
                                        <?= $model->other_fee  ?>
                                    </div>

                                    <div class="form-group col-sm-4">

                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for=""> Other Payment Term :</label>
                                        <?= $model->other_fee_payment_term  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="form-group col-sm-4">
                                    <label for=""> Contract Term :</label>
                                    <?= $model->contact_term  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    
                                </div>
                                <div class="form-group col-sm-4">
                                    
                                </div>
                            </div>
                            <div class="row" id="soldDataDiv">
                                <div class="form-group col-sm-4">
                                    <label for=""> Sold Date :</label>
                                    <?= $model->sold_date != "0000-00-00" ? Yii::$app->formatter->asDate($model->sold_date) : "Nil"  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for=""> Sold Price :</label>
                                    <?= $model->sold_price ? $model->sold_price : "Nil"  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="photoVirtual">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for=""> Image :</label>
                                <div class="add-property-upload-images">
                                    <?php 
                                    echo $this->render('//shared/_photo-gallery', ['model' => $model, 'view' => true]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for=""> Virtual Tour :</label>
                                <?= $model->virtual_link  ?>
                            </div>
                            <div class="form-group col-sm-6">
                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for=""> Document File :</label>
                                <div class="add-property-upload-images">
                                    <?php 
                                    echo $this->render('//shared/_document-gallery', ['model' => $model, 'view' => true]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="features">
                        <div class="row">
                            <div class="col-sm-4 form-sec">
                                <h5>General Features:</h5>
                                <div class="form-sec-box">
                                    <?php 
                                    $genralFeature = $model->propertyGeneralFeature;
                                    if(!empty($genralFeature)){
                                        foreach ($genralFeature as $general){
                                           if($general->generalFeatureMasters->type == 'general'){
                                    ?>
                                                <div class="form-group">
                                                    <?=  $general->generalFeatureMasters->name ?>
                                                </div>
                                    <?php
                                           }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-4 form-sec">
                                <h5>Exterior Features :</h5>
                                <div class="form-sec-box">
                                    <?php 
                                    $genralFeature = $model->propertyGeneralFeature;
                                    if(!empty($genralFeature)){
                                        foreach ($genralFeature as $general){
                                           if($general->generalFeatureMasters->type == 'exterior'){
                                    ?>
                                                <div class="form-group">
                                                    <?=  $general->generalFeatureMasters->name ?>
                                                </div>
                                    <?php
                                           }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-4 form-sec">
                                <h5>Interior Features :</h5>
                                <div class="form-sec-box">
                                    <?php 
                                    $genralFeature = $model->propertyGeneralFeature;
                                    if(!empty($genralFeature)){
                                        foreach ($genralFeature as $general){
                                           if($general->generalFeatureMasters->type == 'interior'){
                                    ?>
                                                <div class="form-group">
                                                    <?=  $general->generalFeatureMasters->name ?>
                                                </div>
                                    <?php
                                           }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="FeatureGallery">
                        <div class="col-sm-12">
                            <?php 
                            if(is_array($featureModel) && count($featureModel) > 0){
                                foreach($featureModel as $feature){
                            ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Feature Name</label>
                                            <?= $feature->featureMaster->name  ?>
                                        </div>
                                        <div class="col-sm-9">
                                            <label for="">Feature List</label>
                                            <?php 
                                            $itemListArr   =   $feature->featureItems;
                                            $i = 1;
                                            //yii\helpers\VarDumper::dump($itemListArr); 
                                            foreach($itemListArr as $k => $item){

                                            ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="">Items<?= $i ?> :</label>
                                                    <?= $item->name  ?>    
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="">Size<?= $i ?> (m) :</label>
                                                    <?= $item->size  ?>    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="">Description<?= $i ?> :</label>
                                                    <?= $item->description  ?> 
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <h4>Uploaded Images</h4>
                                            <?php
                                            $photos = $feature->photos;
                                            if(!empty($photos) && $photos[0] != NULL){
                                            ?>
                                            
                                            <?php
                                                foreach($photos as $photo){
                                                   // yii\helpers\VarDumper::dump($photo->id, 4, 1);
                                                    echo "<div class='col-sm-3' style= 'margin-top:10px;'><img src='".$photo->getImageUrl($photo::THUMBNAIL)."' height='150px' width='200px'/></div>"; ?>
                                                    <?php if(isset($delete) && $delete === true){
                                                        echo Html::a(Yii::t('app', '<i class="fa fa-trash"></i>'), ['delete-photo', 'id' => $photo->id], [
                                                            'class' => 'btn btn-danger lnk_delete_image',
                                                            'id' => $photo->id,
                                                            'data' => [
                                                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                                'method' => 'post',
                                                            ],
                                                        ]);
                                                    }
                                                }
                                                ?>                                         
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="metaInfo">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Page Title</label>
                                            <?= $metaTagModel->page_title  ?>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="">Keywords</label>
                                            <?= $metaTagModel->keywords  ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Description</label>
                                    <?= $metaTagModel->description  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="taxHistory">
                        <div class="col-sm-12">
                            <div class="row">
                                <h5>Property Tax Information:</h5>
                                <div class="form-group">
                                    <?php
                                    if(isset($taxHistoryModel) && is_array($taxHistoryModel) && count($taxHistoryModel) > 0){
                                        foreach($taxHistoryModel as $taxHistory){
                                        ?>
                                        <div class="row bank-details-box">   
                                            <div class="item new">
                                                <div class="form-group col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-sm-6">
                                                            <label for="">Tax Year</label>
                                                            <?= $taxHistory->year  ?>
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <label for="">Taxes</label>
                                                            <?= $taxHistory->taxes  ?>
                                                        </div>
                                                    </div>
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
                    </div>
                    <div role="tabpanel" class="tab-pane" id="mediaInfo">
                        <div class="col-sm-12">
                            <div class="row">
                                <h5>Social Media Link:</h5>
                                <div class="form-sec-box">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="">Facebook</label>
                                            <?= isset($agentSocialMediaArr['facebook']['url']) ? $agentSocialMediaArr['facebook']['url'] : '' ?>

                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Twitter:</label>
                                            <?= isset($agentSocialMediaArr['twitter']['url']) ? $agentSocialMediaArr['twitter']['url'] : '' ?>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="">Instagram:</label>
                                            <?= isset($agentSocialMediaArr['instagram']['url']) ? $agentSocialMediaArr['instagram']['url'] : '' ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Linkedin:</label>
                                            <?= isset($agentSocialMediaArr['linkedin']['url']) ? $agentSocialMediaArr['linkedin']['url'] : '' ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Blog:</label>
                                            <?= isset($agentSocialMediaArr['blog']['url']) ? $agentSocialMediaArr['blog']['url'] : '' ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Pinterest:</label>
                                            <?= isset($agentSocialMediaArr['pinterest']['url']) ? $agentSocialMediaArr['pinterest']['url'] : '' ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Google:</label>
                                            <?= isset($agentSocialMediaArr['goolge']['url']) ? $agentSocialMediaArr['goolge']['url'] : '' ?>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="">RSS Feed:</label>
                                            <?= isset($agentSocialMediaArr['rss_feed']['url']) ? $agentSocialMediaArr['rss_feed']['url'] : '' ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">You tube :</label>
                                            <?= isset($agentSocialMediaArr['youtube']['url']) ? $agentSocialMediaArr['youtube']['url'] : '' ?>
                                        </div>
                                    </div>
                                </div>   
                            </div>

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="openHouses">
                        <div class="col-sm-12">
                            <div class="row">
                                <h5>Open House :</h5>
                                <div class="form-group">
                                    <?php
                                    //yii\helpers\VarDumper::dump($openHouseModel,4,12);exit;
                                    if(isset($openHouseModel) && is_array($openHouseModel) && count($openHouseModel) > 0){
                                        foreach($openHouseModel as $openHouse){
                                        ?>
                                        <div class="row bank-details-box">   
                                            <div class="item new">
                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        <label for="">Start Date</label>
                                                        <?= $openHouse->startdate   ?>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                         <label for="">End Date</label>
                                                        <?= $openHouse->enddate   ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        <label for="">Start Time</label>
                                                        <?= $openHouse->starttime  ?>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="">End Time</label>
                                                        <?= $openHouse->endtime  ?>
                                                    </div>
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
                    </div>
                    <div role="tabpanel" class="tab-pane" id="contactInfo">
                        
                    </div>
                    <div role="tabpanel" class="tab-pane" id="showingInfo">
                        <?php
                        if(!empty($propertyShowingContact)){
                            foreach($propertyShowingContact as $showingKey => $showingContact){
                        ?>
                        <div class="item new add-form-popup col-sm-12">
                            <div class="row admin-box-title">
                                <h3>Showing Contact Person <?= $showingKey+1 ?></h3>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for=""> First Name :</label>
                                    <?= $showingContact->first_name  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Middle Name :</label>
                                    <?= $showingContact->middle_name  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Last Name :</label>
                                    <?= $showingContact->last_name  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Email :</label>
                                    <?= $showingContact->email  ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for=""> Phone1 :</label>
                                    <?= $showingContact->phone1  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for=""> Phone2 :</label>
                                    <?= $showingContact->phone2  ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for=""> Phone3 :</label>
                                    <?= $showingContact->phone3  ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for=""> Key Location & Key Address :</label>
                                    <?= $showingContact->key_location  ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for=""> Showing Instruction :</label>
                                    <?= $showingContact->showing_instruction  ?>
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
            <!-- Manage Profile Form -->
        </div>
    </section>
    <!-- Main content -->
</div>
<!-- End right Section ==================================================-->
