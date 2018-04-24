<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyRequest */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Request',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-request-update">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
