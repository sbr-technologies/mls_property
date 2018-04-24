<?php
use yii\helpers\Html;
//\yii\helpers\VarDumper::dump($output,4,12); exit;
?>
    <div class="form-group col-sm-4">
        <label class="control-label" >Contract Term Required </label>
        <?= Html::activeDropDownList($model, 'contact_term',$output,['class' => 'form-control clearValCls']) ?>
    </div>
    
    <div class="form-group col-sm-4">
        
    </div>
    
    <div class="form-group col-sm-4">
        
    </div>
