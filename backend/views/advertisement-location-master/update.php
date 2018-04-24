<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementLocationMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Advertisement Location Master',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisement Location Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="advertisement-location-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
