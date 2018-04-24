<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MetaTag */

$this->title = Yii::t('app', 'Create Meta Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meta Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
