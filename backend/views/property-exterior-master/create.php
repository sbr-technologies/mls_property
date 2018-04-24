<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyExteriorMaster */

$this->title = Yii::t('app', 'Create Property Exterior Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Exterior Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-exterior-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
