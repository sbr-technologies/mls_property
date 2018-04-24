<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdviceCategory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Advice Category',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advice Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="advice-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
