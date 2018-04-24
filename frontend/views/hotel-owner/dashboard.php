<?php
use yii\helpers\Html;
use yii\web\View;
use common\models\Hotel;
use common\models\Testimonial;
use common\models\PropertyShowingRequest;
use common\models\HolidayPackage;
$this->title = 'Dashboard';

$userId = Yii::$app->user->id;
$hotelCnt    = Hotel::find()->where(['user_id' => $userId])->count();
$testimonialCnt    = Testimonial::find()->where(['user_id' => $userId])->count(); 
$testimonialArr    = Testimonial::find()->where(['user_id' => $userId,'model' => 'Hotel'])->all();
$hotelArr    =   Hotel::find()->where(['user_id' => $userId])->orderBy(['id' => SORT_DESC])->limit(5)->all();
$packageCnt    = HolidayPackage::find()->where(['user_id' => $userId])->count(); 

?>
<!-- Start right Section ==================================================-->
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Hotel Owner Dashboard <small>Statistics and more</small> </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="content-inner-sec">
            <div class="dashboard-buyer-top-sec">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="dashboard-top-box first-box">
                            <div class="priceTxt"><?= $hotelCnt ?></div>
                            <div class="price-bottomTxt">Total Hotel</div>
                            <div class="icon">
                                <i class="fa fa-pie-chart" aria-hidden="true"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
<!--                            <div class="progress-description">
                                <span class="pull-left">Progress</span>
                                <span class="pull-right">76%</span>
                            </div>-->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="dashboard-top-box second-box">
                            <div class="priceTxt"><?= $testimonialCnt ?></div>
                            <div class="price-bottomTxt">Total Review</div>
                            <div class="icon">
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
<!--                            <div class="progress-description">
                                <span class="pull-left">Progress</span>
                                <span class="pull-right">85%</span>
                            </div>-->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="dashboard-top-box three-box">
                            <div class="priceTxt"><?= $packageCnt  ?></div>
                            <div class="price-bottomTxt">Total Package</div>
                            <div class="icon">
                                <i class="fa fa-rocket" aria-hidden="true"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
<!--                            <div class="progress-description">
                                <span class="pull-left">Progress</span>
                                <span class="pull-right">76%</span>
                            </div>-->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="dashboard-top-box four-box">
                            <div class="priceTxt">0</div>
                            <div class="price-bottomTxt">Total Transaction</div>
                            <div class="icon">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
<!--                            <div class="progress-description">
                                <span class="pull-left">Progress</span>
                                <span class="pull-right">76%</span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-member-lead-sec">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dashboard-box">
<!--                            <ul class="member-right-icons pull-right">
                                <li><a href="javascript:void(0)"><i class="fa fa-cog" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-info-circle" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>
                            </ul>-->
                            <h2>Top 5 Hotel List</h2>

                            <div class="table-responsive">
                                <?php 
                                if(!empty($hotelArr)){
                                ?>
                                <table class="table dashboard-table-list">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $slCnt = 1;
                                        foreach($hotelArr as $hotel){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $slCnt ?>
                                                </td>
                                                <td><?= $hotel->name ?></td>
                                                <td><?= $hotel->status ?></td>
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
                            <h2>Recent Testimonials</h2>

                            <div class="table-responsive">
                                <?php 
                                if(!empty($testimonialArr)){
                                ?>
                                <table class="table dashboard-table-list lead-table-list">
                                    <thead>
                                    <th>sl.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Rating</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $slCnt = 1;
                                        foreach($testimonialArr as $testimonial){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $slCnt ?>
                                                </td>
                                                <td><?= $testimonial->title ?></td>
                                                <td><?= $testimonial->description ?></td>
                                                <td><?= $testimonial->rating ?></td>
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