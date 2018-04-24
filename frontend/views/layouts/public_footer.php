<?php

use yii\helpers\Html;
use common\models\StaticBlock;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use yii\helpers\Inflector;
use yii\helpers\Url;


//$this->registerJsFile(
//    '@web/js/site.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
//);
?>

<?php 
$handlers = new HandlerContainer();
$handlers->add('SITE_NAME', function(ShortcodeInterface $s) {
//    return sprintf('%s', $s->getParameter('name'));
    return Yii::$app->name;
});
$processor = new Processor(new RegularParser(), $handlers);
$copyRight = StaticBlock::findByTitle('Copy Rights');

$footerBlock1   =   StaticBlock::findByTitle('Footer Block1');
$footerBlock2   =   StaticBlock::findByTitle('Footer Block2');
$footerBlock3   =   StaticBlock::findByTitle('Footer Block3');
$footerBlock4   =   StaticBlock::findByTitle('Footer Block4');
$footerBlock5   =   StaticBlock::findByTitle('Footer Block5');

$handlers->add('FEATURE_IMAGE', function(ShortcodeInterface $s) {
    $name = $s->getParameter('name');
//    echo $name; die();
    $block = StaticBlock::findByTitle(Inflector::camel2words($name));
    if(isset($block->photo)){
        return $block->photo->imageUrl;
    }
    
});
?>
<!-- Start Footer Section ==================================================-->
<footer>
    <!-- Home Newsletter Sec -->
    <div class="footer-newsletter-sec">
        <div class="container">
            <div class="row">
                <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                    <span class="sucmsgdiv"></span>
                </div>
                <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                    <span class="failmsgdiv"></span>
                </div>
                <div class="col-sm-5">
                    <h2>Subscribe our Newsletter:</h2>
                </div>
                <div class="col-sm-7">
                    <?php echo Html::beginForm(['newsletter/subscribe'],'post',['class'=> 'frm_newsletter_subscribe']) ?>
                        <div class="col-sm-9 pleft pright">
                            <?php echo Html::textInput('email', '', ['maxlength' => true,'class' =>'form-control emailCls','placeholder'=>'Enter your email']) ?>
                        </div>
                        <div class="col-sm-3 pleft">
                            <?= Html::submitButton(Yii::t('app', 'Subscribe'), ['class' => 'btn btn-default']) ?>
                        </div>
                    <?php echo Html::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Home Newsletter Sec -->
    <!-- Footer Top -->
    <div class="footer-top-sec">
        <div class="container">
            <div class="row">
                <?php if(!empty($footerBlock1)){
                    echo $processor->process($footerBlock1->content);
                  }
                ?>

                <div class="col-sm-8">
                    <div class="row">
                        <?php if(!empty($footerBlock2)){
                            echo $processor->process($footerBlock2->content);
                          }
                        ?>
                        <?php if(!empty($footerBlock3)){
                            echo $processor->process($footerBlock3->content);
                          }
                        ?>
                        <?php if(!empty($footerBlock4)){
                            echo $processor->process($footerBlock4->content);
                          }
                        ?>
                        <?php if(!empty($footerBlock5)){
                            echo $processor->process($footerBlock5->content);
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top -->

    <!-- Footer Bottom -->
    <div class="footer-bottom-sec">
        <div class="container">
            <div class="row">
                <div class="footer-nav">
                    <ul>
                        <li><a href="<?php echo Url::to(['site/index']) ?>">Home</a></li>
                        <li><a href="<?php echo Url::to(['site/about']) ?>">About</a></li>
                        <li><a href="<?php echo Url::to(['blog/index']) ?>">Blog</a></li>
                        <li><a href="<?php echo Url::to(['site/contact']) ?>">Contact</a></li>
                        <li><a href="<?php echo Url::to(['site/terms-condition']) ?>">Terms and Conditions</a></li>
                        <li><a href="<?php echo Url::to(['site/privacy-policy']) ?>">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom-btn-sec">
            <div class="container">
                <div class="row">
                  <?php if(!empty($copyRight)){
                    echo $processor->process($copyRight->content);
                  }?>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom -->
</footer>
<!-- Scroll To Top -->
<a href="javascript:void(0)" class="scrollToTop"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
<!-- Scroll To Top -->
<!-- End Footer Section ==================================================-->
