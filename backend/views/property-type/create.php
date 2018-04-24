<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyType */

$this->title = Yii::t('app', 'Create Property Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-type-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
