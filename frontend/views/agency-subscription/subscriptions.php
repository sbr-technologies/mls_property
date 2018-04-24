<?php 
$this->title = 'Subscriptions';
?>
<div class="content-wrapper">
  <!-- Content Title Sec -->
  <section class="content-header">
    <h1><?= $this->title?></h1>
    <ol class="breadcrumb">
      <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="active"><?= $this->title?></li>
    </ol>
  </section>
  <!-- Content Title Sec -->

  <!-- Main content -->
  <section class="content">
    <div class="content-inner-sec">
      <div class="col-sm-12">
        <div class="box box-default box-solid table-listing">
          <div class="box-header with-border">
            <h3 class="box-title"><?= $this->title?></h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered text-center">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Service Cat</th>
                  <th>Plan</th>
                  <th>Price</th>
                  <th>Start Date</th>
                  <th>Expiry Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php if(!empty($subscriptions)){ foreach ($subscriptions as $subs){?>
                <tr>
                <td>1</td>
                <td><?=$subs->plan->serviceCategory->name?></td>
                <td><?=$subs->plan->title?></td>
                <td><?= Yii::$app->formatter->asCurrency($subs->paid_amount)?> For <?= $subs->duration?> Month<?= $subs->duration > 1?'s':''?></td>
                <td><?= Yii::$app->formatter->asDate($subs->subs_start)?></td>
                <td><?= Yii::$app->formatter->asDate($subs->subs_end)?></td>
                <td class="text-capitalize"><?=$subs->status?></td>
                <td class="text-capitalize"><?php if($subs->status == 'active'){?>
                    <a href="<?= \yii\helpers\Url::to(['agency-subscription/terminate', 'id' => $subs->id])?>" onclick="return confirm('Are you sure want to terminate your current subscription?');">Terminate</a>
                <?php }?>
                </td>
                <?php }}else{ ?>
                <tr><td colspan="5">You are not subscribed any plan</td></tr>
               <?php }?>
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