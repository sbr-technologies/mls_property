<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\DiscussionPost;
use common\models\DiscussionTag;

/* @var $this yii\web\View */
/* @var $model common\models\DiscussionComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discussion-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id')->dropDownList(ArrayHelper::map(DiscussionPost::find()->all(), 'id', 'title'), ['prompt' => 'Select Post']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'tagIds')->checkboxList(ArrayHelper::map(DiscussionTag::find()->where(['status' => $model::STATUS_ACTIVE])->all(), 'id', 'title')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
