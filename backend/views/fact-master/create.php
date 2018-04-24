<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FactMaster */

$this->title = Yii::t('app', 'Create Fact Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fact Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fact-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
