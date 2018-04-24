<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use common\models\UserFavorite;
use common\models\PropertyShowingRequest;


$this->title = 'Dashboard';

$userId = Yii::$app->user->id; 
$modelArr     =   UserFavorite::find()->where(['model' => 'Property','user_id' => $userId])->limit(5)->all();
$showingRequestArr    = PropertyShowingRequest::find()->where(['user_id' => $userId])->limit(5)->all();
?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Buyer Dashboard <small>Statistics and more</small> </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>

<!--        <div class="manage-profile-datepicker">
            <div class="input-group">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input type="text" class="form-control pull-right" id="reservation" value="02/07/2017 - 02/07/2017">
            </div>
        </div>-->
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            
            <div class="dashboard-member-lead-sec">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dashboard-box">
<!--                            <ul class="member-right-icons pull-right">
                                <li><a href="javascript:void(0)"><i class="fa fa-cog" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-info-circle" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>
                            </ul>-->
                            <h2>Favorite Property</h2>
                            <div class="table-responsive">
                                <?php
                                if(!empty($modelArr)){
                                ?>
                                <table class="table text-center dashboard-table-list">
                                    <tbody>
                                        <tr>
                                            <th>id</th>
                                            <th>Property Name</th>
                                        </tr>
                                        <?php
                                        $slCnt =1;
                                        foreach($modelArr as $favorite){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $slCnt ?>
                                                </td>
                                                <td><a href="<?= Url::to(['property/view', 'slug' => $favorite->property->slug])?>" target="_blank"><?= $favorite->property->title ?></a></td>
                                                
                                            </tr>
                                        <?php 
                                        $slCnt++;
                                        } ?>
                                    </tbody>
                                </table>
                                <?php }else{ ?>
                                    <div class="alert alert-info margine10top">
                                        <i class="fa fa-info"></i>					
                                        No data found.
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="dashboard-box">
                            <h2>Property Showing Request</h2>
                            <div class="table-responsive">
                                <?php 
                                
                                if(!empty($showingRequestArr)){
                                ?>
                                <table class="table dashboard-table-list lead-table-list">
                                    <thead>
                                        <tr>
                                            <th> Sl. </th>
                                            <th> Name </th>
                                            <th> Email </th>
                                            <th> Phone </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $slCnt =1;
                                        foreach($showingRequestArr as $request){
                                        ?>
                                        <tr>
                                            <td>
                                               <?= $slCnt ?>
                                            </td>
                                            <td>
                                               <?= $request->name ?>
                                            </td>
                                            <td>
                                               <?= $request->email ?>
                                            </td>
                                            <td>
                                               <?= $request->phone ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        $slCnt++;
                                        } ?>
                                    </tbody>
                                </table>
                                <?php 
                                }else{
                                ?>
                                    <div class="alert alert-info margine10top">
                                        <i class="fa fa-info"></i>					
                                        No data found.
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-bottom-box-sec">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="dashboard-bottom-box">
                            <h3>Send us an email</h3>
                            <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            <h4>Have questions?</h4>
                            <p>Send us an email. We are happy to help.</p>
                            <a href="javascript:void(0)">Send an email</a>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="dashboard-bottom-box">
                            <h3>Call Us</h3>
                            <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            <h4>Give us a call. </h4>
                            <p>We are here to answer your questions.</p>
                            <span class="redTxt">877-309-3151</span>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="dashboard-bottom-box">
                            <h3>Join Us</h3>
                            <div class="icon"><i class="fa fa-comments" aria-hidden="true"></i></div>
                            <p>Share and discuss best practices with other real estate professionals.</p>
                            <a href="javascript:void(0)">Join the conversation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
</div>
<!-- End right Section ==================================================-->