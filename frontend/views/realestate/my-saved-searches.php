<?php 
use yii\helpers\Url;
$this->title = 'My Saved Searches';
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
            <h3 class="box-title">My Saved Searches</h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered text-center">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Saved at</th>
                  <th>Action</th>
                </tr>
                <?php if(!empty($searches)){$i=1; foreach ($searches as $item){?>
                <tr>
                  <td><?= $i++?></td>
                  <td><?=$item->name?></td>
                  <td><?=$item->type?></td>
                  <td><?= Yii::$app->formatter->asDatetime($item->created_at)?></td>
                  <td>
                      <a href="<?php echo Url::to(['realestate/config-saved-search', 'id' => $item->id]);?>" title="Edit"><i class="fa fa-pencil"></i></a>
                      <a href="<?= $item->searchUrl. '&source='. $item->id?>" target="_blank" title="Search"><i class="fa fa-search"></i></a>
                      <a href="<?php echo Url::to(['realestate/delete-saved-search', 'id' => $item->id]);?>" title="Delete" onclick="return confirm('Are you sure want to delete?')"><i class="fa fa-times"></i></a>
                  </td>
                </tr>
                <?php }}else{ ?>
                <tr><td colspan="4">No Records Found</td></tr>
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