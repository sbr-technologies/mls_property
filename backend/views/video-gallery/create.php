<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VideoGallery */

$this->title = Yii::t('app', 'Create Video Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Video Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-gallery-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
