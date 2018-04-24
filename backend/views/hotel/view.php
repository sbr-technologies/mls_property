<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Hotel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-view">

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
            <li role="presentation" class="active"><a href="#hotel_info" aria-controls="hotel_info" role="tab" data-toggle="tab">Hotel Info</a></li>
            <li role="presentation"><a href="#meta_tag" aria-controls="meta_tag" role="tab" data-toggle="tab">Meta Tag</a></li>
            <li role="presentation"><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Hotel Facility</a></li>
            <li role="presentation"><a href="#roomFacility" aria-controls="facility" role="tab" data-toggle="tab">Room Facility</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="hotel_info">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'name',
                        'tagline',
                        'description:ntext',
                        'price',
                        'days_no',
                        'night_no',
                        'country',
                        'state',
                        'city',
                        'address1',
                        'address2',
                        'zip_code',
                        'lat',
                        'lng',
                        'estd',
                        'status',
                        'created_by',
                        'updated_by',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            <?= $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true]);?>
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
            
            <div role="tabpanel" class="tab-pane" id="facility">
                <?php
                $hotelFacilityArr   =   $model->hotelFacilities;
                //\yii\helpers\VarDumper::dump($hotelFacilityArr); exit;
                if(is_array($hotelFacilityArr) && count($hotelFacilityArr) > 0){
                    ?>
                    <div class="container col-md-12 col-lg-12 col-sm-12">
                        <?php
                        foreach($hotelFacilityArr as $facilityVal){ ?>
                            <div class="row panel panel-default" style="margin-top: 10px">
                                <div class="col-md-12 col-lg-12 col-sm-12" style="padding-top: 10px">
                                    <div class="form-group"><b>Title :</b>
                                        <?= $facilityVal->title ?>
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
            
            <div role="tabpanel" class="tab-pane" id="roomFacility">
                <?php
                $roomFacilityArr   =   $model->roomFacilities;
                //\yii\helpers\VarDumper::dump($hotelFacilityArr); exit;
                if(is_array($roomFacilityArr) && count($roomFacilityArr) > 0){
                    ?>
                    <div class="container col-md-12 col-lg-12 col-sm-12">
                        <?php
                        foreach($roomFacilityArr as $faciliRoomVal){ ?>
                            <div class="row panel panel-default" style="margin-top: 10px">
                                <div class="col-md-12 col-lg-12 col-sm-12" style="padding-top: 10px">
                                    <div class="form-group"><b>Title :</b>
                                        <?= $faciliRoomVal->title ?>
                                    </div>
                                    <div class="form-group"><b>Description :</b>
                                        <?= $faciliRoomVal->description ?>
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
    </div>
</div>
