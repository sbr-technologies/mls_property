<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageType */

$this->title = Yii::t('app', 'Create Holiday Package Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-package-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
