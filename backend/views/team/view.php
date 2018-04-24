<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Team */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
<!--    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#team_info" aria-controls="general_info" role="tab" data-toggle="tab">Team Info</a></li>
        <li role="presentation"><a href="#associated_agency" aria-controls="associated_sellers" role="tab" data-toggle="tab">Associated Agency</a></li>
    </ul>-->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="team_info">
            <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        ['attribute' => 'agency.name', 'label' => 'Agency'],
                        'name',
                        'teamID',
                        'createdBy',
                        'created_at:datetime',
                        'status',
                    ],
                ])
            ?>
        </div>
<!--        <div role="tabpanel" class="tab-pane" id="associated_agency">
            <?php 
//            Pjax::begin(['id' => 'agency_pjax_container']);
//                echo GridView::widget([
//                'dataProvider' => $agencyDataProvider,
//                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],
//                    //'id',
//                    'team.name',
//                    'agency.name',
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{delete}',
//                        'buttons'   => [
//                            'delete'    =>  
//                            function ($url,$model) {
//                                $class = 'fa fa-trash-o';
//                                $title = 'Delete';
//                                return Html::a(
//                                    '<span class="'.$class.'"></span>',Url::to(['agent-service-category-mapping/delete', 'id' => $model->id]), 
//                                    [
//                                        'title'         => $title,
//                                        'data-pjax'     => '0',
//                                        'onclick' => "if (confirm('Are you sure?')) {
//                                            $.loading();
//                                            $.ajax('".Url::to(['agent-seller-mapping/delete', 'id' => $model->id])."', {
//                                                type: 'POST'
//                                            }).done(function(data) {
//                                                 $.loaded('Successfully deleted');
//                                                 $.pjax.reload({container: '#seller_pjax_container'});
//                                            });
//                                        }
//                                        return false;",
//                                    ]
//                                );
//                            },
//                        ],
//                    ],
//                ],
//            ]);
//
//            Pjax::end(); 
            ?>
        </div>-->
    </div>
    

</div>
