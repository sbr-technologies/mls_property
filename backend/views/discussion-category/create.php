<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DiscussionCategory */

$this->title = Yii::t('app', 'Create Discussion Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Discussion Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussion-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
