<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContactFormDb */

$this->title = Yii::t('app', 'Create Contact Form Db');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Form Dbs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-form-db-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
