<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DiscussionComment */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Discussion Comment',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="discussion-comment-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
