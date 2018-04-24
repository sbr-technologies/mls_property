<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HotelOwnerServiceCategoryMapping */

$this->title = Yii::t('app', 'Create Hotel Owner Service Category Mapping');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Owner Service Category Mappings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-owner-service-category-mapping-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
