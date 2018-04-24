<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RentalPlanType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Rental Plan Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rental Plan Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rental-plan-type-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
