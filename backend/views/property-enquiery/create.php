<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyEnquiery */

$this->title = Yii::t('app', 'Create Property Enquiery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Enquieries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-enquiery-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
