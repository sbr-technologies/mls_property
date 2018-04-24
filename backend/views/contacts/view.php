<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = 'Contact of ' . $model->user->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-view">

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

    <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'fullName',
                    'short_name',
                    'email:email',
                    'genderText',
                    'birthday',
                    ['attribute' => 'occupation', 'value' => ($model->occupation != 'Other'?$model->occupation:$model->occupation_other)],
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
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ])
    ?>
</div>