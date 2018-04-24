<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ConstructionStatusMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Construction Status Master',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Construction Status Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="construction-status-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
