<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\editable\Editable;
use kartik\popover\PopoverX;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Agency */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agency-view">


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
            <li role="presentation"><a href="#contactInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Contact Information</a></li>
            <li role="presentation"><a href="#blogSocialInfo" aria-controls="messages" role="tab" data-toggle="tab">Blog & Social Information</a></li>
            <li role="presentation"><a href="#agent_list" aria-controls="agent_list" role="tab" data-toggle="tab">Agent List</a></li>
            <li role="presentation"><a href="#teamInfo" aria-controls="localInfo" role="tab" data-toggle="tab">Team List</a></li>
            <li role="presentation"><a href="#subscriptions" aria-controls="subscription" role="tab" data-toggle="tab">Subscriptions</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'agencyID',
                        'name',
                        'tagline',
                        'owner_name',
                        'about',
                        ['attribute' => 'formattedAddress', 'label' => 'Address'],
                        'status',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ])
                ?>
                <?php
                echo $this->render('//shared/_photo-gallery', ['model' => $model, 'delete' => true]);
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="teamInfo">
                <?php Pjax::begin(); ?>    <?=
                GridView::widget([
                    'dataProvider' => $teamDataProvider,
                    'columns' => [
                        'name',
                        'teamID',
                        'created_at:datetime',
                        'status',
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
                                            'options' => ['id'=>'subcat-id-p', 'placeholder' => 'Select subcat...'],
                                            'pluginOptions'=>[
                                                'depends'=>['cat-id-p'],
                                                'url' => Url::to(['/plan-master/plan-options'])
                                            ]
                                        ]
                                    ]);
                                    $form = $editable->getForm();
                                    // use a hidden input to understand if form is submitted via POST
                                    $editable->beforeInput = $form->field($model, 'plan_id')->dropDownList(yii\helpers\ArrayHelper::map(common\models\PlanMaster::find()->agency()->all(), 'id', 'title'), ['id'=>'cat-id-p', 'prompt' => 'Select a Plan']) . "\n";
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
                        'options' => ['id'=>'subcat-id-p', 'placeholder' => 'Select subcat...'],
                        'pluginOptions'=>[
                            'depends'=>['new-cat-id-p'],
                            'url' => Url::to(['/plan-master/plan-options'])
                        ]
                    ]
                ]);
                $form = $editable->getForm();
                // use a hidden input to understand if form is submitted via POST
                $editable->beforeInput = Html::hiddenInput('Subscription[agency_id]', $model->id). 
                                        $form->field($newSubscription, 'plan_id')->dropDownList(yii\helpers\ArrayHelper::map(common\models\PlanMaster::find()->agency()->all(), 'id', 'title'), ['id'=>'new-cat-id-p', 'prompt' => 'Select a Plan']) . "\n";
                $editable->afterInput = $form->field($newSubscription, 'paid_amount')->textInput()->label('Paid Amount in NGN (Offline)') . "\n";
                Editable::end();
                }
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="contactInfo">
                <?=
                    DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'email',
                        'web_address',
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
                    ],
                ])
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="blogSocialInfo">
                <?php
                $socialMediaLink = $model->socialMedias;
//            yii\helpers\VarDumper::dump($socialMediaLink,4,12);
                if (!empty($socialMediaLink)) {
                    foreach ($socialMediaLink as $social) {
                        ?>
                        <div class="form-group">
                        <?php echo "<label for='usr'>" . $social->name . "</label> : " . $social->url . "<br>"; ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="agent_list">
                <?php Pjax::begin(); ?>    <?=
                GridView::widget([
                    'dataProvider' => $agentDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'salutation',
                        'first_name',
                        'last_name',
                        'email:email',
                        'status'
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{status} {view} {update} {delete}',
//                        'buttons' => [
//                            'status' => function ($url, $model) {
//                                if ($model->status == $model::STATUS_ACTIVE) {
//                                    $class = 'fa fa-ban';
//                                    $title = 'Inactive';
//                                } else {
//                                    $class = 'fa fa-check-circle-o';
//                                    $title = 'Active';
//                                }
//                                return Html::a(
//                                                '<span class="' . $class . '"></span>', $url, [
//                                            'title' => $title,
//                                            'data-pjax' => '0',
//                                                ]
//                                );
//                            },
//                        ],
//                    ],
                    ],
                ]);
                ?>
<?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
