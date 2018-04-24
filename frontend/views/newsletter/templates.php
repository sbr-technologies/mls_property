<?php 
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title = 'Drip Marketing Mail Templates';
$models = $dataProvider->getModels();
?>
<div class="content-wrapper">
  <!-- Content Title Sec -->
  <section class="content-header">
    <h1> <?= $this->title?> </h1>
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
        <div class="box box-primary box-solid table-listing">
          <div class="box-header with-border">
            <h3 class="box-title">Send Drip Mail</h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered text-center">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Title</th>
                  <th>Subject</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
                <?php $i=0; foreach ($models as $model){?>
                <tr>
                  <td><?= ++$i?></td>
                  <td><?= $model->title?></td>
                  <td><?= $model->subject?></td>
                  <td><?= $model->createdAt?></td>
                  <td>
                      <a href="<?= Url::to(['newsletter/update', 'id' => $model->id])?>" class="btn btn-primary btn-sm" title="Update"><i class="fa fa-edit" aria-hidden="true"></i></a>
                      <a href="<?= Url::to(['newsletter/view', 'id' => $model->id])?>" class="btn btn-primary btn-sm" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <a href="<?= Url::to(['newsletter/recipients', 'template_id' => $model->id])?>" class="btn btn-success btn-sm" title="Send Mail"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a>
                      <a href="<?= Url::to(['newsletter/schedule-recipients', 'template_id' => $model->id])?>" class="btn btn-success btn-sm" title="Schedule Mail"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <div class="box-footer clearfix">
<!--            <ul class="pagination no-margin pull-right">
              <li><a href="javascript:void(0)">«</a></li>
              <li class="active"><a href="javascript:void(0)">1</a></li>
              <li><a href="javascript:void(0)">2</a></li>
              <li><a href="javascript:void(0)">3</a></li>
              <li><a href="javascript:void(0)">»</a></li>
            </ul>-->
            <?php 
            echo LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
            ]);
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main content -->
</div>