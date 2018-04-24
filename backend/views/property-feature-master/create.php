<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PropertyFeatureMaster */

$this->title = Yii::t('app', 'Create Property Feature Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Feature Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-feature-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
