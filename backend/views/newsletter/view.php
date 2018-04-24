<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmailTemplates */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-templates-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['newsletter-template/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="template-preview-area">
    <?= $model->content; ?>
    </div>
</div>
