<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\PropertyType;
use common\models\ConstructionStatusMaster;

//yii\helpers\VarDumper::dump($model,4,12); exit;
$this->title = $model->name;
?>
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 cms-content-sec">
                    <h2 class="content-title">Agency Details</h2>
                    <div class="row">
                        <?php if (!empty($model)) { ?>  
                            <div class="col-sm-6">
                                <table border="0" cellpadding="" cellspacing="" class="agency_details_listing">
                                    <tr>
                                        <td>Agency ID:</td>
                                        <td><?= $model->agencyID ?></td>
                                    </tr>
                                    <tr>
                                        <td>Agency Name:</td>
                                        <td><?= $model->name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Owner Name:</td>
                                        <td><?= $model->owner_name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td><?= $model->formattedAddress ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td><?= $model->mobile ?></td>
                                    </tr>
                                    <tr>
                                        <td>Established:</td>
                                        <td><?= $model->estd ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. of <?= $agentCnt > 1 ? "Agents:": "Agent:" ?></td>
                                        <td><?= $agentCnt ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-5 agency_details_img">
                                <?php
                                if (!empty($model->photos[0])) {
                                    ?>
                                <img src="<?= $model->photos[0]->imageUrl ?>" alt="" height="400px">
                                    <?php
                                } else {
                                    echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no-preview.jpg'), [
                                        'class' => '','height' => '250px;',
                                    ]);
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 listing_activity_list" id="PropertyActivity">
                    <h2>Listing Activity</h2>
                    <?php
                    if(is_array($propertyArr[0]) && count($propertyArr[0]) > 0){ 
                       // \yii\helpers\VarDumper::dump($propertyArr,12,4);exit;echo 11;
                    ?>
                    <div class="row listing-activity-list-sec">
                        <?php
                        foreach($propertyArr as $properties){
                            foreach($properties as $property){
                            
                        ?>
                        <div class="col-sm-3">
                            <a href="javascript:void(0)" class="listing-activity-list">
                              <?php
                                    $photosArr = $property->photos;
                                    if(is_array($photosArr) && count($photosArr) > 0){
                                        foreach($photosArr as $photoKey => $photoVal){
                                            if($photoKey == 0){
                                                  if(isset($photoVal) && $photoVal != ''){
                                                      $alias = $photoVal->getImageUrl($photoVal::MEDIUM);
                                                      echo Html::img($alias);
                                                  }
                                            }
                                        }
                                    }else{
                                        echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'));
                                    }
                                  ?>

                              <div class="overlay-activity-img"></div>
                              <span class="for-sale">
                                <?php
                                if(!empty($property->propertyTypeId)){
                                    echo implode(',', ArrayHelper::getColumn(common\models\PropertyType::find()->where(['id' => $property->propertyTypeId])->all(), 'title'));
                                }
                                ?>
                              </span>
                              <p><?= $property->shortAddress ?> <span><?= $property->price ?></span> <?= $property->no_of_room ?>bd <?= $property->no_of_bathroom ?>ba</p>
                            </a>

                        </div>
                        <?php 
                            }
                        }
                        ?>
                        <?php
                        if(count($properties) > 8){
                        ?>
                            <div class="col-sm-12 text-center">
                              <a href="javascript:void(0)" class="btn btn-default listing-activity-view-more">View More</a>
                            </div>
                        <?php 
                        }
                        ?>
                    </div>
                <?php 
                    }else{
                        ?>
                        <div class="alert alert-info margine10top">
                            <i class="fa fa-info"></i>					
                            No listing activity found.
                        </div>
                    <?php
                    }
                ?>
            </div>
            </div>
        </div>
    </div>
</section>