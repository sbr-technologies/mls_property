<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Type',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
