<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NewsletterEmailSubscriber */

$this->title = Yii::t('app', 'Create Newsletter Email Subscriber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter Email Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-email-subscriber-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
