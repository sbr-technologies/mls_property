<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageCategory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Holiday Package Category',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="holiday-package-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
