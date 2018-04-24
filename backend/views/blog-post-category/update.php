<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogPostCategory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Blog Post Category',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Post Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="blog-post-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
