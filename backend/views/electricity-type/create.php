<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ElectricityType */

$this->title = Yii::t('app', 'Create Electricity Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Electricity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="electricity-type-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
