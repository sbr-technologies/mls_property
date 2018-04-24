<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LocationLocalInfoTypeMaster */

$this->title = Yii::t('app', 'Create Location Local Info Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Location Local Info Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-local-info-type-master-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
