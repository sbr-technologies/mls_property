<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\PhotoGallery;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
            <li role="presentation"><a href="#ad_banners" aria-controls="ad_banners" role="tab" data-toggle="tab">Banners</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'user.fullName',
                        'title',
                        'description:ntext',
                        'link:url',
                        'no_of_banner',
                        ['attribute' => 'profiles',
                            'format' => 'raw',
                            'value' => implode('<br/>------<br/>', ArrayHelper::getColumn($model->profiles, 'title'))
                        ],
                        'status',
                        'created_by',
                        'updated_by',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ])
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="ad_banners">
                <?php Pjax::begin(['id' => 'pjax-container']); ?>    
                <?= GridView::widget([
                        'dataProvider' => $bannerDataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'title',
                            'description:ntext',
                            [
                                'attribute' => 'photo',
                                'format' => 'html',
                                'value' => function($model) {
                                    return Html::img($model->photo->getImageUrl(PhotoGallery::THUMBNAIL), ['width' => 60]);
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{status} {view} {update} {delete}',
                                'buttons' => [
                                    'status'    =>  function ($url,$model) {
                                                        if($model->status == $model::STATUS_ACTIVE){
                                                            $class = 'fa fa-ban';
                                                            $title = 'Inactive';
                                                        }else{
                                                            $class = 'fa fa-check-circle-o';
                                                            $title = 'Active';
                                                        }
                                                        return Html::a(
                                                            '<span class="'.$class.'"></span>',Url::to(['advertisement-banner/status', 'id' => $model->id]), 
                                                            [
                                                                'title'         => $title,
                                                                'data-pjax'     => '0',
                                                                'onclick' => "
                                                                    $.loading();
                                                                    $.ajax('".Url::to(['advertisement-banner/status', 'id' => $model->id])."', {
                                                                        type: 'POST'
                                                                    }).done(function(data) {
                                                                        $.loaded();
                                                                        $.pjax.reload({container: '#pjax-container'});
                                                                    });
                                                                    return false",
                                                            ]
                                                        );
                                                    },
                                    'view'      =>  function ($url,$model) {
                                                        $class = 'fa fa-eye showModalButton';
                                                        $title = 'Details';
                                                        return Html::a('<span class="'.$class .'"></span>', ['advertisement-banner/view', 'id' => $model->id],
                                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'title' => $title]);
                                                    },
                                    'update'    =>  function ($url,$model) {
                                                        $class = 'fa fa-pencil showModalButton';
                                                        $title = 'Edit';
                                                        return Html::a('<span class="'.$class.'"></span>',['advertisement-banner/update', 'id' => $model->id],
                                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'title' => $title]);
                                                    },
                                    'delete'    =>  function ($url,$model) {
                                                        $class = 'fa fa-trash-o';
                                                        $title = 'Delete';
                                                        return Html::a(
                                                            '<span class="'.$class.'"></span>',Url::to(['advertisement-banner/delete', 'id' => $model->id]), 
                                                            [
                                                                'title'         => $title,
                                                                'data-pjax'     => '0',
                                                                'onclick' => "if (confirm('Are you sure?')) {
                                                                    $.loading();
                                                                    $.ajax('".Url::to(['advertisement-banner/delete', 'id' => $model->id])."', {
                                                                        type: 'POST'
                                                                    }).done(function(data) {
                                                                        $.loaded('Successfully deleted');
                                                                        $.pjax.reload({container: '#pjax-container'});
                                                                    });
                                                                }
                                                                return false;",
                                                            ]
                                                        );
                                                    },
                                ],
                            ],
                        ],
                    ]);
                ?>
               <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$js     =   "$(function(){
                $('body').on('submit', '#frm_update_banner_info', function(){
                    var thisForm = $(this);
                    $.loading();
                    $.post(thisForm.attr('action'), thisForm.serialize(), function(response){
                        $.loaded();
                        if(response.status === 'success'){
                            $('#mls_bs_modal_one').modal('hide');
                            $.pjax.reload({container: '#pjax-container'});
                        }
                    }, 'json');
                    return false;
                }); 
            });";
$this->registerJs($js, View::POS_END);
?>
