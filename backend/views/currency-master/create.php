<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CurrencyMaster */

$this->title = Yii::t('app', 'Create Currency Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Currency Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
