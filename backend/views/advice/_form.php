<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\AdviceCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Advice */
/* @var $form yii\widgets\ActiveForm */
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#newsDetails" aria-controls="newsDetails" role="tab" data-toggle="tab">Advice Details</a></li>
    <li role="presentation"><a href="#newsImageInfo" aria-controls="newsImageInfo" role="tab" data-toggle="tab">Advice Image</a></li>
</ul>
<?php $form = ActiveForm::begin(); ?>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="newsDetails">
        <div class="advice-form">

            <?= $form->field($model, 'advice_category_id')->dropDownList(ArrayHelper::map(AdviceCategory::find()->active()->all(), 'id', 'name'), ['prompt' => 'Select Advice Category']) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true,'id' => 'title']) ?>

            <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'id' => 'slug','readonly' => 'readonly']) ?>

            <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="newsImageInfo">
        <div class="news-form">
            <?= $form->field($model, 'imageFiles[]')->fileInput(['accept' => 'image/*']) ?>
            <?php
                echo $this->render('//shared/_photo-gallery', ['model' => $model, 'single' => true]);
            ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
