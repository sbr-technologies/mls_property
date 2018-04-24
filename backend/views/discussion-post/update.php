<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DiscussionPost */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Discussion Post',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="discussion-post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
