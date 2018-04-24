<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContactAgent */

$this->title = Yii::t('app', 'Create Contact Agent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-agent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
