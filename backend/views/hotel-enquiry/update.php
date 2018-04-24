<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HotelEnquiry */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Hotel Enquiry',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Enquiries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="hotel-enquiry-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
