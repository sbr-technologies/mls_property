<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdvertisementBanner */

$this->title = Yii::t('app', 'Create Advertisement Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisement Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-banner-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
