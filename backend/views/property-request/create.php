<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyRequest */

$this->title = Yii::t('app', 'Create Property Request');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-request-create">

    <?= $this->render('_form', [
        'model' => $model,
        'propertyCategory' =>  $propertyCategory,
    ]) ?>

</div>
