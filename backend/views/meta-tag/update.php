<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetaTag */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Meta Tag',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meta Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="meta-tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
