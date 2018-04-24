<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RentalFeatureMaster */

$this->title = Yii::t('app', 'Create Rental Feature Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rental Feature Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rental-feature-master-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
