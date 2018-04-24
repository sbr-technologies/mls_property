<div class="col-lg-5">
    <?= Yii::t('app', 'Avaliable') ?>:
    <select id="list_avaliable" multiple size="20" style="width: 100%">
        <?php foreach ($available as $email){?>
        <?php echo '<option value="'.$email->id.'">'. $email->email.'</option>';?>
        <?php }?>
    </select>
</div>
<div class="col-lg-1">
    <br><br>
    <a href="#" id="btn_add_email" class="btn btn-success">&gt;&gt;</a><br>
    <a href="#" id="btn_remove_email" class="btn btn-danger">&lt;&lt;</a>
</div>
<div class="col-lg-5">
    <?= Yii::t('app', 'Assigned') ?>:
    <select id="list_assigned" multiple size="20" style="width: 100%">
        <?php foreach ($assigned as $email){?>
        <?php echo '<option value="'.$email->subscriber->id.'">'. $email->subscriber->email.'</option>';?>
        <?php }?>
    </select>
</div>