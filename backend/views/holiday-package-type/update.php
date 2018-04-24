<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Holiday Package Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="holiday-package-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
