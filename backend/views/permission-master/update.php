<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PermissionMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Permission Master',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="permission-master-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
