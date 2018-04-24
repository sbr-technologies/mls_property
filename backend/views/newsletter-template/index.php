<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\TableHeaderWidget;
use common\models\NewsletterTemplate;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsletterTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Newsletter Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-templates-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  
    <p>
        <?= Html::a(Yii::t('app', 'Create Template'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'type',
            'subject',
            'created_at:datetime',
            'status',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {status} {delete}',
                'buttons' => [
                    'status' => function ($url, $model) {
                        if ($model->status == NewsletterTemplate::STATUS_ACTIVE) {
                            $class = 'glyphicon-ok-circle active';
                            $title = 'Block';
                        } else {
                            $class = 'glyphicon-ban-circle inactive';
                            $title = 'Unblock';
                        }
                        return Html::a('<span class="glyphicon ' . $class . '"></span>', $url, [
                                    'title' => Yii::t('yii', $title),
                        ]);
                    }
                        ],
                        'header' => 'Action', 'contentOptions' => ['class' => 'action text-center']],
                ],
                'layout' => "{items}\n{pager}"
            ]);
            ?>

</div>
