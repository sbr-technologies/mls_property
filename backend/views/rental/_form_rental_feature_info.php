<?php 
use yii\helpers\ArrayHelper;
use common\models\RentalFeatureMaster;
//yii\helpers\VarDumper::dump($featureModel);die();
?>
<div class="dv_rental_feature_info_container">
<?php foreach ($featureModel as $i => $feature){?>
<div class="item">
    <?= $form->field($feature, "[$i]id")->hiddenInput()->label(false) ?>
  
    <?= $form->field($feature, "[$i]feature_master_id")->dropDownList(ArrayHelper::map(RentalFeatureMaster::find()->all(), 'id', 'name'), ['prompt' => 'Select Feature']) ?>

    <?php
    $featureItemModel       =   $feature->rentalFeatureItems;
    //yii\helpers\VarDumper::dump($featureItemModel,4,12); 
    foreach ($featureItemModel as $j => $item){
        ?>
        <?= $form->field($item, "[$i][$j]id")->hiddenInput()->label(false) ?>
        <?= $form->field($item, "[$i][$j]name")->textInput(['maxlength' => true]) ?>
    <?php } ?>
    <?php 
    if(isset($item)){
        $count  =   count($featureItemModel);
    }else{
        $count  =   0;
    }
    //echo $count;
    $tempItem   = new \common\models\RentalFeatureItem();
    
    $maxCount = $count+5;
    for($k = $count; $k <=  $maxCount; $k++ ){
    ?>
    
    <?= $form->field($tempItem, "[$i][$k]id")->hiddenInput()->label(false) ?>
    <?= $form->field($tempItem, "[$i][$k]name")->textInput(['maxlength' => true]) ?>

    <?php } ?>
    <div class="">
        <?= $form->field($feature, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
        <?php if(!$feature->isNewRecord && $i > 0){?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app','Delete row')?>"><i class="fa fa-trash-o"></i></a>
        <?php }?>
    </div>
</div>
<?php }?>
</div>


<button class="btn_add_rental_feature_info" type="button">Add Another</button>