<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackage */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-package-view">


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
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#package_details" aria-controls="package_details" role="tab" data-toggle="tab">Package Details</a></li>
            <li role="presentation"><a href="#packageLocation" aria-controls="packageLocation" role="tab" data-toggle="tab">Package Location</a></li>
            <li role="presentation"><a href="#ImageInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Holiday Package Image</a></li>
            <li role="presentation"><a href="#meta_tag" aria-controls="meta_tag" role="tab" data-toggle="tab">Meta Tag</a></li>
            <li role="presentation"><a href="#packageFeature" aria-controls="packageFeature" role="tab" data-toggle="tab">Package Feature</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="package_details">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                       //'id',
                        'user.fullName',
                        'category.title',
                        'name',
                        'description:ntext',
                        'package_amount',
                        'no_of_days',
                        'no_of_nights',
                        'hotel_transport_info:ntext',
                        'departure_date:datetime',
                        'inclusion:ntext',
                        'exclusions:ntext',
                        'payment_policy:ntext',
                        'cancellation_policy:ntext',
                        'status',
//                        'created_by',
//                        'updated_by',
//                        'created_at:datetime',
//                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="packageLocation">
                <div class="hotel-form">
                    <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                       //'id',
                        'source_address',
                        'source_city',
                        'source_state',
                        'source_country',
                        'destination_address',
                        'destination_city',
                        'destination_state',
                        'destination_country',
                        
                    ],
                ]) ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="ImageInfo">
                <?php 
                echo $this->render('//shared/_photo-gallery', ['model' => $model]);
            ?>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="meta_tag">
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
                    <div class="alert alert-info margine10top">
                            <i class="fa fa-info"></i>					
                            No data found.
                    </div>
                <?php 
                } ?>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="packageFeature">
                <?php 
                $featureListArr   =   $model->holidayFeatures;
                
                foreach($featureListArr as $feature){
                ?> 
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="">Feature :</label>
                        <?= $feature->holidayPackageType->name  ?>    
                    </div>
                    <?php 
                    $itemListArr   =   $feature->holidayPackageFeatureItems;
                    
                    foreach($itemListArr as $k => $item){
                        //yii\helpers\VarDumper::dump($item->name); exit;
                    ?>
                    <div class="form-group col-sm-4">
                        <label for="">Items<?= $k ?> :</label>
                        <?= $item->name  ?>    
                    </div>
                    <?php
                    }
                    ?> 
                    
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
