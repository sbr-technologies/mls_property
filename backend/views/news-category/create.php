<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NewsCategory */

$this->title = Yii::t('app', 'Create News Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
