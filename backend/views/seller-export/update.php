<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Seller */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Seller',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sellers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="seller-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
