<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LocationSuggestion */

$this->title = Yii::t('app', 'Create Location Suggestion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Location Suggestions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-suggestion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
