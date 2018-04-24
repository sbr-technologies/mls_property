<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $itineraryModel common\models\Hotel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'HolidayPackageItinerary',
]) . $itineraryModel->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $itineraryModel->title, 'url' => ['itinerary-view', 'id' => $itineraryModel->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');


?>
<div class="hotel-update">

    <?= $this->render('_itinerary-form', [
        'itineraryModel'        =>  $itineraryModel,
        'holiday_package_id'    =>  $holiday_package_id,
    ]) ?>

</div>
