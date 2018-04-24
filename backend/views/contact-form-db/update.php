<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactFormDb */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contact Form Db',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Form Dbs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contact-form-db-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
