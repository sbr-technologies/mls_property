<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\HotelBooking */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotel Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-booking-view">


    <p>
        
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
            <li role="presentation"><a href="#guest_info" aria-controls="guest_info" role="tab" data-toggle="tab">Guest Info</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="general_info">
              <?= DetailView::widget([
                  'model' => $model,
                  'attributes' => [
                      'booking_generated_id',
                      'hotel.name',
                      'user.fullName',
                      'room',
                      'checkIn',
                      'checkOut',
                      'amount',
                      'payment_mode',
                      'card_last_4_digit',
                      'no_of_adult',
                      'no_of_children',
                      'status',
                      'created_at:datetime',
                      'updated_at:datetime',
                  ],
              ])
              ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="guest_info">
                <?php Pjax::begin(['id' => 'pjax-container']); ?>
                <?= GridView::widget([
                        'dataProvider' => $guestDataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'first_name',
                            'last_name',
                            'middle_name',
                             'genderText',
                             'age',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view'      =>  function ($url,$model) {
                                                        $class = 'fa fa-eye showModalButton';
                                                        $title = 'Details';
                                                        return Html::a('<span class="'.$class .'"></span>', ['hotel-booking-guest/view', 'id' => $model->id],
                                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'title' => $title]);
                                                    },
                                    'update'    =>  function ($url,$model) {
                                                        $class = 'fa fa-pencil showModalButton';
                                                        $title = 'Edit';
                                                        return Html::a('<span class="'.$class.'"></span>',['hotel-booking-guest/update', 'id' => $model->id],
                                                            ['data-target' => '#mls_bs_modal_one', 'data-toggle' => 'modal', 'title' => $title]);
                                                    },
                                    'delete'    =>  function ($url,$model) {
                                                        $class = 'fa fa-trash-o';
                                                        $title = 'Delete';
                                                        return Html::a(
                                                            '<span class="'.$class.'"></span>',Url::to(['hotel-booking-guest/delete', 'id' => $model->id]), 
                                                            [
                                                                'title'         => $title,
                                                                'data-pjax'     => '0',
                                                                'onclick' => "if (confirm('Are you sure?')) {
                                                                    $.ajax('".Url::to(['hotel-booking-guest/delete', 'id' => $model->id])."', {
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
                    ]); ?>
               <?php Pjax::end();?>
            </div>
        </div>
    </div>
</div>
<?php
$js     =   "$(function(){
                $('body').on('submit', '#frm_update_guest', function(){
                    var thisForm = $(this); 
                    $.post(thisForm.attr('action'), thisForm.serialize(), function(response){
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