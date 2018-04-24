<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PropertyShowingRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Property Showing Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-showing-request-index">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user.fullName',
            //'model_id',
            'model',
            'schedule:date',
            // 'note:ntext',
             'name',
             'email:email',
             'phone',
            // 'is_lender',
            'status',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {approve} {discard} {delete}',
                'buttons' => [
                    'approve' => function ($url,$model) {
                        $class = 'fa fa-thumbs-up';
                        $title = 'Approve';
                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title' => $title,
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'discard' => function ($url,$model) {
                        $class = 'fa fa-thumbs-down';
                        $title = 'Reject';

                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title' => $title,
                                'data-pjax' => '0',
                            ]
                        );
                    },
 /*                    'pending' => function ($url,$model) {
                        $class = 'fa fa-ban';
                        $title = 'Discard';
                        return Html::a(
                            '<span class="'.$class.'"></span>',
                            $url, 
                            [
                                'title' => $title,
                                'data-pjax' => '0',
                            ]
                        );
                    }, */
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
