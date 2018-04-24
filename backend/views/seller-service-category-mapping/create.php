<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SellerServiceCategoryMapping */

$this->title = Yii::t('app', 'Create Seller Service Category Mapping');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seller Service Category Mappings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-service-category-mapping-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
