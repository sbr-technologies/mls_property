<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agent'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agency-agents-view">
    <div class="team-index">
        <div class="content-wrapper">
            <!-- Content Title Sec -->
            <section class="content-header">
                <h1><?php echo $this->title ?></h1>
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Agent Management</a></li>
                    <li><a href="<?= Url::to(['/agency/agents']) ?>"><i class="fa fa-users" aria-hidden="true"></i> List</a></li>
                    <li><?= $this->title?></li>
                </ol>
            </section>
            <!-- Content Title Sec -->

            <!-- Main content -->
            <section class="content">
                <div class="manage-profile-sec">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'agentID',
                            'agency.name',
                            'fullName',
                            'username',
                            'short_name',
                            'location',
                            'email:email',
                            'phoneNumber',
                            'mobile2',
                            'mobile3',
                            'genderText',
                            'birthday',
                            'tagline',
                            'street_address',
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
                            'team.name',
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
                        'class' => 'img-thumbnail',
                    ]);
                    ?>

                </div>
            </section>
        </div>
    </div>
</div>