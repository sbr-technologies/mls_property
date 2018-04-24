<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageCategory */

$this->title = Yii::t('app', 'Create Holiday Package Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-package-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
