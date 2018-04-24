<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\StaticPage;
use common\models\VideoGallery;




$staticPage = StaticPage::findByName('Contact Us');
$takeTour   = VideoGallery::findByTitle('Take a Tour');
if(!empty($takeTour)){
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $takeTour->youtube_video_code, $matches);
}
 //'video_id' => $matches[1],
//yii\helpers\VarDumper::dump($matches[1]); exit;
$this->title = $staticPage->pageTitle;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $staticPage->meta_description
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $staticPage->meta_keywords
]);

//yii\helpers\VarDumper::dump($staticPage); exit;
?>
<section>
    <div class="contact-top-part">
        <img src="<?= $staticPage->photos[0]->imageUrl ?>" alt="">
        <div class="contact-top-con">
            <?php
            if (!empty($staticPage)) {
                echo $staticPage->content;
            }
            ?>
        </div>
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="contact-sec">
                    <div class="col-sm-8">
                        <h2 class="content-title">Contact Us</h2>
                        <div class="contact-left-sec">
                            <h3>MLS Properties</h3>
                            <p>Lorem ipsum street, Suite 32 <br>South West Park Avenue, Lipsum City, NY</p>
                            <iframe width="100%" height="370" frameborder="0" allowfullscreen="" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3029.8753128092744!2d-73.68493618419028!3d40.588507579345475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c26f8c00cf8693%3A0x42dd383207dfde57!2sW+Park+Ave%2C+Long+Beach%2C+NY+11561%2C+USA!5e0!3m2!1sen!2sin!4v1488872349344"></iframe>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="contact-right-sec">
                            <div class="contact-top-icon"><i aria-hidden="true" class="fa fa-envelope"></i></div>
                            <h3>Leave Us a Note</h3>
                            <p>We welcome your feedback &amp; questions</p>
                            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                                <!--<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>-->
                                <span class="sucmsgdiv"></span>
                            </div>
                            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                                <!--<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>-->
                                <span class="failmsgdiv"></span>
                            </div>
                            <?php $form = ActiveForm::begin(['method' => 'post','action' => ['connect/contact'],'options' => ['id' => 'contact-form']]); ?>
                                <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'],['prompt' => 'I am']) ?>
                                
                                <?= $form->field($model, 'full_name')->textInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Full Name']) ?>
                                
                                <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Email Address']) ?>
                            
                                <?= $form->field($model, 'subject')->textInput(['autofocus' => true,'class' => 'form-control','placeholder' => 'Subject']) ?>
                                
                                <?= $form->field($model, 'message')->textarea() ?>
                                
                                <div class="form-group text-center">
                                    <button class="btn btn-primary btn-lg red-btn send-conact-btn" type="submit" name="">Send it <i aria-hidden="true" class="fa fa-paper-plane"></i></button>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-bottom-part">
        <?php
        if(isset($matches[1]) && $matches[1] != ''){
        ?>
        <iframe width="1280" height="350" src="https://www.youtube.com/embed/<?= $matches[1]?>" frameborder="0" allowfullscreen></iframe>
        <?php } ?>
        
    </div>
</section>

