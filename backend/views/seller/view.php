<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seller'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#general_info" aria-controls="general_info" role="tab" data-toggle="tab">General Info</a></li>
<!--          <li role="presentation"><a href="#service_categories" aria-controls="service_categories" role="tab" data-toggle="tab">Service Categories</a></li>
          <li role="presentation"><a href="#associated_agents" aria-controls="associated_agents" role="tab" data-toggle="tab">Associated Agents</a></li>-->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'sellerID',
                        'fullName',
                        'short_name',
                        'email:email',
                        'genderText',
                        'birthday',
                        ['attribute' => 'occupation', 'value' => ($model->occupation != 'Other' ? $model->occupation : $model->occupation_other)],
                        'timezone',
                        'Mobile1',
                        'Office1',
                        'Fax1',
                        'Mobile2',
                        'Office2',
                        'Fax2',
                        'Mobile3',
                        'Office3',
                        'Fax3',
                        'Mobile4',
                        'Office4',
                        'Fax4',
                        ['attribute' => 'formattedAddress', 'label' => 'Address'],
                        'status',
                        'worked_with',
                        ['attribute' => 'paymentType.title', 'label' => 'Payment Type'],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ])
                ?>

                <?php 
                echo Html::img($model->getImageUrl($model::THUMBNAIL), [
                  'class'=>'img-thumbnail', 
                ]);
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="service_categories">
                <?php Pjax::begin(['id' => 'pjax-container']); ?>
                <?= GridView::widget([
                    'dataProvider' => $serviceCategoryDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        'serviceCategory.name',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons'   => [
                                            'delete'    =>  function ($url,$model) {
                                                                $class = 'fa fa-trash-o';
                                                                $title = 'Delete';
                                                                return Html::a(
                                                                    '<span class="'.$class.'"></span>',Url::to(['seller-service-category-mapping/delete', 'id' => $model->id]), 
                                                                    [
                                                                        'title'         => $title,
                                                                        'data-pjax'     => '0',
                                                                        'onclick' => "if (confirm('Are you sure?')) {
                                                                            $.ajax('".Url::to(['seller-service-category-mapping/delete', 'id' => $model->id])."', {
                                                                                type: 'POST'
                                                                            }).done(function(data) {
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
            <div role="tabpanel" class="tab-pane" id="associated_agents">
              <?php Pjax::begin(['id' => 'pjax-container']); ?>
              <?= GridView::widget([
                  'dataProvider' => $agentDataProvider,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      //'id',
                      'seller.fullName',
                      'seller.email',
                      [
                          'class' => 'yii\grid\ActionColumn',
                          'template' => '{delete}',
                          'buttons'   => [
                                          'delete'    =>  function ($url,$model) {
                                                              $class = 'fa fa-trash-o';
                                                              $title = 'Delete';
                                                              return Html::a(
                                                                  '<span class="'.$class.'"></span>',Url::to(['agent-seller-mapping/delete', 'id' => $model->id]), 
                                                                  [
                                                                      'title'         => $title,
                                                                      'data-pjax'     => '0',
                                                                      'onclick' => "if (confirm('Are you sure?')) {
                                                                          $.ajax('".Url::to(['agent-seller-mapping/delete', 'id' => $model->id])."', {
                                                                              type: 'POST'
                                                                          }).done(function(data) {
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
