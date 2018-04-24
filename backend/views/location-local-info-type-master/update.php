<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LocationLocalInfoTypeMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Location Local Info  Master',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Location Local Info Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="location-local-info-type-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
