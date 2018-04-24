<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyExteriorMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Exterior Master',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Exterior Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-exterior-master-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
