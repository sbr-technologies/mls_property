<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\BlogPost;

/* @var $this yii\web\View */
/* @var $model common\models\BlogComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id')->dropDownList(ArrayHelper::map(BlogPost::find()->all(), 'id', 'title'), ['prompt' => 'Select Post']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_PENDING => 'Pending', $model::STATUS_APPROVED => 'Approved'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
