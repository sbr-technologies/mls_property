<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PaymentTypeMaster */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Payment Type Master',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Type Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="payment-type-master-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
