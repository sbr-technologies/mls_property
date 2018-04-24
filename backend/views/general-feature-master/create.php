<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GeneralFeatureMaster */

$this->title = Yii::t('app', 'Create General Feature Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'General Feature Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-feature-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
