<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Advertisement;
use common\models\AdvertisementLocationMaster;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertisement-location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ad_id')->dropDownList(ArrayHelper::map(Advertisement::find()->all(), 'id', 'title'), ['prompt' => 'Select Advertisement']) ?>

    <?= $form->field($model, 'location_id')->dropDownList(ArrayHelper::map(AdvertisementLocationMaster::find()->all(), 'id', 'title'), ['prompt' => 'Select Advertisement Location']) ?>

    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => 'Active', $model::STATUS_INACTIVE => 'Inactive'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
