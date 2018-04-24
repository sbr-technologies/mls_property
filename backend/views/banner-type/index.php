<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BannerTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banner Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-type-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Banner Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'text_color',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
