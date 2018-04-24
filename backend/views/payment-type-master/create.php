<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PaymentTypeMaster */

$this->title = Yii::t('app', 'Create Payment Type Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Type Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-type-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
