
<div class="property_room_facility_info_container">
    <?php foreach ($facilityRoomModel as $i => $roomFacility) { ?>
        <div class="item">
            <?= $form->field($roomFacility, "[$i]id")->hiddenInput()->label(false) ?>

            <?= $form->field($roomFacility, "[$i]title")->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($roomFacility, "[$i]description")->textArea(['maxlength' => true]) ?>

            <div class="">
                <?= $form->field($roomFacility, "[$i]_destroy")->hiddenInput(['class' => 'hidin_child_id'])->label(false) ?>
                <?php if (!$roomFacility->isNewRecord && $i > 0) { ?>
                    <a data-toggle="tooltip" class="btn btn_check_payment tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>"><i class="fa fa-trash-o"></i></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<button class="btn_add_property_room_facility_info" type="button">Add Another</button>