<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BlogPostCategory;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(BlogPostCategory::find()->all(), 'id', 'title'), ['prompt' => 'Select Blog Category', 'id' => 'category_id']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_PENDING => 'Pending', $model::STATUS_PUBLISHED => 'Published'],['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    
    <?php 
        echo $this->render('//shared/_photo-gallery', ['model' => $model]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
