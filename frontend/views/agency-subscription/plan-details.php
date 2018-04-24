<?php 
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Plan: '. $model->title;

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
?>
<div class="content-wrapper">
  <!-- Content Title Sec -->
  <section class="content-header">
    <h1>Subscription</h1>
    <ol class="breadcrumb">
      <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li><a href="subscription.html">Subscription</a></li>
      <li class="active">Subscription Details</li>
    </ol>
  </section>
  <!-- Content Title Sec -->

  <!-- Main content -->
  <section class="content">
    <div class="content-inner-sec">
      <div class="col-sm-12">
        <div class="box box-primary box-solid table-listing">
          <div class="box-header with-border">
            <h3 class="box-title">Subscription Plan Details</h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered text-center">
              <tbody>
                <tr>
                  <th>Plan</th>
                  <th>Price</th>
                  <th>Details</th>
                </tr>
                <tr>
                  <td><?= $model->title?></td>
                  <td>
                    <div class="form-group">
                        <?php if(!$duration){?>
                            <?= Yii::$app->formatter->asCurrency($model->amount) ?> For 30 Days
                        <?php }elseif($duration == 3){?>
                            <?= Yii::$app->formatter->asCurrency($model->amount_for_3_months) ?> For 3 Months
                        <?php }elseif($duration == 6){?>
                            <?= Yii::$app->formatter->asCurrency($model->amount_for_6_months) ?> For 6 Months
                        <?php }elseif($duration == 12){?>
                            <?= Yii::$app->formatter->asCurrency($model->amount_for_12_months) ?> For 12 Months
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <form name="frm_duration" action="<?= Url::to(['agency-subscription/plan-details']);?>">
                            <input type="hidden" name="id" value="<?= $model->id?>" />
                            <select class="form-control" name="duration" onchange="this.form.submit();">
                            <option value=""><?= Yii::$app->formatter->asCurrency($model->amount)?> For 30 Days</option>
                            <?php if($model->amount_for_3_months){?>
                            <option value="3" <?php if($duration == 3)echo 'selected';?>><?= Yii::$app->formatter->asCurrency($model->amount_for_3_months)?> For 3 Months</option>
                            <?php }?>
                            <?php if($model->amount_for_6_months){?>
                            <option value="6" <?php if($duration == 6)echo 'selected';?>><?= Yii::$app->formatter->asCurrency($model->amount_for_6_months)?> For 6 Months</option>
                            <?php }?>
                            <?php if($model->amount_for_6_months){?>
                            <option value="12" <?php if($duration == 12)echo 'selected';?>><?= Yii::$app->formatter->asCurrency($model->amount_for_12_months)?> For 12 Months</option>
                            <?php }?>
                            </select>
                        </form>
                    </div>
                  </td>
                  <td><?= nl2br($model->description)?></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
<?php if($model->amount > 0){?>
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
                <p><a href="<?= Url::to(['agency-subscription/process-express-checkout', 'selected_plan_id' => $model->id, 'duration' => $duration]);?>" class="btn btn-primary btn-lg">Paypal Payment</a></p>
              </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="card-payment">
              <div class="col-sm-6 col-md-7 col-lg-6 form-sec card-payment-form">
                <div class="row">
                  <?= Html::beginForm(['agency-subscription/process-card'], 'post', ['id' => 'frm_creditcard_process', 'autocomplete' => 'off'])?>
                  <input type="hidden" name="card[type]" class="txt_card_type" />
                  <input type="hidden" name="selected_plan_id" value="<?= $model->id?>" />
                  <input type="hidden" name="duration" value="<?= $duration?>" />
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
                              <div class="row expiry-date-sec">
                                <div class="col-sm-6">
                                  <select name="card[exp_month]" required="">
                                    <option value="">MM</option>
                                    <?php
                                    for ($month = 1; $month <= 12; $month++) {
                                        $date_str = date('M', strtotime("2000-$month-01"));
                                        echo "<option value=$month>".$date_str ."</option>";
                                    } 
                                    ?>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                  <?= Html::dropDownList('card[exp_year]', '', array_combine(range(date('Y'), date('Y') + 20), range(date('Y'), date('Y') + 20)), ['prompt' => 'YYYY', 'required' => 'true'])?>
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

                  <?= Html::endForm()?>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php }else{?>
    <a href="<?= Url::to(['agency-subscription/subscribe', 'selected_plan_id' => $model->id]);?>" class="btn btn-primary btn-lg">Subscribe</a>
<?php }?>
      </div>

    </div>
  </section>
  <!-- Main content -->
</div>
<?php
$js ="$(function(){
    
        $('.txt_card_number').on('keyup', function(){
            var cardNumber = $(this).val();
            if(cardNumber == ''){
                $('.card-icons').removeClass('visa').removeClass('mastercard');
                $('.txt_card_type').val('');
                return;
            }
            var cardType = GetCardType(cardNumber);
            $('.card-icons').addClass(cardType);
            $('.txt_card_type').val(cardType);
        
        });
    
    });";

$this->registerJs($js, View::POS_END);