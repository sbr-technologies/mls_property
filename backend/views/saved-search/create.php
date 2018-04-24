<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SavedSearch */

$this->title = Yii::t('app', 'Create Saved Search');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Saved Searches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saved-search-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
