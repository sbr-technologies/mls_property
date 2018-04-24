<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            <li role="presentation"><a href="#service_categories" aria-controls="service_categories" role="tab" data-toggle="tab">Service Categories</a></li>
            <li role="presentation"><a href="#subscriptions" aria-controls="subscription" role="tab" data-toggle="tab">Subscriptions</a></li>
            <!--<li role="presentation"><a href="#associated_sellers" aria-controls="associated_sellers" role="tab" data-toggle="tab">Associated Sellers</a></li>-->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'agentID',
                        ['attribute' => 'agency_id', 'format' => 'html', 'value' => empty($model->agency_id)?'<span class="not-set">(Not Set)</span>':Html::a($model->agency->name, ['agency/view', 'id' => $model->agency_id]), 'label' => 'Agency'],
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
                        'team.name',
                        'status',
//                        'worked_with',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ])
                ?>

                <?php
                echo Html::img($model->getImageUrl($model::THUMBNAIL), [
                    'class' => 'img-thumbnail',
                ]);
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="service_categories">
                <?php Pjax::begin(['id' => 'service_categories_pjax_container']); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $serviceCategoryDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        'serviceCategory.name',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    $class = 'fa fa-trash-o';
                                    $title = 'Delete';
                                    return Html::a(
                                                    '<span class="' . $class . '"></span>', Url::to(['agent-service-category-mapping/delete', 'id' => $model->id]), [
                                                'title' => $title,
                                                'data-pjax' => '0',
                                                'onclick' => "if (confirm('Are you sure?')) {
                                                                    $.loading();
                                                                    $.ajax('" . Url::to(['agent-service-category-mapping/delete', 'id' => $model->id]) . "', {
                                                                        type: 'POST'
                                                                    }).done(function(data) {
                                                                        $.loaded('Successfully deleted');
                                                                        $.pjax.reload({container: '#service_categories_pjax_container'});
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
            <div role="tabpanel" class="tab-pane" id="subscriptions">
                <?php Pjax::begin(['id' => 'subscriptions_pjax_container']); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $subscriptionsDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'plan.title',
                        'paid_amount:currency',
                        'subs_start:date',
                        'subs_end:date',
                        'payment_mode',
                        'status',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'header' => 'Action',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    if($model->status == 'inactive'){
                                        return null;
                                    }
                                    $class = 'fa fa-pencil';
                                    $title = 'Delete';
                                    ob_start();
                                    $editable = Editable::begin([
                                        'name' => 'Subscription[duration]',
                                        'value' => $model->duration,
                                        'asPopover' => true,
                                        'placement' => PopoverX::ALIGN_BOTTOM,
                                        'size' => PopoverX::SIZE_MEDIUM,
                                        'inputType' => Editable::INPUT_DEPDROP,
                                        'displayValue' => 'Update',
                                        'formOptions' => ['action' => ['/agent/update-subscription', 'id' => $model->id]],
                                        'options' => [
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'select2Options'=> ['pluginOptions'=>['allowClear'=>true]],
                                            'data' => ['1' => 'dsfdsf', '2' => 'dfdf'],
                                            'options' => ['id'=>'subcat-id-p', 'placeholder' => 'Select subcat...'],
                                            'pluginOptions'=>[
                                                'depends'=>['cat-id-p'],
                                                'url' => Url::to(['/plan-master/plan-options'])
                                            ]
                                        ]
                                    ]);
                                    $form = $editable->getForm();
                                    // use a hidden input to understand if form is submitted via POST
                                    $editable->beforeInput = $form->field($model, 'plan_id')->dropDownList(yii\helpers\ArrayHelper::map(common\models\PlanMaster::find()->agent()->all(), 'id', 'title'), ['id'=>'cat-id-p']) . "\n";
                                    $editable->afterInput = $form->field($model, 'paid_amount')->textInput()->label('Paid Amount in NGN (Offline)') . "\n";
                                    Editable::end();
                                    $ret = ob_get_clean();
                                    return $ret;
                                },
                                'delete' => function ($url, $model) {
                                    if($model->status == 'inactive'){
                                        return null;
                                    }
                                    $class = 'fa fa-trash-o';
                                    $title = 'Delete';
                                    return Html::a('Terminate', '#', [
                                                'title' => $title,
                                                'data-pjax' => '0',
                                                'onclick' => "if (confirm('Are you sure want to terminate the subscription?')) {
                                                                    $.loading();
                                                                    $.ajax('" . Url::to(['agent/terminate-subscription', 'id' => $model->id]) . "', {
                                                                        type: 'POST'
                                                                    }).done(function(data) {
                                                                        $.loaded('Successfully terminated');
                                                                        $.pjax.reload({container: '#subscriptions_pjax_container'});
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
                <?php 
                if(!$hasActiveSubscription){
                    $editable = Editable::begin([
                    'name' => 'Subscription[duration]',
                    'value' => '',
                    'asPopover' => true,
                    'placement' => PopoverX::ALIGN_RIGHT,
                    'size' => PopoverX::SIZE_MEDIUM,
                    'inputType' => Editable::INPUT_DEPDROP,
                    'displayValue' => 'Choose New Subscription',
                    'formOptions' => ['action' => ['/agent/create-subscription']],
                    'options' => [
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options'=> ['pluginOptions'=>['allowClear'=>true]],
                        'data' => ['1' => 'dsfdsf', '2' => 'dfdf'],
                        'options' => ['id'=>'subcat-id-p', 'placeholder' => 'Select subcat...'],
                        'pluginOptions'=>[
                            'depends'=>['new-cat-id-p'],
                            'url' => Url::to(['/plan-master/plan-options'])
                        ]
                    ]
                ]);
                $form = $editable->getForm();
                // use a hidden input to understand if form is submitted via POST
                $editable->beforeInput = Html::hiddenInput('Subscription[user_id]', $model->id). 
                                        $form->field($newSubscription, 'plan_id')->dropDownList(yii\helpers\ArrayHelper::map(common\models\PlanMaster::find()->agent()->all(), 'id', 'title'), ['id'=>'new-cat-id-p']) . "\n";
                $editable->afterInput = $form->field($newSubscription, 'paid_amount')->textInput()->label('Paid Amount in NGN (Offline)') . "\n";
                Editable::end();
                }
                ?>
                <?php if($officeSubscriptionsDataProvider && $officeSubscriptionsDataProvider->count > 0){?>
                <h4 class="form-group">Office Subscription</h4>
                <?= GridView::widget([
                        'dataProvider' => $officeSubscriptionsDataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'plan.title',
                            'subs_start:date',
                            'subs_end:date',
                            'status',
                        ],
                    ]);
                }
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="associated_sellers">
                <?php Pjax::begin(['id' => 'seller_pjax_container']); ?>    
                <?=
                GridView::widget([
                    'dataProvider' => $sellerDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        'seller.fullName',
                        'seller.email',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' =>
                                function ($url, $model) {
                                    $class = 'fa fa-trash-o';
                                    $title = 'Delete';
                                    return Html::a(
                                                    '<span class="' . $class . '"></span>', Url::to(['agent-service-category-mapping/delete', 'id' => $model->id]), [
                                                'title' => $title,
                                                'data-pjax' => '0',
                                                'onclick' => "if (confirm('Are you sure?')) {
                                        $.loading();
                                        $.ajax('" . Url::to(['agent-seller-mapping/delete', 'id' => $model->id]) . "', {
                                            type: 'POST'
                                        }).done(function(data) {
                                             $.loaded('Successfully deleted');
                                             $.pjax.reload({container: '#seller_pjax_container'});
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
