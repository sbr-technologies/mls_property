<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */

$this->title = Yii::t('app', 'Create Advertisement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-create">

    <?= $this->render('_form', [
        'model' => $model, 'bannerModels' => $bannerModels
    ]) ?>

</div>
