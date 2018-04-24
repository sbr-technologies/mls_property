<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyEnquiery */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Enquiery',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Enquieries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-enquiery-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
