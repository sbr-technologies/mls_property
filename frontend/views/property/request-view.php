<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use kartik\date\DatePicker;

$this->title = 'Requested Property Details';
//\yii\helpers\VarDumper::dump($propertyRequest,4,12); exit;
?>

<!-- Start Content Section ==================================================-->
<section>
    <!-- Property Menu Bar -->
    <?php
    //echo $this->render('//shared/_property_search_filtter', []);
    ?>
    <!-- Property Menu Bar -->

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if(!empty($propertyRequest)){
                    ?>
                    <div class="property-request-sec property-request-details-sec">
                        <h2>Property Requests Details for <span>ref: <?= $propertyRequest->referenceId ?></span></h2>
                        <div class="property-request-box">
                            <h3>Property Details</h3>
                            <div class="property-request-box-inner">
                                <div class="col-sm-3">
                                    <p><i class="fa fa-home" aria-hidden="true"></i> Looking to: <span class="redTxt"><?= $propertyRequest->property_category ?></span></p>
                                    <p><i class="fa fa-file-code-o" aria-hidden="true"></i> Type: <span class="redTxt"><?= $propertyRequest->propertyType->title ?></span></p>
                                    <p><i class="fa fa-bed" aria-hidden="true"></i> No. of Bedrooms: <span class="redTxt"><?= $propertyRequest->no_of_bed_room ?></span></p>
                                </div>

                                <div class="col-sm-3">
                                    <p><i class="fa fa-money" aria-hidden="true"></i> Budget: <span class="redTxt"><?= $propertyRequest->budget_from ?> to <?= $propertyRequest->budget_to ?></span></p>
                                    <p><i class="fa fa-map" aria-hidden="true"></i> State: <span class="redTxt"><?= $propertyRequest->state ?></span></p>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> Locality: <span class="redTxt"><?= $propertyRequest->locality ?></span></p>
                                </div>

                                <div class="col-sm-6">
                                    <p><i class="fa fa-comments-o" aria-hidden="true"></i> Comments:</p>
                                    <p><?= $propertyRequest->comment ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="property-request-box">
                            <h3>Requested By</h3>
                            <div class="property-request-box-inner">
                                <div class="col-sm-3">
                                    <p><i class="fa fa-user" aria-hidden="true"></i> Post By: <span class="redTxt"><?= $propertyRequest->user->profile->title ?></span></p>
                                </div>

                                <div class="col-sm-3">
                                    <p><i class="fa fa-user-circle-o" aria-hidden="true"></i> Name: <span class="redTxt"><?= $propertyRequest->user->fullName ?></span></p>
                                </div>

                                <div class="col-sm-3">
                                    <p><i class="fa fa-envelope" aria-hidden="true"></i> Email: <span class="redTxt"><?= $propertyRequest->user->email ?></span></p>
                                </div>

                                <div class="col-sm-3">
                                    <p><i class="fa fa-phone" aria-hidden="true"></i> Phone No.: <span class="redTxt"><?= $propertyRequest->user->mobile1 ?></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="property-request-box">
                            <h3>Request Details</h3>
                            <div class="property-request-box-inner">
                                <div class="col-sm-3">
                                    <p><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Ref No.: <span class="redTxt"><?= $propertyRequest->referenceId ?></span></p>
                                </div>

                                <div class="col-sm-3">
                                    <p><i class="fa fa-calendar" aria-hidden="true"></i> Date: <span class="redTxt"><?= Yii::$app->formatter->asDate($propertyRequest->schedule) ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->