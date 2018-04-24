<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use common\models\SiteConfig;

$this->title = "Connect : Locate us"
//yii\helpers\VarDumper::dump($staticPage); exit;
?>
<section class="connect_locate">
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
            	<div class="col-sm-12">
                	<h2 class="content-title">Locate us</h2>
                    <div class="row">
                		<div class="col-sm-6">
                    <div class="contact-left-sec">
                        <h3>NIGERIA</h3>
                        <ul class="locate-us">
                            <li><i class="fa fa-home" aria-hidden="true"></i> <em><strong>Address:</strong> <?= SiteConfig::item('addressNigeria')?></em></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i> <em><strong>Phone:</strong> (070)-561-44444</em></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i> <em><strong>Phone:</strong> (070)-562-44444</em></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i> <em><strong>Phone:</strong> (070)-563-44444</em></li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i> <em><strong>Email:</strong> <?= SiteConfig::item('adminEmail')?></em></li>
                            <li><i class="fa fa-desktop" aria-hidden="true"></i> <em><strong>Website:</strong> <?= Yii::$app->params['homeUrl']?></em></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="contact-left-sec">
                        <h3>USA</h3>
                        <ul class="locate-us">
                            <li><i class="fa fa-home" aria-hidden="true"></i> <em><strong>Address:</strong> <?= SiteConfig::item('addressUsa')?></em></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i> <em><strong>Phone:</strong> +1(763)-235-6502</em></li>
                        </ul>
                    </div>
                </div>
                	</div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-bottom-part">
        <iframe height="370" width="100%" src="//www.google.com/maps/embed/v1/place?q=<?= SiteConfig::item('addressNigeria')?>&zoom=12&key=<?= Yii::$app->params['googleMapKey']?>"></iframe>
    </div>
</section>

