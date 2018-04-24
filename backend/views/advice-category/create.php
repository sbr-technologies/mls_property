<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdviceCategory */

$this->title = Yii::t('app', 'Create Advice Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advice Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advice-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
