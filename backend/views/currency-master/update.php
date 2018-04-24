<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CurrencyMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Currency Master',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Currency Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="currency-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
