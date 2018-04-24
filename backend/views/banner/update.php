<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Banner',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="banner-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
