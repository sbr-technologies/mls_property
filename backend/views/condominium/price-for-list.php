<?php
use yii\helpers\Html;
//\yii\helpers\VarDumper::dump($output); exit;
?>

<label class="control-label" >Payment Term</label>
<?= Html::activeDropDownList($model, 'price_for',$output,['class' => 'form-control clearValCls']) ?>

