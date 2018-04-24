<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyFeatureMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property Feature Master',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Feature Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-feature-master-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
