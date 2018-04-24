<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaticBlockLocationMaster */

$this->title = Yii::t('app', 'Create Static Block Location Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Block Location Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-block-location-master-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
