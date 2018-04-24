<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\SiteConfig;
$fbUrl = SiteConfig::item('facebookLink');
$lnkdUrl = SiteConfig::item('linkedinLink');

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php //$this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="format-detection" content="telephone=no" />
        
        <style>
            @media screen and ( max-width : 640px ) {
                .pagetable_holder {
                    width: 92% !important;
                }
            }

            @media screen and ( max-width : 440px ) {
                .logo_part img {
                    width: 100% !important;
                }
            }
        </style>
<?php //$this->head() ?>
    </head>
    <body style="color: #666; font: 300 14px/22px 'arial', sans-serif; margin: 0; padding: 0; outline: none; box-sizing: border-box; text-decoration:none; border:none;">
        <?php //$this->beginBody() ?>
        <center>
            <table class="pagetable" style="border-collapse: collapse; border-spacing: 0; width: 100%; margin: 0; padding: 0;">
                <tbody>
                    <tr>
                        <td><table class="pagetable_holder" style="background: #f5f5f5; width: 600px; border: 1px solid #ddd; border-top:5px #ff3030 solid; margin: 0 auto; order-top: none;">
                                <thead>
                                    <tr>
                                        <th class="logo_part" style="padding: 0; background:#fff; text-align: center;">
                                            <a href="<?= Yii::$app->params['homeUrl']?>" style="padding:15px; display:inline-block;">
                                                <?= Html::img(Yii::$app->params['homeUrl']. '/images/logo.png', ['width' => '270', 'alt' => 'Logo']); ?>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="background:#f5f5f5;">
                                        <td style="padding: 15px;">
                                            <?= $content ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background:#f5f5f5;">
                                        <td style="padding: 15px;">
                                            <p style="margin:0; padding:10px 0 0;">Thanks</p>
                                            <p style="margin:0; padding:0;">Support Team</p>
                                            <p class="confirmation" style="padding-bottom: 10px; margin: 0;"><a href="<?= Yii::$app->params['homeUrl']?>" style="font-size: 14px; color: #1d7ecf; font-weight: 400; text-decoration: underline;">NaijaHouses.com</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="footer_bottom" style="background: #242427; padding: 10px 15px; font-size: 13px;">
                                            <table style="border-collapse: collapse; border-spacing: 0; width: 100%; margin: 0; padding: 0;">
                                                <tr>
                                                    <td><a href="<?= Yii::$app->params['homeUrl']?>" style="color: #fff; text-decoration:none;">NaijaHouses.com</a></td>
                                                    <td align="right" style="text-align:right;">
                                                        <a href="<?= $fbUrl?>" style="color: #fff;">
                                                            <?= Html::img(Yii::$app->params['homeUrl']. '/images/facebook_but.png', ['alt' => 'Facebook']); ?>
                                                        </a>
                                                        <a href="<?= $lnkdUrl?>" style="color: #fff;">
                                                            <?= Html::img(Yii::$app->params['homeUrl']. '/images/instagram_but.png', ['alt' => 'Instagram']); ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
<?php //$this->endBody() ?>
    </body>
</html>
<?php //$this->endPage() ?>
