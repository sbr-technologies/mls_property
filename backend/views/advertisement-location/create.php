<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementLocation */

$this->title = Yii::t('app', 'Create Advertisement Location');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisement Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-location-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
