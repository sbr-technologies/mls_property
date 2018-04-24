<?php 
use yii\helpers\Url;
$this->title = 'Plans';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Subscription</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li><a href="my-plan.html">My Plan</a></li>
            <li class="active">Subscription</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas dolor elit, ullamcorper et metus in, sodales hendrerit risus. In et iaculis ante, et faucibus eros. Proin in lobortis metus. Vestibulum at ligula ante. Donec mollis nunc vitae leo fringilla finibus. Maecenas vitae erat id est pellentesque tristique at at felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris laoreet porta nisl vel varius. Nam id leo non augue ornare mollis at ut odio. Etiam auctor sollicitudin aliquam. Aliquam erat volutpat. Quisque feugiat purus eget augue vestibulum malesuada. Phasellus ultrices in nisi sit amet consectetur.</p>
            <div class="subscription-chart-sec">
                <!-- Pricing -->
                <?php foreach ($plans as $key => $plan) { 
                    if($key == 0){
                        $panel = "panel panel-danger";
                    }elseif($key == 1){
                        $panel = "panel panel-default";
                    }elseif($key == 2){
                        $panel = "panel panel-warning";
                    }else{
                        $panel = "panel panel-info";
                    }
                ?>
                    <div class="col-sm-4">
                        <div class="<?= $panel ?>">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $plan->title ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="the-price">
                                    <h1> <?= Yii::$app->formatter->asCurrency($plan->amount) ?><span class="subscript">/mo</span></h1>
                                    <table class="table">
                                            <tr>
                                                <td><?= nl2br($plan->description) ?></td>
                                            </tr>
                                    </table>
                                </div>
                                <div class="panel-footer"> <a href="<?= Url::to(['subscription/plan-details', 'id' => $plan->id]) ?>" class="btn btn-danger" role="button">Subscribe</a></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <!--//End Pricing -->
                </div>
            </div>
    </section>
    <!-- Main content -->
</div>