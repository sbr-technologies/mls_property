<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementLocationMaster */

$this->title = Yii::t('app', 'Create Advertisement Location Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisement Location Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-location-master-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
