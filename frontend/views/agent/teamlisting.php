<?php

use yii\helpers\Html;
use yii\web\Response;

//\yii\helpers\VarDumper::dump($result['value']);exit;
if(isset($result['value']) && $result['value'] != ''){
?>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label" for="agent-email">Selected Team</label>
            <?= $result['value'] ?>
        </div>
        <div class="col-sm-6">
<!--            <input type="button" name="Change" value="Change Team" onclick="showTeamDiv();" class="btn btn-primary"/>

            <input type="button" name="Clear" value="Clear" onclick="hideTeamDiv();" class="btn btn-danger"/> -->
        </div>
    </div>
</div>
<?php
}else{
?>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
<!--                <input type="button" name="Change" value="Assign Team" onclick="showTeamDiv();" class="btn btn-primary"/>

                <input type="button" name="Clear" value="Clear" onclick="hideTeamDiv();" class="btn btn-danger"/>-->
            </div>
        </div>
    </div>
<?php
}
?>
