<?php
use yii\helpers\Html;
//\yii\helpers\VarDumper::dump($output); exit;
?>
<label class="control-label" >Other Payment Term</label>
<?= Html::activeDropDownList($model, 'other_fee_payment_term',$output,['class' => 'form-control clearValCls']) ?>

