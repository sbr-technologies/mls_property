<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NewsletterEmailListSubscriber */

$this->title = Yii::t('app', 'Create Newsletter Email List Subscriber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletter Email List Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-email-list-subscriber-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
