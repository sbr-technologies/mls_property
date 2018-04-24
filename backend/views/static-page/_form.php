<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\StaticPage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="static-page-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'content')->widget(TinyMce::className(), [
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | languages",
        ],
        'options' => ['rows' => 12],
    ]);
    ?>
    
    <?php if(!$model->isNewRecord){?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'disabled' => true]) ?>
    <?php }?>
    <?php 
    if($model->isNewRecord){
        $model->meta_title = '[name] | [site_name]';
    }
    ?>
    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput() ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(['active' => 'Active', 'inactive' => 'Inactive'],['prompt' => 'Select Status']) ?>
    
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    
    <?php 
        echo $this->render('//shared/_photo-gallery', ['model' => $model]);
    ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
