<?php
use yii\helpers\Html;
//\yii\helpers\VarDumper::dump($output); exit;
?>
<label class="control-label" >Service Payment Term</label>
<?= Html::activeDropDownList($model, 'service_fee_payment_term',$output,['class' => 'form-control clearValCls']) ?>


