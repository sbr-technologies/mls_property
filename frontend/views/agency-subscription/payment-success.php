<?php
$this->title = 'Success subscription: '. $plan->title;
$amount = $plan->amount;
if($subscription->duration == 3){
    $amount = $plan->amount_for_3_months;
}elseif($subscription->duration == 6){
    $amount = $plan->amount_for_6_months;
}elseif($subscription->duration == 12){
    $amount = $plan->amount_for_12_months;
}
?>
<div class="content-wrapper">
  <!-- Content Title Sec -->
  <section class="content-header">
    <h1>Subscription</h1>
    <ol class="breadcrumb">
      <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li><a href="subscription.html">Subscription</a></li>
      <li class="active">Subscription Success</li>
    </ol>
  </section>
  <!-- Content Title Sec -->

  <!-- Main content -->
  <section class="content">
    <div class="content-inner-sec">
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissable">
            <h4> <i class="icon fa fa-check"></i> Thank You</h4>
            You have successfully subscribed to the plan : <?= $plan->title?>
        </div>
        
        <div class="box box-primary box-solid table-listing">
          <div class="box-header with-border">
            <h3 class="box-title">Subscription Details</h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered text-center">
              <tbody>
                <tr>
                  <th>Plan</th>
                  <th>Price</th>
                  <th>Expiry Date</th>
                </tr>
                <tr>
                  <td><?= $plan->title?></td>
                  <td><?= Yii::$app->formatter->asCurrency($amount)?> For <?= $subscription->duration?> Month<?= $subscription->duration > 1?'s':''?></td>
                  <td><?= Yii::$app->formatter->asDate($subscription->subs_end)?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main content -->
</div>