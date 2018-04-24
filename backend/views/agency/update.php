<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Agency */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Agency',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="agency-update">


    <?= $this->render('_form', [
        'model' => $model,
        'socialMediaModel'  => $socialMediaModel,
        'brokerModel' => $brokerModel,
        'brokerSocialMedia'     => $brokerSocialMedia,
    ]) ?>

</div>
