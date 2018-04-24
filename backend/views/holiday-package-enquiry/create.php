<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackageEnquiry */

$this->title = Yii::t('app', 'Create Holiday Package Enquiry');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Enquiries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-package-enquiry-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
