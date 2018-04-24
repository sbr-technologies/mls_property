<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\TableHeaderWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsletterTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Newsletter Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-templates-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'subject',
            'created_at:datetime',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {send-to-user} {schedule-for-user}',
                'buttons' => [
                    'send-to-user' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-send"></span>', $url, [
                                    'title' => Yii::t('yii', 'Send'),
                        ]);
                    },
                    'schedule-for-user' => function ($url, $model) {
                        return Html::a('<i class="fa fa-clock-o"></i>', $url, [
                                    'title' => Yii::t('yii', 'Schedule'),
                        ]);
                    },
                ],
                        'header' => 'Action', 'contentOptions' => ['class' => 'action text-center']],
                ],
                'layout' => "{items}\n{pager}"
            ]);
            ?>

</div>
