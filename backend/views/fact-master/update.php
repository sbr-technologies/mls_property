<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FactMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Fact Master',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fact Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fact-master-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
