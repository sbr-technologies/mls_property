<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetricType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Metric Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metric Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="metric-type-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
