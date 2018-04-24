<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServiceCategory */

$this->title = Yii::t('app', 'Create Service Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
