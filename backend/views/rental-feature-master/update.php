<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RentalFeatureMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Rental Feature Master',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rental Feature Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rental-feature-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
