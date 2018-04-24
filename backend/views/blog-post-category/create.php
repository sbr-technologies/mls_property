<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BlogPostCategory */

$this->title = Yii::t('app', 'Create Blog Post Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Post Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
