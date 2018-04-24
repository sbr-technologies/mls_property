<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NewsletterEmailList */

$this->title = Yii::t('app', 'Create Subscriber Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subscriber Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-email-list-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
