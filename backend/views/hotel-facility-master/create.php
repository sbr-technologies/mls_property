<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HotelFacilityMaster */

$this->title = Yii::t('app', 'Create Hotel Facility Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Facility Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-facility-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
