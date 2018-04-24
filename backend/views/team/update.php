<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Team */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Team',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-update">

    <?= $this->render('_form', [
        'model'                 => $model
    ]) ?>

</div>
