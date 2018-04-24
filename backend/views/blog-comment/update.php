<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BlogComment */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Blog Comment',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="blog-comment-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
