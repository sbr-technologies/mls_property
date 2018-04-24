<?php

use yii\helpers\Html;
/** @var $this View */
/** @var $id string */
/** @var $services stdClass[] See EAuth::getServices() */
/** @var $action string */
/** @var $popup bool */
/** @var $assetBundle string Alias to AssetBundle */
Yii::createObject(array('class' => $assetBundle))->register($this);

// Open the authorization dilalog in popup window.
if ($popup) {
    $options = array();
    foreach ($services as $name => $service) {
        $options[$service->id] = $service->jsArguments;
    }
    $this->registerJs('$("#' . $id . '").eauth(' . json_encode($options) . ');');
}
?>
<div class="eauth" id="<?php echo $id; ?>">
        <?php
        foreach ($services as $name => $service) {
            echo Html::a('<span><i class="fa fa-'.strtolower($service->title).'" aria-hidden="true"></i></span> '.  $service->title.' Login', array($action, 'service' => $name), array(
                'class' => strtolower($service->title).'-login',
                'data-eauth-service' => $service->id,
            ));
        }
        ?>
</div>