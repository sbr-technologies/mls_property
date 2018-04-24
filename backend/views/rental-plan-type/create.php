<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RentalPlanType */

$this->title = Yii::t('app', 'Create Rental Plan Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rental Plan Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rental-plan-type-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
