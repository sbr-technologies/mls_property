<?php
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile(
    '@web/plugins/underscore.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);

$this->registerJsFile(
    '@web/public_main/js/package_search.js',
    ['depends' => [
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapPluginAsset::ClassName()
        ]
   ]
);
?>
<div class="property-menu-bar hoter-top-bar holiday-package-top-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="hotel-top-barTxt">From <span><?= $locationFromId ?></span></p>
                    </div>

                    <div class="col-sm-6">
                        <p class="hotel-top-barTxt">To <span><?= $locationToId ?></span></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="hotel-top-barTxt">Check-In <span><?= date("m-d-Y h:i:s",$checkin) ?></span></p>
                    </div>
                    <div class="col-sm-6">
                        <p class="hotel-top-barTxt">Check-Out <span><?= date("m-d-Y h:i:s",$checkout) ?></span></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="hotel-top-barTxt text-center">Room <span><?= $days ?></span></p>
                    </div>
<!--                        <div class="col-sm-2">
                        <p class="hotel-top-barTxt text-center">Adults <span>2</span></p>
                    </div>
                    <div class="col-sm-2">
                        <p class="hotel-top-barTxt text-center">Children <span>0</span></p>
                    </div>-->
<!--                    <div class="col-sm-6">
                        <a href="javascript:void(0)" class="btn btn-primary red-btn pull-right">Modify Search</a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>