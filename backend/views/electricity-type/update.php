<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ElectricityType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Electricity Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Electricity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="electricity-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
