<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VideoGallery */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Video Gallery',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Video Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="video-gallery-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
