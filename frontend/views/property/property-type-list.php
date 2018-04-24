<?php
use yii\helpers\Html;
use common\models\PropertyType;
use yii\helpers\ArrayHelper;

$this->registerJsFile(
    '@web/js/property.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/multiselect.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


?>

<label class="control-label" >Property Type</label>

<?php echo Html::activeDropDownList($model, 'propertyTypeId[]',ArrayHelper::map(PropertyType::find()->where(['property_category_id' => $categoryId])->all(), 'id', 'title'),['id' => 'property_type_id_multiselect', 'multiple' => true,'class' => 'form-control clearValCls']) ?>
       
