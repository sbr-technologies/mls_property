<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DiscussionTag */

$this->title = Yii::t('app', 'Create Discussion Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussion-tag-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
