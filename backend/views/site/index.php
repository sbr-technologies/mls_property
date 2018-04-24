<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\web\View;
use common\models\Property;
use common\models\Testimonial;
use common\models\PropertyShowingRequest;
$this->title = 'Dashboard';
$propertyCnt        =   Property::find()->count();
$soldPropertyCnt    =   Property::find()->where(['market_status' => 'Sold'])->count();
$testimonialCnt     =   Testimonial::find()->where(['model' => 'Property'])->count(); 
$requestCnt         =   PropertyShowingRequest::find()->count(); 

$requestArr         =   PropertyShowingRequest::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();
$propertyArr        =   Property::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();
?>

<!-- Content Header (Page header) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $propertyCnt ?></h3>
                <p>Total Property</p>
            </div>
            <div class="icon">
                <i class="fa fa-pie-chart" aria-hidden="true"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $testimonialCnt ?></h3>
                <p>Feedback</p>
            </div>
            <div class="icon">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $requestCnt ?></h3>
                <p>Total Request</p>
            </div>
            <div class="icon">
                <i class="fa fa-rocket" aria-hidden="true"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?= $soldPropertyCnt ?></h3>
                <p>Sold Property</p>
            </div>
            <div class="icon">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <section class="col-lg-6 connectedSortable">
        <!-- Chat box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <i class="fa fa-pie-chart"></i>
                <h3 class="box-title">Recent 10 Property List</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>  
                </div>
            </div>
            <div class="box-body">
                <?php 
                if(!empty($propertyArr)){
                ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Sl.</th>
                                <th>Title</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            $slCnt = 1;
                            foreach($propertyArr as $property){
                            ?>
                                <tr>
                                    <td>
                                        <?= $slCnt ?>
                                    </td>
                                    <td><?= $property->formattedAddress ?></td>
                                    <td><?= $property->status ?></td>
                                </tr>
                            <?php 
                            $slCnt++;
                            } ?>
                        </tbody>
                    </table>
                <?php }else{ ?>
                    <div class="alert alert-info margine10top">
                        <i class="fa fa-info"></i>					
                        No data found.
                    </div>
                <?php } ?>
            </div>
            <!-- /.chat -->
        </div>
        <!-- /.box (chat box) -->
    </section>
    <section class="col-lg-6 connectedSortable">
        <!-- Chat box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-rocket"></i>
                <h3 class="box-title">Latest 10 Recent Request</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>  
                </div>
            </div>
            <div class="box-body">
                <?php 
                if(!empty($requestArr)){
                ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>sl.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Request for</th>
                                </thead>
                            </tr>
                            <?php
                            $slCnt = 1;
                            foreach($requestArr as $request){
                            ?>
                                <tr>
                                    <td>
                                        <?= $slCnt ?>
                                    </td>
                                    <td><?= $request->name ?></td>
                                    <td><?= $request->email ?></td>
                                    <td><?php if(isset($request->property)) echo $request->property->title ?></td>
                                </tr>
                            <?php 
                            $slCnt++;
                            } ?>
                        </tbody>
                    </table>
                <?php }else{ ?>
                    <div class="alert alert-info margine10top">
                        <i class="fa fa-info"></i>					
                        No data found.
                    </div>
                <?php } ?>
            </div>
            <!-- /.chat -->
        </div>
        <!-- /.box (chat box) -->
    </section>
</div>
          

