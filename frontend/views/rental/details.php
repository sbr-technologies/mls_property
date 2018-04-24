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
use common\models\RentalLocationLocalInfo;
use common\models\RentalPlan;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $form yii\widgets\ActiveForm */

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
                        <li role="presentation" class="active"><a href="#location-info" aria-controls="location-info" role="tab" data-toggle="tab">Basic & Location Info</a></li>
                        <li role="presentation"><a href="#land-mark" aria-controls="land-mark" role="tab" data-toggle="tab">Property And land mark</a></li>
                        <li role="presentation"><a href="#price-info" aria-controls="price-info" role="tab" data-toggle="tab">Price and Other Info</a></li>
                        <li role="presentation"><a href="#meta-info" aria-controls="meta-info" role="tab" data-toggle="tab">Meta Info</a></li>
                        <li role="presentation"><a href="#rentalPlan" aria-controls="rentalPlan" role="tab" data-toggle="tab">Rental Plan </a></li>
                        <li role="presentation"><a href="#rentalFeature" aria-controls="rentalPlan" role="tab" data-toggle="tab">Rental Feature </a></li>
                        <li role="presentation"><a href="#open-Houses" aria-controls="open-Houses" role="tab" data-toggle="tab">Open House</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="location-info">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">Title:</label>
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
                                            <label for="">Description:</label>
                                            <?= $model->description  ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Map View:</label>
                                            <div id="dv_property_map_canvas" style="min-height: 105px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
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
                                <h5>Property Location:</h5>
                                <div class="form-sec-box">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="">Address One:</label>
                                            <?= $model->address1  ?>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="">Address Two:</label>
                                            <?= $model->address2  ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Land Mark:</label>
                                            <?= $model->land_mark  ?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="">City:</label>
                                            <?= $model->city  ?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="">State:</label>
                                            <?= $model->state  ?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="">Country:</label>
                                            <?= $model->country  ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Zip Code:</label>
                                            <?= $model->zip_code  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="land-mark">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Metric Type:</label>
                                            <?= $model->metricType->name  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Size:</label>
                                            <?= $model->size  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Max Size:</label>
                                            <?= $model->size_max  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Lot Area</label>
                                            <?= $model->lot_area  ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Max Lot Area</label>
                                            <?= $model->lot_area_max  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Rooms:</label>
                                            <?= $model->no_of_room  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Max Rooms:</label>
                                            <?= $model->no_of_room_max  ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">Balcony:</label>
                                            <?= $model->no_of_balcony  ?>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <label for="">max Balcony:</label>
                                            <?= $model->no_of_balcony_max  ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Bathrooms:</label>
                                            <?= $model->no_of_bathroom  ?>
                                        </div>
                                         <div class="col-sm-3">
                                            <label for="">Max Bathrooms:</label>
                                            <?= $model->no_of_bathroom_max  ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="">Is Lift ?:</label>
                                            <?= $model->isLift  ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">is Furnished ?:</label>
                                            <?= $model->isFurnished  ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">Water Availability ?:</label>
                                            <?= $model->isWaterAvailability  ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">Electricity Availability ?:</label>
                                            <?php 
                                            if(!empty($model->electricityTypes)){
                                                foreach($model->electricityTypes as $electricity){
                                                    echo $electricity->name.", ";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">Is Pet Friendly ?:</label>
                                            <?= $model->petFriendly  ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="">is In Unit Laundry ?:</label>
                                            <?= $model->inUnitLaundry  ?>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="">Is Pools ?:</label>
                                            <?= $model->pool ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        
                                        <div class="col-sm-3">
                                            <label for="">Is Studio ?:</label>
                                            <?= $model->studios  ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="">Is Home ?:</label>
                                            <?= $model->home  ?>
                                        </div>
                                    </div>
                                </div>
                                <h5>Location Local Information:</h5>
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
                    </div>

                    <div role="tabpanel" class="tab-pane" id="price-info">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for=""> Currency :</label>
                                    <?php 
                                        //\yii\helpers\VarDumper::dump($model->currency->name);
                                        if(!empty($model->currency_id)){
                                            echo $model->currency->name;
                                        }else{
                                            echo "N/A";
                                        }
                                    ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Rental Category :</label>
                                    <?= $model->rental_category  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Price For :</label>
                                    <?= $model->price_for  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Price :</label>
                                    <?= $model->price  ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for=""> Service Fee For :</label>
                                    <?= $model->service_fee_for  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Service Fee :</label>
                                    <?= $model->service_fee  ?>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for=""> Other Fee For :</label>
                                    <?= $model->other_fee_for  ?>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for=""> Other Fee :</label>
                                    <?= $model->other_fee  ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="add-property-upload-sec">
                                        <div class="col-sm-12">
                                            <label for=""> Image :</label>
                                            <div class="add-property-upload-images">
                                              <?php 
                                                echo $this->render('//shared/_photo-gallery', ['model' => $model]);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="">Property Category</label>
                                        <?= $model->propertyCategory->title  ?>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="">Property Type</label>
                                        <?= $model->propertyType->title  ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="">Construction Status</label>
                                        <?= $model->constructionStatus->title  ?>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Property Video Link</label>
                                        <?= $model->property_video_link  ?>
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
                    
                    <div role="tabpanel" class="tab-pane" id="rentalPlan">
                        <div class="col-sm-12 form-sec">
                            <?php 
                            //yii\helpers\VarDumper::dump($featureModel); exit;
                            //yii\helpers\VarDumper::dump($featureModel,4,12); exit;
                            if(is_array($rentalPlanModel) && count($rentalPlanModel) > 0){
                                foreach($rentalPlanModel as $rental){
                            ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="">Plan Type</label>
                                                <?= $rental->rentalPlan->name  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Bath</label>
                                                <?= $rental->bath  ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="">Name</label>
                                                <?= $rental->name  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Bed</label>
                                                <?= $rental->bed  ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="">Size</label>
                                                <?= $rental->size  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Price</label>
                                                <?= $rental->price  ?>
                                            </div>
                                        </div>
                                    </div>
                            <div style="height:15px;"></div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="rentalFeature">
                        <div class="col-sm-12 form-sec">
                            <?php 
                            //yii\helpers\VarDumper::dump($featureModel); exit;
                            //yii\helpers\VarDumper::dump($featureModel,4,12); exit;
                            if(is_array($featureModel) && count($featureModel) > 0){
                                foreach($featureModel as $feature){
                            ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="">Feature Name</label>
                                                <?= $feature->featureMaster->name  ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Feature List</label>
                                                <?php 
                                                $itemListArr   =   $feature->rentalFeatureItems;
                                                $slCnt=1;
                                                foreach($itemListArr as $k => $item){
                                                    //yii\helpers\VarDumper::dump($item->name); exit;
                                                ?>
                                                <div class="col-sm-4">
                                                    <label for="">Items<?= $slCnt ?> :</label>
                                                    <?= $item->name  ?>    
                                                </div>
                                                <?php
                                                $slCnt++;
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
                    
                    <div role="tabpanel" class="tab-pane" id="open-Houses">
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Open House Information:</h5>
                                <div class="form-group">
                                    <?php
                                    //yii\helpers\VarDumper::dump($openHouseModel,4,12);exit;
                                    if(isset($openHouseModel) && is_array($openHouseModel) && count($openHouseModel) > 0){
                                        foreach($openHouseModel as $openHouse){
                                        ?>
                                        <div class="row bank-details-box">   
                                            <div class="item new">
                                                <div class="row">
                                                    <div class="form-group col-sm-3">
                                                        <label for="">Start Date</label>
                                                        <?= $openHouse->startdate   ?>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="">End Date</label>
                                                        <?= $openHouse->enddate   ?>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="">Start Time</label>
                                                        <?= $openHouse->starttime  ?>
                                                    </div>
                                                    <div class="form-group col-sm-3">
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
                </div>
            </div>
            <!-- Manage Profile Form -->
        </div>
    </section>
    <!-- Main content -->
</div>
<!-- End right Section ==================================================-->
