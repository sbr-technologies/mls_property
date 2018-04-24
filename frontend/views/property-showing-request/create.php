<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyShowingRequest */

$this->title = Yii::t('app', 'Create Property Showing Request');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Showing Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-showing-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
