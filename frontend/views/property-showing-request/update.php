<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyShowingRequest */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Showing Request',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Showing Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-showing-request-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
