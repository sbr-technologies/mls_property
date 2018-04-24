<?php 
use yii\helpers\ArrayHelper;
//yii\helpers\VarDumper::dump($banner->propertyLocationLocalInfo);die();
?>
<div class="dv_advertisement_banner_info_container">
<?php foreach ($bannerModels as $i => $banner){?>
<div class="item">
    <?= $form->field($banner, "[$i]id")->hiddenInput()->label(false) ?>
  
    <?= $form->field($banner, "[$i]title")->textInput(['maxlength' => true]) ?>

    <?= $form->field($banner, "[$i]description")->textInput(['maxlength' => true]) ?>

    <?= $form->field($banner, "[$i]text_color")->textInput(['maxlength' => true]) ?>
    
    <?php if($banner->isNewRecord){?>
    <?= $form->field($banner, "[$i]imageFiles[]")->fileInput(['accept' => 'image/*']) ?>
    <?php }?>
  
    <?php if(!$banner->isNewRecord){
            echo $this->render('//shared/_photo-gallery', ['model' => $banner, 'single' => true]);
        }
    ?>
    <div class="">
        <?= $form->field($banner, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
        <?php if(!$banner->isNewRecord && $i > 0){?>
        <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app','Delete row')?>"><i class="fa fa-trash-o"></i></a>
        <?php }?>
    </div>
</div>
<?php }?>
</div>
<button class="btn_add_advertisement_banner_info" type="button">Add Another</button>