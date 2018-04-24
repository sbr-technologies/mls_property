<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NewsletterEmailSubscriber */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Newsletter Email Subscriber',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter Email Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="newsletter-email-subscriber-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
