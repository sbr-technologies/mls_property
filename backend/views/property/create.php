<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Property */

$this->title = Yii::t('app', 'Create Property');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-create">

    <?= $this->render('_form', [
        'model'             =>  $model,
        'localInfoModel'    =>  $localInfoModel,
//            'factInfoModel'     =>  $factInfoModel,
        'metaTagModel'      =>  $metaTagModel,
        'taxHistoryModel'   =>  $taxHistoryModel,
        'openHouseModel'    =>  $openHouseModel,
        'featureModel'      =>  $featureModel,
        'featureItemModel'  =>  $featureItemModel,
        'genralFeature'     =>  $genralFeature,
        'contactModels'   =>  $contactModels,
        'contactModel'   =>  $contactModel,
        'propertyShowingContact'    =>  $propertyShowingContact,
        'generalArr'        =>  $generalArr,
    ]) ?>

</div>
