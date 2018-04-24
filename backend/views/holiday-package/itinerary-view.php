<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $itineraryModel common\models\Hotel */

//yii\helpers\VarDumper::dump($itineraryModel,4,12); exit;
$this->title = $itineraryModel->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holiday Package Itinerary'), 'url' => ['itinerary-list','id' => $holiday_package_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-itinerary-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['itinerary-update', 'id' => $itineraryModel->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['itinerary-delete', 'id' => $itineraryModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div>
        <div role="tabpanel" class="tab-pane active" id="hotel_info">
            <?= DetailView::widget([
                'model' => $itineraryModel,
                'attributes' => [
                            'holidayPackage.name',
                            'days_name',
                            'title',
                            'description:ntext',
                            'address',
                            'city',
                            'state',
                            'country',
                ],
            ]) ?>
            <?php 
                echo $this->render('//shared/_photo-gallery', ['model' => $itineraryModel]);
            ?>
        </div>
    </div>
</div>
