<?php
use yii\helpers\Html;
use common\models\PropertyType;
use yii\helpers\ArrayHelper;
echo Html::dropDownList('property_types', [], ArrayHelper::map(PropertyType::find()->where(['property_category_id' => $categoryId])->all(), 'id', 'title'),['multiple' => true,'class' => 'form-control multiselect_dropdown']) ?>
       
