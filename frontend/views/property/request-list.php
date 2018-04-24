<?php

use yii\helpers\Html;
use common\models\PropertyRequest;
use yii\helpers\Url;

$propertiesRequest = PropertyRequest::find()->all();
//\yii\helpers\VarDumper::dump($propertiesRequest,4,12);exit;
$this->title = 'Requested Property List';
?>
<!-- Start Content Section ==================================================-->
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="view-property-request-sec">
                        <h2>View Property Requests</h2>
                        <div class="row">
                            <?php
                            if(!empty($propertiesRequest)){
                                foreach($propertiesRequest as $requestedProperty){
                                    //\yii\helpers\VarDumper::dump($requestedProperty); exit;
                            ?>
                                    <div class="col-sm-4">
                                        <div class="view-property-request-box">
                                            <ul>
                                                <li><div><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-id.png" alt=""> <span>Ref ID:</span> <?= $requestedProperty->referenceId ?></div></li>
                                                <li><div><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-home.png" alt=""> <span>Looking To:</span> <?= $requestedProperty->property_category ?></div></li>
                                                <li><div><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-type.png" alt=""> <span>Type:</span> <?= $requestedProperty->propertyType->title ?></div></li>
                                                <li><div><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-bedroom.png" alt=""> <span>Bedrooms:</span> <?= $requestedProperty->no_of_bed_room ?></div></li>
                                                <li><div><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-money.png" alt=""> <span>Budget:</span> <?= $requestedProperty->budget_from ?> to <?= $requestedProperty->budget_to ?></div></li>
                                                <li><div><img src="<?=Yii::$app->urlManager->baseUrl?>/public_main/images/icon-user.png" alt=""> <span>Post By:</span> <?= $requestedProperty->user->profile->title ?></div></li>
                                            </ul>
                                            <a href="<?php echo Url::to(['property/request-view','request_id' => $requestedProperty->id]) ?>" class="btn btn-default red-btn view-details-btn">View Details</a>
                                        </div>
                                    </div>
                            <?php 
                                }
                            }else{
                            ?>
                            <div class="alert alert-info margine10top">
                                    <i class="fa fa-info"></i>					
                                    No Requested Property found.
                            </div>
                            <?php    
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->