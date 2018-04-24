<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\View;
use common\models\BannerType;
use common\models\Banner;

$this->registerJsFile(
    '@web/public_main/js/site.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = "Online Booking Holiday Package";
$bannerType     = BannerType::findByName('Package Booking');
//\yii\helpers\VarDumper::dump($bannerType); exit;
$banner         = Banner::find()->where(['type_id' => $bannerType->id])->active()->one();

?>
<!-- Start Content Section ==================================================-->
<section>
    <div class="about-top-part">
        <?php
        if (!empty($banner)) {
            $bannerUrl      =   '';
            $photo = $banner->photo;
            $alias = $photo->getImageUrl();      
            //echo $alias;
        }
        if(!empty($alias)){
        ?>
            <img src="<?= $alias ?>" alt="" height ='350px' />
        <?php
        }else{
            echo Html::img(Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'),['alt' => '','height' => '350px']);
        } ?>
    </div>

    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="online-booking-sec">
                        <h2>Online Booking</h2>
                        <div class="occupancy-box-sec">
                            <div class="occupancy-title-bar">
                                <div class="col-sm-6 text-left">
                                    <h3>Package Details</h3>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <h3>Price : <?= $packageModel->package_amount ?></h3>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p><?= $packageModel->description ?></p>
                                <ul>
                                    <li><strong>Name:</strong> <?= $packageModel->name ?></li>
                                    <li><strong>Day/Night:</strong> <?= $packageModel->no_of_days ? $packageModel->no_of_days."(D)" : "" ?> <?= $packageModel->no_of_nights ? $packageModel->no_of_nights."(N)" : "" ?></li>
                                    <li><strong>From:</strong> <?= $packageModel->source_city ?></li>
                                    <li><strong>To:</strong> <?= $packageModel->destination_city ?></li>
                                    <li><strong>Inclusion :</strong> <?= $packageModel->inclusion ?></li>
                                    <li><strong>Exclusions :</strong> <?= $packageModel->exclusions ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="guest-box-sec">
                            <h3>Guest Details</h3>
                            <?php 
                            $tempGuestInfo    =   new \common\models\HolidayBookingGuest();
                            ?>
                            <?php $form = ActiveForm::begin(['action' => 'booking-guest-info','method' => 'post', 'options' => ['autocomplete' => 'off']]); ?>
                            <?= $form->field($tempGuestInfo, 'holiday_package_id')->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $packageModel->id])->label(false) ?>
                                <div class="guest-form-sec">  
                                    <div class="row dv_package_booking_info_container">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group text-center">
                                        <button name="" type="button" class="btn_add_package_booking_info btn btn-default"><span>+</span> Add New Guest</button>
                                    </div>
                                    <div class="form-group text-center">
                                        <?= Html::submitButton('Confirm Booking', ['class' => 'btn btn-default btn-lg red-btn', 'name' => 'login-button']) ?>
                                    </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->
<?php 
$tempGuestInfo    =   new common\models\HolidayBookingGuest();
?>
<div style="display: none" class="dv_package_booking_block_template">
    <div class="item new">
        <?= Html::activeHiddenInput($tempGuestInfo, '[curTime]id')?>
        <div class="form-group">
            <div class="col-sm-2">
                <?= Html::activeTextInput($tempGuestInfo, '[curTime]first_name', ['class' => 'form-control','placeholder' => 'First Name'])?>
            </div>
            <div class="col-sm-2">
                <?= Html::activeTextInput($tempGuestInfo, '[curTime]middle_name', ['class' => 'form-control','placeholder' => 'Middle Name'])?>
            </div>
            <div class="col-sm-2">
                <?= Html::activeTextInput($tempGuestInfo, '[curTime]last_name', ['class' => 'form-control','placeholder' => 'Last Name'])?>
            </div>
            <div class="col-sm-2">
                <?= Html::activeTextInput($tempGuestInfo, '[curTime]age', ['class' => 'form-control','placeholder' => 'Age'])?>
            </div>
            <div class="col-sm-2">
                <?= Html::activeDropDownList($tempGuestInfo, '[curTime]gender', [$tempGuestInfo::GENDER_MALE => 'Male', $tempGuestInfo::GENDER_FEMALE => 'Female'],['prompt' => 'Select Gender'], ['prompt' => 'Select Feature', 'class' => 'form-control'])?>
            </div>
            <div class="col-sm-2">
                <?= Html::activeHiddenInput($tempGuestInfo, "[curTime]_destroy", ['class' => 'hidin_child_id']) ?>
                <a data-toggle="tooltip" class="btn btn-danger btn-lg tooltip-test delete_child" title="" data-original-title="<?= Yii::t('app', 'Delete row') ?>">
                <i class="fa fa-trash-o"></i> Remove</a>
            </div>
        </div>
    </div>
</div>