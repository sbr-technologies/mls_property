<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\JobApplication */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Job Application',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Job Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="job-application-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
