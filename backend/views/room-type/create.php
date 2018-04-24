<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RoomType */

$this->title = Yii::t('app', 'Create Room Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Room Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
