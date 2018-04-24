<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementLocation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Advertisement Location',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisement Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="advertisement-location-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
