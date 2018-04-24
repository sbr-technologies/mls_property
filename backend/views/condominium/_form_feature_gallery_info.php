<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\PropertyFeatureMaster;
//yii\helpers\VarDumper::dump($featureModel);die();
?>
<div class="dv_property_feature_info_container">
    <?php
    if(isset($featureModel) && is_array($featureModel) && count($featureModel) > 0){
        foreach($featureModel as $i => $feature){
        ?>
            <div class="item add-form-popup">
                <div class="form-group col-sm-12">
                    <?= Html::activeHiddenInput($feature, "[$i]id")?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= Html::activeLabel($feature, "[$i]feature_master_id")?>
                                <?= Html::activeDropDownList($feature, "[$i]feature_master_id", ArrayHelper::map(PropertyFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
                            </div>
                            <div class="col-sm-6">
                                <?= Html::activeLabel($feature, "[$i]imageFiles[]")?>
                                <?= Html::activeFileInput($feature, "[$i]imageFiles[]",['multiple' => true])?>
                            </div>
                        </div>
                        <hr class="style16">
                        <?php 
                        if(!$model->isNewRecord){
                        ?>
                            <div class="form-group">
                                <label for="">Uploaded Images:</label>
                                <div class="add-property-upload-images">
                                    <?php
                                    $photos = $feature->photos;
                                    if(!empty($photos) && $photos[0] != NULL){
                                        foreach($photos as $photo){
                                    ?>
                                            <div class="photo_item">
                                                <?php
                                                    // yii\helpers\VarDumper::dump($photo->id, 4, 1);
                                                     echo "<div><img src='".$photo->getImageUrl($photo::THUMBNAIL)."' height='150px' width='200px'/></div>"; 
                                                     echo Html::a(Yii::t('app', '<i class="fa fa-trash"></i>'), ['delete-photo', 'id' => $photo->id], [
                                                         'class' => 'btn btn-danger lnk_delete_image',
                                                         'id' => $photo->id,
                                                         'data' => [
                                                             'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                             'method' => 'post',
                                                         ],
                                                     ]);
                                                ?>
                                            </div>
                                    <?php 
                                        }
                                     }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <hr class="style16">
                    <?php
                    $featureItemModel       =   $feature->featureItems;
                    if(count($featureItemModel) != 0){
                        foreach ($featureItemModel as $j => $item){
                        ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <?= $form->field($item, "[$i][$j]id")->hiddenInput()->label(false) ?>
                                                <?= $form->field($item, "[$i][$j]name")->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <?= $form->field($item, "[$i][$j]size")->textInput(['maxlength' => true,'placeholder' => 'e.g 10X10']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <?php // echo Html::activeLabel($item, "[$i][$j]description")?>
                                                <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                <?= Html::activeTextarea($item, "[$i][$j]description", ['class' => 'form-control','rows' => 5, 'style' =>'resize:none;'])?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }else{
                        $count  =   0;
                        $tempItem   = new \common\models\PropertyFeatureItem();
                        $maxCount = $count+2;
                        for($k = $count; $k <=  $maxCount; $k++ ){
                        ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <?= $form->field($tempItem, "[$i][$k]id")->hiddenInput()->label(false) ?>
                                                <?= $form->field($tempItem, "[$i][$k]name")->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <?= $form->field($tempItem, "[$i][$k]size")->textInput(['maxlength' => true,'placeholder' => 'e.g 10X10']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <?php // echo Html::activeLabel($tempItem, "[$i][$k]description")?>
                                                <label for="propertyfeatureitem-0-0-description">Description (Max 20 Characters)</label>
                                                <?= Html::activeTextarea($tempItem, "[$i][$k]description", ['class' => 'form-control','rows' => 5, 'style' =>'resize:none;'])?>
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
            <div class="">
                <?= $form->field($feature, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
                <?php if (!$feature->isNewRecord && $i > 0) { ?>
                    <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                <?php } ?>
            </div>
        <?php
        }
    }
    ?>
</div>