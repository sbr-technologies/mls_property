<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BannerType */

$this->title = Yii::t('app', 'Create Banner Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
