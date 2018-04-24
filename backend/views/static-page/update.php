<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaticPage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Static Page',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="static-page-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
