<?php 
use yii\helpers\Html;
?>
<div class="property_tax_history_container">
    <?php foreach ($taxHistoryModel as $i => $taxHistory) { ?>
        <div class="item new add-form-popup">
            <div class="form-group col-sm-12">
                <div class="row">
                    <?= Html::activeHiddenInput($taxHistory, "[$i]id")?>
                    <div class="form-group col-sm-6">
                      <?= Html::activeLabel($taxHistory, "[$i]year")?>
                      <?= Html::activeTextInput($taxHistory, "[$i]year", ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)','maxlength' => '4'])?>
                    </div>
                    <div class="form-group col-sm-6">
                      <?= Html::activeLabel($taxHistory, "[$i]taxes")?>
                      <?= Html::activeTextInput($taxHistory, "[$i]taxes", ['class' => 'form-control', 'onkeypress'=>'return isNumberKey(event)'])?>
                    </div>
                </div>
            </div>     
            <div class="">
                <?= Html::activeHiddenInput($taxHistory, "[$i]_destroy", ['class' => 'hidin_child_id']) ?>
                <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
            </div>
        </div>
    <?php } ?>
</div>
