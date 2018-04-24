<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DiscussionTag */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Discussion Tag',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="discussion-tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
