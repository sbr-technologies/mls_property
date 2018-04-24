<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyCategory */

$this->title = Yii::t('app', 'Create Property Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
