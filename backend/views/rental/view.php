<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Rental */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rentals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</p>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#property" aria-controls="property" role="tab" data-toggle="tab">Property Details</a></li>
    <li role="presentation"><a href="#localInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Location Local Information</a></li>
    <li role="presentation"><a href="#metaTag" aria-controls="metaTag" role="tab" data-toggle="tab">Meta Tag</a></li>
    <li role="presentation"><a href="#rentalPlan" aria-controls="rentalPlan" role="tab" data-toggle="tab">Rental Plan</a></li>
    <li role="presentation"><a href="#rentalFeature" aria-controls="rentalFeature" role="tab" data-toggle="tab">Rental Feature</a></li>
    <li role="presentation"><a href="#openHouses" aria-controls="openHouses" role="tab" data-toggle="tab">Open Houses</a></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="property">
        <div class="rental-view">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'reference_id',
                    'user.fullName',
                    'title',
                    'description:ntext',
                    'country',
                    'state',
                    'city',
                    'address1',
                    'address2',
                    'lat',
                    'lng',
                    'zip_code',
                    'land_mark',
                    'near_buy_location',
                    [
                        'attribute' => 'metricType',
                        'value' => $model->metricType->name
                    ],
                    'size',
                    'lot_area',
                    'no_of_room',
                    'no_of_balcony',
                    'no_of_bathroom',
                    'isLift',
                    'studios',
                    'petFriendly',
                    'inUnitLaundry',
                    'pool',
                    'home',
                    'isFurnished',
                    'isWaterAvailability',
                    ['attribute' => 'electricityTypes',
                        'format' => 'raw',
                        'value' => implode('<br/>------<br/>', ArrayHelper::getColumn($model->electricityTypes, 'name'))
                    ],
                    'currency.name',
                    'rental_category',
                    'price_for',
                    'price',
                    'service_fee_for',
                    'service_fee',
                    'other_fee_for',
                    'other_fee',
                    'property_video_link',
                    
                    [
                        'attribute' => 'propertyType',
                        'value' => $model->propertyType->title
                    ],
                    [
                        'attribute' => 'propertyCategory',
                        'value' => $model->propertyCategory->title
                    ],
                    [
                        'attribute' => 'constructionStatus',
                        'value' => $model->constructionStatus->title
                    ],
                    'watermark_image',
                    'status',
//                    'created_by',
//                    'updated_by',
//                    'created_at',
//                    'updated_at',
                ],
            ]) ?>
            <?php
                echo $this->render('//shared/_photo-gallery', ['model' => $model]);
            ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="localInfo">
        <?php
        $LocalLocationInfoArr   =   $model->rentalLocationLocalInfo;
        if(is_array($LocalLocationInfoArr) && count($LocalLocationInfoArr) > 0){
            ?>
            <div class="container col-md-12 col-lg-12 col-sm-12">
                <?php
                foreach($LocalLocationInfoArr as $locationVal){ ?>
                    <div class="row panel panel-default" style="margin-top: 10px">
                        <div class="col-md-12 col-lg-12 col-sm-12" style="padding-top: 10px">
                            <div class="form-group"><b>Local Info Type :</b>
                                <?= $locationVal->localInfoType->title ?>
                            </div>
                            <div class="form-group"><b>Title :</b>
                                <?= $locationVal->title ?>
                            </div>
                            <div class="form-group"><b>Description :</b>
                                <?= $locationVal->description ?>
                            </div>
                        </div>
                    </div>
                <?php            
                }
                ?>
            </div>
            <?php
        }else{ ?>
            <div class="alert alert-info margine10top" style="margin:10px;">
                    <i class="fa fa-info"></i>					
                    No data found.
            </div>
        <?php 
        }
        ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="metaTag">
        <?php
        $metaTagObj   =   $model->metaTag;
        //\yii\helpers\VarDumper::dump($metaTagObj,11,1); exit;
        if(is_object($metaTagObj)){
        ?>
            <div class="container col-md-12 col-lg-12 col-sm-12">
                <div class="row panel panel-default" style="margin-top: 10px">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="padding-top: 10px">
                        <div class="form-group"><b>Page Title :</b>
                            <?= $metaTagObj->page_title ?>
                        </div>
                        <div class="form-group"><b>Description :</b>
                            <?= $metaTagObj->description ?>
                        </div>
                        <div class="form-group"><b>Keyword :</b>
                            <?= $metaTagObj->keywords ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }else{ ?>
            <div class="alert alert-info margine10top" style="margin:10px;">
                    <i class="fa fa-info"></i>					
                    No data found.
            </div>
        <?php 
        } ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="rentalPlan">
        <?php
        $rentalPlansArr   =   $model->rentalPlans;
        if(is_array($rentalPlansArr) && count($rentalPlansArr) > 0){
            foreach($rentalPlansArr as $rentalPlan){
        ?>
            <div class="container col-md-12 col-lg-12 col-sm-12">
                <div class="row panel panel-default" style="margin-top: 10px">
                    <div class="col-md-12 col-lg-12 col-sm-12" style="padding-top: 10px">
                        <div class="form-group"><b>Plan Type :</b>
                            <?= $rentalPlan->rentalPlan->name ?>
                        </div>
                        <div class="form-group"><b>Name :</b>
                            <?= $rentalPlan->name ?>
                        </div>
                        <div class="form-group"><b>Bed :</b>
                            <?= $rentalPlan->bed ?>
                        </div>
                        <div class="form-group"><b>Bath :</b>
                            <?= $rentalPlan->bath ?>
                        </div>
                        <div class="form-group"><b>Size :</b>
                            <?= $rentalPlan->size ?>
                        </div>
                        <div class="form-group"><b>Price :</b>
                            <?= $rentalPlan->price ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        }else{ ?>
            <div class="alert alert-info margine10top" style="margin:10px;">
                    <i class="fa fa-info"></i>					
                    No data found.
            </div>
        <?php 
        } ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="rentalFeature">
                <?php 
                $featureListArr   =   $model->rentalFeatures;
                
                foreach($featureListArr as $feature){
                ?> 
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="">Feature :</label>
                        <?= $feature->featureMaster->name  ?>    
                    </div>
                    <?php 
                    $itemListArr   =   $feature->rentalFeatureItems;
                    $cnt = 1;
                    foreach($itemListArr as $k => $item){
                        //yii\helpers\VarDumper::dump($item->name); exit;
                    ?>
                    <div class="form-group col-sm-4">
                        <label for="">Items<?= $cnt ?> :</label>
                        <?= $item->name  ?>    
                    </div>
                    <?php
                    $cnt++;
                    }
                    ?> 
                </div>
                <?php
                }
                ?>
            </div>
    <div role="tabpanel" class="tab-pane" id="openHouses">
        <?php
        $openHouseArr   =   $model->openHouses;
        //\yii\helpers\VarDumper::dump($openHouseArr); exit;
        if(is_array($openHouseArr) && count($openHouseArr) > 0){
            ?>
            <div class="container col-md-12 col-lg-12 col-sm-12">
                <?php
                foreach($openHouseArr as $house){ ?>
                    <div class="row panel panel-default" style="margin-top: 10px">
                        <div class="col-md-6 col-lg-6 col-sm-12" style="padding-top: 10px">
                            <div class="form-group"><b>Start Date :</b>
                                <?= $house->startdate ?>
                            </div>
                            <div class="form-group"><b>End Date :</b>
                                <?= $house->enddate ?>
                            </div>

                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12" style="padding-top: 10px">
                            <div class="form-group"><b>Start Time :</b>
                                <?= $house->starttime ?>
                            </div>
                            <div class="form-group"><b>End Time :</b>
                                <?= $house->endtime ?>
                            </div>
                        </div>
                    </div>
                <?php            
                }
                ?>
            </div>
            <?php
        }else{ ?>
            <div class="alert alert-info margine10top" style="margin:10px;">
                    <i class="fa fa-info"></i>					
                    No data found.
            </div>
        <?php 
        }
        ?>
    </div>
</div>

