<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeneralFeatureMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'General Feature Master',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'General Feature Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="general-feature-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
