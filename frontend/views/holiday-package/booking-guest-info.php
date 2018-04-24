<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\View;

use common\models\BannerType;
use common\models\Banner;
use common\models\HolidayPackage;

$this->registerJsFile(
    '@web/plugins/validation/jquery.validate.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/plugins/validation/additional-methods.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
    '@web/js/subscription.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$guestDetailsArr =  Yii::$app->session->get('guestDetails');

$this->registerJsFile(
    '@web/public_main/js/site.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = "Online Booking Holiday Package";
$bannerType     = BannerType::findByName('Package Booking');
$banner         = Banner::find()->where(['type_id' => $bannerType->id])->active()->one();
$packageModel   = HolidayPackage::find()->where(['id' => $guestDetailsArr['holiday_package_id']])->active()->one();
if(isset($guestDetailsArr['holiday_package_id']) && $guestDetailsArr['holiday_package_id'] != ''){
    unset($guestDetailsArr['holiday_package_id']);
}
$totalguest     =   count($guestDetailsArr);
//\yii\helpers\VarDumper::dump($packageModel,4,12); exit;
?>
<!-- Start Content Section ==================================================-->
<section>
    <div class="inner-content-sec">
        <div class="container">
            <div class="row">
                <?php $form = ActiveForm::begin(['options' => ['class' => '','id' => 'frm_capture_guest_booking_data']]); ?>
                <?= $form->field($packageBooking, 'holiday_package_id')->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $packageModel->id])->label(false) ?>
                <?= $form->field($packageBooking, 'departure_date')->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $packageModel->departure_date])->label(false) ?>
                <div class="col-sm-12">
                    <div class="online-booking-sec">
                        <h2>Online Booking</h2>
                        <div class="occupancy-box-sec">
                            <div class="occupancy-title-bar">
                                <div class="col-sm-4 text-left">
                                    <h3>Package Details</h3>
                                </div>
                                <div class="col-sm-4 text-left">
                                    <h3>Departure Date : <?= date("d-m-Y",$packageModel->departure_date) ?></h3>
                                </div>
                                <div class="col-sm- text-right">
                                    <h3>Price : <?= $packageModel->package_amount ?> / person</h3>
                                    <?= $form->field($packageModel, 'package_amount')->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $packageModel->package_amount])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <p><?= $packageModel->description ?></p>
                                <ul>
                                    <li><strong>Name:</strong> <?= $packageModel->name ?></li>
                                    <li><strong>Day/Night:</strong> <?= $packageModel->no_of_days ? $packageModel->no_of_days."(D)" : "" ?> <?= $packageModel->no_of_nights ? $packageModel->no_of_nights."(N)" : "" ?></li>
                                    <li><strong>From:</strong> <?= $packageModel->source_city ?></li>
                                    
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <p><?= $packageModel->description ?></p>
                                <ul>
                                    
                                    <li><strong>To:</strong> <?= $packageModel->destination_city ?></li>
                                    <li><strong>Inclusion :</strong> <?= $packageModel->inclusion ?></li>
                                    <li><strong>Exclusions :</strong> <?= $packageModel->exclusions ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="guest-box-sec">
                            <h3>Guest Details</h3>
                            <?php 
                            if(!empty($guestDetailsArr)){
                                $sl =1;
                            ?>
                            <table class="table table-striped" width="100%">
                                <thead>
                                    <th class="text-center">Sl.</th>
                                    <th class="text-center">First Name </th>
                                    <th class="text-center">Middle Name </th>
                                    <th class="text-center">Last Name </th>
                                    <th class="text-center">Age</th>
                                    <th class="text-center">Gender</th>
                                </thead>
                                <tbody>
                                    <?php
                                                   //             \yii\helpers\VarDumper::dump($packageGuest,4,12); exit;
                                    foreach($guestDetailsArr as $key => $guest){
                                        foreach($packageGuest as $package){
                                            echo $form->field($package,"[$key]first_name")->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $guest['first_name']])->label(false);
                                            echo $form->field($package,"[$key]middle_name")->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $guest['middle_name']])->label(false);
                                            echo $form->field($package,"[$key]last_name")->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $guest['last_name']])->label(false);
                                            echo $form->field($package,"[$key]age")->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $guest['age']])->label(false);
                                            echo $form->field($package,"[$key]gender")->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $guest['gender']])->label(false);
                                        }
                                        if(isset($guest['gender']) && $guest['gender'] != ''){
                                            if($guest['gender'] == 1){
                                                $gender = "Male";
                                            }else if($guest['gender'] == 2){
                                                $gender = "Female";
                                            }
                                        }else{
                                            $gender = "N/A";
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $sl ?></td>
                                            <td class="text-center"><?= $guest['first_name'] ?></td>
                                            <td class="text-center"><?= $guest['middle_name'] ?></td>
                                            <td class="text-center"><?= $guest['last_name'] ?></td>
                                            <td class="text-center"><?= $guest['age'] ?></td>
                                            <td class="text-center"><?= $gender ?></td>
                                        </tr>
                                    <?php
                                    $sl++;
                                    }
                                    ?>
                                        <tr>
                                            <td class="text-center"><font color="red"><b>Total</b></td>
                                            <td colspan="5" class="text-right">
                                                <strong><?= $packageModel->package_amount*$totalguest ?></strong>
                                                <?= $form->field($packageBooking,"amount")->hiddenInput(['maxlength' => true,'class'=>'form-control','value' => $packageModel->package_amount*$totalguest])->label(false) ?>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="manage-profile-form-sec">
                        <div class="manage-profile-tab-bar">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#paypal-payment" aria-controls="paypal-payment" role="tab" data-toggle="tab">Paypal Payment</a></li>
                                <li role="presentation"><a href="#card-payment" aria-controls="card-payment" role="tab" data-toggle="tab">Credit Card Payment</a></li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="paypal-payment">
                                <div class="col-sm-9 form-sec">
                                    <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas dolor elit, ullamcorper et metus in, sodales hendrerit risus.</h5>
                                    <p><a href="<?= Url::to(['holiday-package/process-express-checkout', 'selected_plan_id' => $packageModel->id]); ?>" class="btn btn-primary btn-lg">Paypal Payment</a></p>

                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="card-payment">
                                <div class="col-sm-6 form-sec card-payment-form">
                                    <div class="row">
                                        <?= Html::beginForm(['subscription/process-card'], 'post', ['id' => 'frm_creditcard_process', 'autocomplete' => 'off']) ?>
                                        <input type="hidden" name="card[type]" class="txt_card_type" />
                                        <input type="hidden" name="selected_plan_id" value="<?= $packageModel->id ?>" />
                                        <div class="box box-default box-solid table-listing">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Fill the Credit Card Form</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group card-no-field">
                                                    <label for="">Enter Card Number:</label>
                                                    <input type="text" name="card[card_number]" class="form-control txt_card_number" required="" placeholder="Enter your card number">
                                                    <div class="card-icons">
                                                        <div class="all-icons"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label for="">Expiry Date:</label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <select name="card[exp_month]" required="">
                                                                        <option value="">MM</option>
                                                                        <?php
                                                                        for ($month = 1; $month <= 12; $month++) {
                                                                            $date_str = date('M', strtotime("2000-$month-01"));
                                                                            echo "<option value=$month>" . $date_str . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <?= Html::dropDownList('card[exp_year]', '', array_combine(range(date('Y'), date('Y') + 20), range(date('Y'), date('Y') + 20)), ['prompt' => 'YYYY', 'required' => 'true']) ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <label for="">CVV:</label>
                                                            <input type="text" name="card[cvv2]" class="form-control" placeholder="Enter your cvv no" required="" maxlength="3">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Name on card:</label>
                                                    <input type="text" name="card[cardholder_name]" class="form-control" placeholder="Enter the name found on the card" required="">
                                                </div>

                                                <div class="form-group">
                                                    <button name="" type="submit" class="btn btn-default red-btn">Pay Now</button>
                                                    <button name="" type="submit" class="btn btn-default gray-btn">Cancel</button>
                                                </div>
                                            </div>
                                        </div>

                                        <?= Html::endForm() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
<!-- Start Content Section ==================================================-->
