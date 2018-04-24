<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaticBlock */

$this->title = Yii::t('app', 'Create Static Block');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-block-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
