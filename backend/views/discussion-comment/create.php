<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DiscussionComment */

$this->title = Yii::t('app', 'Create Discussion Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussion-comment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
