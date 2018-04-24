
<div class="property_facility_info_container">
    <?php foreach ($facilityModel as $i => $facility) { ?>
        <div class="item">
            <?= $form->field($facility, "[$i]id")->hiddenInput()->label(false) ?>

            <?= $form->field($facility, "[$i]title")->textInput(['maxlength' => true]) ?>

            <div class="">
                <?= $form->field($facility, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
                <?php if (!$facility->isNewRecord && $i > 0) { ?>
                    <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<button class="btn_add_property_facility_info" type="button">Add Another</button>