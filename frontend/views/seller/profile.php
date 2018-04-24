<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=<?= Yii::$app->params['googleMapKey']?>"></script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use common\models\CallingCodeMaster;
use common\models\SellerCompany;
use kartik\date\DatePicker;


use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\widgets\Pjax;


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
$this->registerJsFile(
    '@web/js/seller.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = 'Seller Profile';
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
                        <li role="presentation"><a href="#agency" aria-controls="sell" role="tab" data-toggle="tab">Company Profile</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about-me">
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['seller/update-profile'],'options' => ['id' => 'update_profile_form']]); ?>
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
                                            <?= $form->field($model, 'sellerID')->textInput(['maxlength' => true,'disabled' => true]) ?>
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
                                            <?= $form->field($model, 'occupation')->dropDownList(['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Business Owner' => 'Business Owner', 'Other' => 'Other'],['prompt' => 'Select','onchange' => 'showHideProfileDiv(this.value);'],['class'=>'selectpicker']) ?>
                                        </div>
                                        <div class="col-sm-6" style="display:none;" id="otherOccupationDiv">
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
                        <?php $form = ActiveForm::begin(['method' => 'post','action' => ['seller/update-address'],'options' => ['class' => 'frm_geocomplete','id' => 'update_address_form']]); ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Personal Address Details:</h5>
                                <!--<p>You haven't setup your blog account yet.</p>-->
                                <?= $this->render('//shared/_address_fields', ['form' => $form, 'model' => $model])?>
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="blogs-socials">
                        <?= Html::beginForm(['seller/manage-social'], 'post', ['id' => 'manage_social_form']) ?>
                            <div class="col-sm-9 form-sec">
                                <div class="row">
                                    <h5>Personal Blog Information:</h5>
                                    <div class="form-group">
                                        <label for="">Blogs:</label>
                                        <?= Html::textInput('SocialMediaLink[blog][url]', isset($sellerSocialMediaModel['blog']['url']) ? $sellerSocialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($sellerSocialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Facebook:</label>
                                        <?= Html::textInput('SocialMediaLink[facebook][url]', isset($sellerSocialMediaModel['facebook']['url']) ? $sellerSocialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($sellerSocialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Twitter:</label>
                                        <?= Html::textInput('SocialMediaLink[twitter][url]', isset($sellerSocialMediaModel['twitter']['url']) ? $sellerSocialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($sellerSocialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Google:</label>
                                        <?= Html::textInput('SocialMediaLink[google][url]', isset($sellerSocialMediaModel['google']['url']) ? $sellerSocialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[google][name]', isset($sellerSocialMediaModel['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Instagram:</label>
                                        <?= Html::textInput('SocialMediaLink[instagram][url]', isset($sellerSocialMediaModel['instagram']['url']) ? $sellerSocialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($sellerSocialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Linkedin:</label>
                                        <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($sellerSocialMediaModel['linkedin']['url']) ? $sellerSocialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($sellerSocialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Youtube:</label>
                                        <?= Html::textInput('SocialMediaLink[youtube][url]', isset($sellerSocialMediaModel['youtube']['url']) ? $sellerSocialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($sellerSocialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                    </div>

    <!--                                <div class="form-group">
                                        <label for="">Pinterest:</label>
                                        <input type="text" class="form-control" placeholder="You haven't setup your Pinterest account yet.">
                                        <a href="javascript:void(0)" class="redTxt">Setup your Pinterest account</a>
                                    </div>-->

                                    <div class="form-group">
                                        <label for="">RSSFeed:</label>
                                        <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($sellerSocialMediaModel['rss_feed']['url']) ? $sellerSocialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                        <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($sellerSocialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </div>
                            </div>
                        <?= Html::endForm() ?>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="agency">
                        <?= Html::beginForm(['seller/manage-company'], 'post', ['id' => 'manage_company_form','class' => 'seller_addr_details']) ?>
                        <div class="col-sm-12 form-sec">
                            <div class="row">
                                <h5>Company Details:</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="">Company Name :</label>
                                                <?= Html::hiddenInput('SellerCompany[id]', $sellerCompanyModel->id, ['class' => 'form-control txt_id readonlyCls']) ?>
                                                <?= Html::textInput('SellerCompany[name]', $sellerCompanyModel->name, ['class' => 'form-control txt_tagline readonlyCls','placeholder' => 'Enter Company Name']) ?>
                                            </div>
                                            <div class="seller_addr_details">
                                                <div class="form-group">
                                                    <label for="">Location:</label>
                                                    <?= Html::textInput('SellerCompany[location]', '', ['class' => 'form-control','id' => 'geocomplete_company']) ?>
                                                    <?= Html::hiddenInput('SellerCompany[lat]', '', ['class' => '','data-geo' => 'lat']) ?>
                                                    <?= Html::hiddenInput('SellerCompany[lng]', '', ['class' => '','data-geo' => 'lng',]) ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Address One:</label>
                                                    <?= Html::textInput('SellerCompany[address1]', $sellerCompanyModel->address1, ['class' => 'form-control','placeholder' => 'Enter Address One','data-geo' => 'name']) ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Address Two:</label>
                                                    <?= Html::textInput('SellerCompany[address2]', $sellerCompanyModel->address2, ['class' => 'form-control','placeholder' => 'Enter Address Two','data-geo' => 'route']) ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">City:</label>
                                                    <?= Html::textInput('SellerCompany[city]', $sellerCompanyModel->city, ['class' => 'form-control','placeholder' => 'Enter City','data-geo' => 'locality']) ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">State:</label>
                                                    <?= Html::hiddenInput('SellerCompany[state]',$sellerCompanyModel->state, ['class' => 'form-control','data-geo' => 'administrative_area_level_1_short']) ?>
                                                    <?= Html::textInput('SellerCompany[state_long]', $sellerCompanyModel->state_long, ['class' => 'form-control','placeholder' => 'Enter State','data-geo' => 'administrative_area_level_1']) ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Country:</label>
                                                    <?= Html::textInput('SellerCompany[country]', $sellerCompanyModel->country, ['class' => 'form-control','placeholder' => 'Enter Country','data-geo' => 'country']) ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for=""> Zip code:</label>
                                                    <?= Html::textInput('SellerCompany[zip_code]', $sellerCompanyModel->zip_code, ['class' => 'form-control','placeholder' => 'Enter Zip Code','data-geo' => 'postal_code']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Contact Contact Info:</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($sellerCompanyModel, 'calling_code')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Mobile1 :</label>
                                                        <?= Html::textInput('SellerCompany[mobile]', $sellerCompanyModel->mobile, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number One','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Office1 :</label>
                                                        <?= Html::textInput('SellerCompany[office1]', $sellerCompanyModel->office1, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number One','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Fax1 :</label>
                                                        <?= Html::textInput('SellerCompany[fax1]', $sellerCompanyModel->fax1, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number One','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($sellerCompanyModel, 'calling_code2')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Mobile2 :</label>
                                                        <?= Html::textInput('SellerCompany[mobile2]', $sellerCompanyModel->mobile2, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Two','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Office2 :</label>
                                                        <?= Html::textInput('SellerCompany[office2]', $sellerCompanyModel->office2, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Two','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Fax2 :</label>
                                                        <?= Html::textInput('SellerCompany[fax2]', $sellerCompanyModel->fax2, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Two','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($sellerCompanyModel, 'calling_code3')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Mobile3 :</label>
                                                        <?= Html::textInput('SellerCompany[mobile3]', $sellerCompanyModel->mobile3, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Office3 :</label>
                                                        <?= Html::textInput('SellerCompany[office3]', $sellerCompanyModel->office3, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Fax3 :</label>
                                                        <?= Html::textInput('SellerCompany[fax3]', $sellerCompanyModel->fax3, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <?= $form->field($sellerCompanyModel, 'calling_code4')->dropDownList(ArrayHelper::map(CallingCodeMaster::find()->all(), 'code', 'name'), ['prompt' => 'Select Country', 'class'=>'txt_calling_code readonlyCls selectpicker']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Other Mobile :</label>
                                                        <?= Html::textInput('SellerCompany[mobile4]', $sellerCompanyModel->mobile4, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Other Office :</label>
                                                        <?= Html::textInput('SellerCompany[office4]', $sellerCompanyModel->office4, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="">Other Fax :</label>
                                                        <?= Html::textInput('SellerCompany[fax4]', $sellerCompanyModel->fax4, ['class' => 'form-control txt_mobile readonlyCls','placeholder' => 'Enter Mobile Number Three','onkeypress'=>'return isNumberKey(event)']) ?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="">Email Address :</label>
                                                <?= Html::textInput('SellerCompany[email]', $sellerCompanyModel->email, ['class' => 'form-control txt_email','placeholder' => 'Enter Email Address']) ?>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="">Web Address:</label>
                                                <?= Html::textInput('SellerCompany[web_address]', $sellerCompanyModel->web_address, ['class' => 'form-control txt_web_address readonlyCls','placeholder' => 'Enter Web Address']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5>Seller Company Blog & Social Info:</h5>
                                <div class="nar-information">
                                    <div class="col-sm-12">
                                        <div class="row">    
                                            <div class="form-group office-info-social">
                                                <?= Html::textInput('SocialMediaLink[facebook][url]', isset($socialMediaModel['facebook']['url']) ? $socialMediaModel['facebook']['url'] : '', ['class' => 'form-control social_facebook readonlyCls','placeholder' => 'Enter Facebook ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[facebook][name]', isset($socialMediaModel['facebook']['url']) ? 'facebook' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Facebook ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[twitter][url]', isset($socialMediaModel['twitter']['url']) ? $socialMediaModel['twitter']['url'] : '', ['class' => 'form-control social_twitter readonlyCls','placeholder' => 'Enter Twitter ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[twitter][name]', isset($socialMediaModel['twitter']['url']) ? 'twitter' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Twitter ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[instagram][url]', isset($socialMediaModel['instagram']['url']) ? $socialMediaModel['instagram']['url'] : '', ['class' => 'form-control social_instagram readonlyCls','placeholder' => 'Enter Instagram ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[instagram][name]', isset($socialMediaModel['instagram']['url']) ? 'instagram' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Instagram ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[linkedin][url]', isset($socialMediaModel['linkedin']['url']) ? $socialMediaModel['linkedin']['url'] : '', ['class' => 'form-control social_linkedin readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[linkedin][name]', isset($socialMediaModel['linkedin']['url']) ? 'linkedin' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Linkedin ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[blog][url]', isset($socialMediaModel['blog']['url']) ? $socialMediaModel['blog']['url'] : '', ['class' => 'form-control social_blog readonlyCls','placeholder' => 'Enter Blog ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[blog][name]', isset($socialMediaModel['blog']['url']) ? 'blog' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Blog ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[interest][url]', isset($socialMediaModel['interest']['url']) ? $socialMediaModel['interest']['url'] : '', ['class' => 'form-control social_interest readonlyCls','placeholder' => 'Enter Interest ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[interest][name]', isset($socialMediaModel['interest']['url']) ? 'interest' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Interest ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[rss_feed][url]', isset($socialMediaModel['rss_feed']['url']) ? $socialMediaModel['rss_feed']['url'] : '', ['class' => 'form-control social_rss_feed readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[rss_feed][name]', isset($socialMediaModel['rss_feed']['url']) ? 'rss_feed' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter RSS Feed ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[youtube][url]', isset($socialMediaModel['youtube']['url']) ? $socialMediaModel['youtube']['url'] : '', ['class' => 'form-control social_youtube readonlyCls','placeholder' => 'Enter Youtube ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[youtube][name]', isset($socialMediaModel['youtube']['url']) ? 'youtube' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter Youtube ID']) ?>

                                                <?= Html::textInput('SocialMediaLink[google][url]', isset($socialMediaModel['google']['url']) ? $socialMediaModel['google']['url'] : '', ['class' => 'form-control social_google readonlyCls','placeholder' => 'Enter google ID']) ?>
                                                <?= Html::hiddenInput('SocialMediaLink[google][name]', isset($socialMediaModel['google']['url']) ? 'google' : '', ['class' => 'form-control readonlyCls','placeholder' => 'Enter google ID']) ?>
                                            </div>

                                            <div class="form-group">
                                                <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                                            </div>
                                        </div>
                                    </div>
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