<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HotelOwnerServiceCategoryMapping */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Hotel Owner Service Category Mapping',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Owner Service Category Mappings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="hotel-owner-service-category-mapping-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
