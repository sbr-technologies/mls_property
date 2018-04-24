<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PhotoGallery */

$this->title = Yii::t('app', 'Create Photo Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Photo Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-gallery-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
