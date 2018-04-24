<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Testimonial */

$this->title = Yii::t('app', 'Create Testimonial');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Testimonials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonial-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
