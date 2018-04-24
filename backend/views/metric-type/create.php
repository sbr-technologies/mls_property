<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetricType */

$this->title = Yii::t('app', 'Create Metric Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metric Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metric-type-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
