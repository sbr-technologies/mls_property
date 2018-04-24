<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmailTemplate */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Email Template',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="email-template-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
