<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DiscussionPost */

$this->title = Yii::t('app', 'Create Discussion Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussion-post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
