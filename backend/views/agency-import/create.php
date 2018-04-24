<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Property */

$this->title = Yii::t('app', 'Agency Import');
?>
<div class="property-bulk-create">
    <div class="user-add col-lg-12 connectedSortable ui-sortable">
    <div class="box box-success">
        <div class="box-header ui-sortable-handle">
            <p>
                Here, you can import bulk Agency. Download This <a target="_blank" href="<?= Yii::getAlias('@uploadsUrl/csvFile/agency_import_format.csv'); ?>">CSV File</a> for an example. 
            </p>
        </div>
        <div class="box-body">
            <?= $this->render('_form',['model'=> $model]) ?>
        </div>
    </div>
</div>

    

</div>
