<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PlanMaster */

$this->title = Yii::t('app', 'Create Office Subscription Plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Office Plans'), 'url' => ['agency']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-master-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
