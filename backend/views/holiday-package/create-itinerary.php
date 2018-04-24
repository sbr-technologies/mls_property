<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Hotel */

$this->title = Yii::t('app', 'Create Itinerary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="hotel-create">
    <?= $this->render('_itinerary-form', [
        'itineraryModel'        => $itineraryModel, 
        'holiday_package_id'    => $holiday_package_id,
    ]) ?>

</div>
