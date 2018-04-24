<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Property */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Property',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-update">
    <?= $this->render('_form', [
        'model'             => $model, 
        'localInfoModel'    =>  $localInfoModel,
        'factInfoModel'     =>  $factInfoModel,
        'metaTagModel'      =>  $metaTagModel,
        'agentSocialMediaArr' =>  $agentSocialMediaArr,
        'taxHistoryModel'   =>  $taxHistoryModel,
        'openHouseModel'    =>  $openHouseModel,
        'featureModel'      =>  $featureModel,
        'genralFeature'     =>  $genralFeature,
        'generalArr'        =>  $generalArr,
        'contactModels'   =>  $contactModels,
        'contactModel'   =>  $contactModel,
        'propertyShowingContact' => $propertyShowingContact,
        'generalArr'        =>  $generalArr,
    ]) ?>

</div>
