<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = $model->fullName;
?>
<div class="agent-contact-view">

    <div class="content-wrapper">
        <!-- Content Title Sec -->
        <section class="content-header">
            <h1><?php echo $this->title ?></h1>
            <ol class="breadcrumb">
                <li><a href="<?= Url::to(['/contacts'])?>"><i class="fa fa-home" aria-hidden="true"></i> Contacts</a></li>
                <li class="active"><?= $this->title ?></li>
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
        </section>
    </div>
</div>