<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyAR-AyVns1IfLo5DoeSKms1xJ9XDuN4qCc"></script>
<?php
echo 11;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\Agency;
use kartik\date\DatePicker;


use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile(
//    'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places'
//);

$this->registerJsFile(
    '@web/js/jquery.geocomplete.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/location.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = 'Hotel Owner Profile';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Manage Profile</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Manage Profile</li>
        </ol>
    </section>
    <!-- Content Title Sec -->
    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <!-- Photo Upload Sec -->
            <?php echo $this->render('//shared/_my_profile_top.php')?>
            <!-- Photo Upload Sec -->
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="sucmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="failmsgdiv"></span>
            </div>
            <!-- Manage Profile Form -->
            <div class="manage-profile-form-sec">
                <div class="manage-profile-tab-bar">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about-me" aria-controls="buy" role="tab" data-toggle="tab">About Me</a></li>
                        <li role="presentation"><a href="#address" aria-controls="rent" role="tab" data-toggle="tab">Address</a></li>
                        <li role="presentation"><a href="#blogs-socials" aria-controls="sell" role="tab" data-toggle="tab">Blogs & Socials</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about-me">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['hotel-owner/update-profile'],'options' => ['id' => 'update_profile_form']]); ?>
                        <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true,'class'=>'form-control'])->label(false) ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Personal Information:</h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'salutation')->dropDownList(['mr.' => 'Mr.', 'mrs.' => 'Mrs.', 'miss' => 'Miss.'],['prompt' => 'Select'],['class'=>'selectpicker']) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter First Name']) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Middle Name']) ?>
                                        </div>

                                        <div class="col-sm-3">
                                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>'Enter Last Name']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'short_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter Short Name']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'hotelOwnerID')->textInput(['maxlength' => true,'disabled' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= $form->field($model, 'gender')->dropDownList([$model::GENDER_MALE => 'Male', $model::GENDER_FEMALE => 'Female'], ['prompt' => 'Select Gender']) ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php
                                        echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                                            'options' => ['placeholder' => 'DD/MM/YYYY'],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => Yii::$app->params['dateFormatJs']
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php
                                        if ($model->isNewRecord) {
                                            $model->timezone = 'Africa/Lagos';
                                        }
                                        ?>
                                        <?= $form->field($model, 'timezone')->dropDownList(ArrayHelper::map(\common\models\TimezoneMaster::find()->all(), 'name', 'label'), ['prompt' => 'Select Timezone']) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'],['prompt' => 'Select'],['class'=>'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-6" style="display:<?php if($model->occupation == 'Other') echo 'block';else echo 'none'?>;" id="otherOccupationDiv">
                                            <?= $form->field($model, 'occupation_other')->textInput(['maxlength' => true,'class'=>'form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?= $this->render('//shared/_phone_fields', ['form' => $form, 'model' => $model])?>

                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="address">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['hotel-owner/update-address'],'options' => ['class' => 'frm_geocomplete','id' => 'update_address_form']]); ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Personal Address Details:</h5>
                                <!--<p>You haven't setup your blog account yet.</p>-->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $form->field($model, 'location')->textInput(['maxlength' => true, 'id' => 'geocomplete']) ?>
                                            <?= $form->field($model, 'lat')->hiddenInput(['class' => 'lat'])->label(false) ?>
                                            <?= $form->field($model, 'lng')->hiddenInput(['class' => 'lng'])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'street_address')->textInput(['maxlength' => true, 'class' => 'formatted_address small-height-textarea form-control']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'street_number')->textInput(['maxlength' => true, 'class' => 'street_number small-height-textarea form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'sub_area')->textInput(['maxlength' => true, 'class' => 'sublocality form-control']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'local_govt_area')->textInput(['maxlength' => true, 'class' => 'small-height-textarea form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'urban_town_area')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'district')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                           <?= $form->field($model, 'town')->textInput(['maxlength' => true, 'class' => 'locality small-height-textarea form-control']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'state')->textInput(['class' => 'administrative_area_level_1 form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'country')->textInput(['maxlength' => true, 'class' => 'country form-control']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true, 'class' => 'postal_code small-height-textarea form-control']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="blogs-socials">
                        <?= Html::beginForm(['hotel-owner/manage-social'], 'post', ['id' => 'manage_social_form']) ?>
                            <div class="col-sm-9 form-sec">
                                <div class="row">
                                    <h5>Personal Blog Information:</h5>
                                    <div class="form-group">
                                        <label for="">Blogs:</label>
                                        <?= Html::textInput('SocialMediaLink[blog][url]', isset($buyerSocialMediaModel['blog']['url']) ? $buyerSocialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($buyerSocialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Facebook:</label>
                                        <?= Html::textInput('SocialMediaLink[facebook][url]', isset($buyerSocialMediaModel['facebook']['url']) ? $buyerSocialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($buyerSocialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Twitter:</label>
                                        <?= Html::textInput('SocialMediaLink[twitter][url]', isset($buyerSocialMediaModel['twitter']['url']) ? $buyerSocialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($buyerSocialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Google:</label>
                                        <?= Html::textInput('SocialMediaLink[google][url]', isset($buyerSocialMediaModel['google']['url']) ? $buyerSocialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[google][name]', isset($buyerSocialMediaModel['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Instagram:</label>
                                        <?= Html::textInput('SocialMediaLink[instagram][url]', isset($buyerSocialMediaModel['instagram']['url']) ? $buyerSocialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($buyerSocialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Linkedin:</label>
                                        <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($buyerSocialMediaModel['linkedin']['url']) ? $buyerSocialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($buyerSocialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Youtube:</label>
                                        <?= Html::textInput('SocialMediaLink[youtube][url]', isset($buyerSocialMediaModel['youtube']['url']) ? $buyerSocialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($buyerSocialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                    </div>

    <!--                                <div class="form-group">
                                        <label for="">Pinterest:</label>
                                        <input type="text" class="form-control" placeholder="You haven't setup your Pinterest account yet.">
                                        <a href="javascript:void(0)" class="redTxt">Setup your Pinterest account</a>
                                    </div>-->

                                    <div class="form-group">
                                        <label for="">RSSFeed:</label>
                                        <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($buyerSocialMediaModel['rss_feed']['url']) ? $buyerSocialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($buyerSocialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </div>
                            </div>
                        <?= Html::endForm() ?>
                    </div>
                    
                </div>
            </div>
            <!-- Manage Profile Form -->
        </div>
    </section>
    
    <!-- Main content -->
</div>
<?php
$js = "$(function(){
    $('#hotelowner-occupation').on('change', function(){
        if($(this).val() == 'Other'){
            $('#otherOccupationDiv').show();
        }else{
            $('#otherOccupationDiv').hide().find('input').val('');
        }
    });
    });";

$this->registerJs($js, View::POS_END);