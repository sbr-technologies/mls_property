<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Advertisement',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="advertisement-update">


    <?= $this->render('_form', [
        'model' => $model, 'bannerModels' => $bannerModels
    ]) ?>

</div>
