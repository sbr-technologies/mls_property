<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BannerType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Banner Type',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="banner-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
