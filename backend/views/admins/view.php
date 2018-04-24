<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['index']];
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
<?php 
//echo Yii::$app->formatter->dateFormat;die();
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'profile.title',
            'fullName',
            'username',
            'short_name',
            'location',
            'email:email',
            'mobile1',
            'calling_code',
            'gender',
            'birthday',
            'tagline',
            'street_number',
            'urban_town_area',
            'local_govt_area', 
            'sub_area',
            'area',
            'town',
            'state',
            'country',
            'zip_code',
            'lat',
            'lng',
            'status',
            'worked_with',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?php 
    echo Html::img($model->getImageUrl($model::THUMBNAIL), [
      'class'=>'img-thumbnail', 
    ]);
    ?>
</div>
