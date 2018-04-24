<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Holiday Package',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="holiday-package-update">


    <?= $this->render('_form', [
        'model'             => $model,
        'metaTagModel'      =>  $metaTagModel,
        'packageFeature'    =>  $packageFeature,
        'packageFeatureItem'=>  $packageFeatureItem,
    ]) ?>

</div>
