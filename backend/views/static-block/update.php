<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaticBlock */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Static Block',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="static-block-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
