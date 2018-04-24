<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyCategory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Category',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
