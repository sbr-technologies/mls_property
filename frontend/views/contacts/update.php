<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */
$this->title = $model->fullName;
?>
<div class="agent-contact-update">

    <div class="content-wrapper">
        <!-- Content Title Sec -->
        <section class="content-header">
            <h1><?php echo $this->title ?></h1>
            <ol class="breadcrumb">
                <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Contacts</a></li>
                <li class="active"><?= $this->title?></li>
            </ol>
        </section>
        <!-- Content Title Sec -->

        <!-- Main content -->
        <section class="content">
            <div class="manage-profile-sec">

                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>

            </div>
        </section>
    </div>
</div>