<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HolidayPackage */

$this->title = Yii::t('app', 'Create Holiday Package');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-package-create">


    <?= $this->render('_form', [
        'model'             => $model,
        'metaTagModel'      =>  $metaTagModel,
        'packageFeature'    =>  $packageFeature,
        'packageFeatureItem'=>  $packageFeatureItem,
    ]) ?>

</div>
