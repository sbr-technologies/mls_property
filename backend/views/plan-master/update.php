<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PlanMaster */

$url = ['index'];
if($model->for_agency){
    $url = ['agency'];
}

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Plan Master',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plan Masters'), 'url' => $url];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="plan-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
