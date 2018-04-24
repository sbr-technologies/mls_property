<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HotelEnquiry */

$this->title = Yii::t('app', 'Create Hotel Enquiry');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Enquiries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-enquiry-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
