<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ConstructionStatusMaster */

$this->title = Yii::t('app', 'Create Construction Status Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Construction Status Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-status-master-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
