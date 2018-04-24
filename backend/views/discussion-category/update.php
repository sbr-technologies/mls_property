<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DiscussionCategory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Discussion Category',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="discussion-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
