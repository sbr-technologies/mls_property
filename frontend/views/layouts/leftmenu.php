<?php
use yii\helpers\Url;
use common\models\User;
use frontend\helpers\AuthHelper;
$user = Yii::$app->user->identity;

if(AuthHelper::is('buyer')){
    $aboutUrl   =   'about';
}else if(AuthHelper::is('agent')){
    $aboutUrl   =   'agent/about';
}else if(AuthHelper::is('seller')){
    $aboutUrl   =   'about';
}else if(AuthHelper::is('hotel')){
    $aboutUrl   =   'hotel/about';
}else if(AuthHelper::is('agency')){
    $profileUrl   =   'agency/profile';
}
?>
<!-- Start Left Section ==================================================-->
<aside class="main-sidebar"> 
    <!-- sidebar -->
    <section class="sidebar"> 
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="image">
                <img src="<?php echo $user->getImageUrl(User::THUMBNAIL)?>" class="img-circle" alt="User Image">
                <div class="user-on-of">
                    <i class="fa fa-circle text-success"></i>
                </div>
            </div>
            <div class="info">
                <p>
                    <?= $user->fullName?>
                    <span><?= $user->profile->title ?></span> 
                </p>
            </div>
        </div>
        <!-- Sidebar user panel -->

        <!-- sidebar menu -->
        <ul class="sidebar-menu">
            <li><a href="<?= $user->dashboardUrl ?>"><i class="fa fa-home" aria-hidden="true"></i> <span>Dashboard</span></a></li>
            <?php if(!AuthHelper::is('buyer') && !AuthHelper::is('hotel')){?>
            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-cogs" aria-hidden="true"></i> <span>My Listing</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?= Url::to(['/property/sell']) ?>"><i class="fa fa-circle-o"></i> Sale List</a></li>
                    <li><a href="<?= Url::to(['/property/rent']) ?>"><i class="fa fa-circle-o"></i> Rent List</a></li>
                    <li><a href="<?= Url::to(['/property/short-let']) ?>"><i class="fa fa-circle-o"></i> Short Let List</a></li>
                    <li><a href="<?= Url::to(['/property/index']) ?>"><i class="fa fa-circle-o"></i> All List</a></li>
                    <li><a href="<?= Url::to(['property/create']) ?>"><i class="fa fa-circle-o"></i> Add New Property</a></li>
                    <li><a href="<?= Url::to(['condominium/create']) ?>"><i class="fa fa-circle-o"></i> Add new Devlmpt, Condo, Flat</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php if(!AuthHelper::is('hotel')){?>
            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Property Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    
                    <li class=""><a href="<?php echo Url::to(['realestate/my-saved-searches']) ?>"><i class="fa fa-circle-o" aria-hidden="true"></i> <span>My Saved Search</span></a></li>
                    <li><a href="<?= Url::to(['property/favourite-property']);?>"><i class="fa fa-circle-o"></i> Favorite Property</a></li>
                    <li><a href="<?= Url::to(['/property-enquiery']) ?>"><i class="fa fa-circle-o"></i> Tell Me About Property</a></li>
                    <li><a href="<?= Url::to(['/property-showing-request']);?>"><i class="fa fa-circle-o"></i> Showing Request</a></li>
                    <li><a href="<?= Url::to(['property/requested-property']);?>"><i class="fa fa-circle-o"></i>Request for Property</a></li>
                </ul>
            </li>
            <?php } ?>
            <li class=""><a href="<?= Url::to(['/property-showing-request/calender-event']) ?>"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Calender Event</span></a></li>
            
           <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Internal Messages</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::to(['message/compose']); ?>"><i class="fa fa-circle-o"></i>Compose</a></li>
                <li><a href="<?= Url::to(['message/inbox']); ?>"><i class="fa fa-circle-o"></i>Inbox</a></li>
                <li><a href="<?= Url::to(['message/sent']); ?>"><i class="fa fa-circle-o"></i>Sent</a></li>
              </ul>
            </li>
            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Email</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::to(['email/compose']); ?>"><i class="fa fa-circle-o"></i>Compose</a></li>
                <li><a href="<?= Url::to(['email/sent-mails']); ?>"><i class="fa fa-circle-o"></i>Sent Mails</a></li>
              </ul>
            </li>
            <?php
            if(AuthHelper::is('agency')){
            ?>
            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Agent Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::to(['agency/agents']); ?>"><i class="fa fa-circle-o"></i>Agents</a></li>
              </ul>
            </li>
            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Team Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::to(['team/index']); ?>"><i class="fa fa-circle-o"></i>Teams</a></li>
                <li><a href="<?= Url::to(['team/create']); ?>"><i class="fa fa-circle-o"></i>Add Team</a></li>
              </ul>
            </li>
            <?php
            }
            if(!AuthHelper::is('buyer')){?>
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-h-square" aria-hidden="true"></i> <span>Hotel Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['hotel/list']) ?>"><i class="fa fa-circle-o"></i> List Hotel</a></li>
                        <li><a href="<?= Url::to(['hotel/create']) ?>"><i class="fa fa-circle-o"></i> Add New Hotel</a></li>
                    </ul>
                </li>
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-crosshairs " aria-hidden="true"></i> <span>Holiday Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['holiday-package/list']) ?>"><i class="fa fa-circle-o"></i> List Package</a></li>
                        <li><a href="<?= Url::to(['holiday-package/create']) ?>"><i class="fa fa-circle-o"></i> Add New Package</a></li>
                    </ul>
                </li>
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-file-text" aria-hidden="true"></i> <span>Subscriptions</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                      <li><a href="<?= Url::to(['subscription/my-subscriptions'])?>"><i class="fa fa-circle-o"></i> My Subscriptions</a></li>
                        <li><a href="<?= Url::to(['subscription/plans', 'service_id' => 1])?>"><i class="fa fa-circle-o"></i> Property Plans</a></li>
                        <li><a href="<?= Url::to(['subscription/plans', 'service_id' => 2])?>"><i class="fa fa-circle-o"></i> Hotel</a></li>
                        <li><a href="<?= Url::to(['subscription/plans', 'service_id' => 3])?>"><i class="fa fa-circle-o"></i> Holiday Plans</a></li>
                        <li><a href="<?= Url::to(['subscription/plans', 'service_id' => 4])?>"><i class="fa fa-circle-o"></i> Ad. Plans</a></li>
                    </ul>
                </li>
                <?php if(AuthHelper::is('agency')){ ?>
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-file-text" aria-hidden="true"></i> <span>Office Subscriptions</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                      <li><a href="<?= Url::to(['agency-subscription/subscriptions'])?>"><i class="fa fa-circle-o"></i> Subscriptions</a></li>
                        <li><a href="<?= Url::to(['agency-subscription/plans', 'service_id' => 1])?>"><i class="fa fa-circle-o"></i> Property Plans</a></li>
                        <li><a href="<?= Url::to(['agency-subscription/plans', 'service_id' => 2])?>"><i class="fa fa-circle-o"></i> Hotel</a></li>
                        <li><a href="<?= Url::to(['agency-subscription/plans', 'service_id' => 3])?>"><i class="fa fa-circle-o"></i> Holiday Plans</a></li>
                        <li><a href="<?= Url::to(['agency-subscription/plans', 'service_id' => 4])?>"><i class="fa fa-circle-o"></i> Ad. Plans</a></li>
                    </ul>
                </li>
                <?php }?>
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-th" aria-hidden="true"></i> <span>Ad Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['/advertisement'])?>"><i class="fa fa-circle-o"></i> Advertisements</a></li>
                        <li><a href="<?= Url::to(['advertisement/create'])?>"><i class="fa fa-circle-o"></i> Add New Advertisement</a></li>
                    </ul>
                </li>

                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Feedback & Review</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['/feedback/property'])?>"><i class="fa fa-circle-o"></i> Property Feedback</a></li>
                        <li><a href="<?= Url::to(['/feedback/hotel'])?>"><i class="fa fa-circle-o"></i> Hotel Feedback</a></li>
                        <li><a href="<?= Url::to(['/feedback/holiday'])?>"><i class="fa fa-circle-o"></i> Holiday Feedback</a></li>
                    </ul>
                </li>
                
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> Drip Marketing Mails</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['newsletter/templates']);?>"><i class="fa fa-circle-o"></i> Email templates</a></li>
                        <li><a href="<?= Url::to(['newsletter/create']);?>"><i class="fa fa-circle-o"></i>Create Template</a></li>
                        <li><a href="<?= Url::to(['newsletter/scheduled-mails']);?>"><i class="fa fa-circle-o"></i>Scheduled Mails</a></li>
                        <li><a href="<?= Url::to(['newsletter/sent-mails']);?>"><i class="fa fa-circle-o"></i>Sent Drip Mails</a></li>
                    </ul>
                </li>
            
                <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Transactions</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['transaction/index']);?>"><i class="fa fa-circle-o"></i> Transaction List</a></li>
                    </ul>
                </li>
            <?php } ?>

            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-users" aria-hidden="true"></i> <span>Contacts</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?= Url::to(['/contacts']) ?>"><i class="fa fa-bars"></i> Contact List</a></li>
                    <li><a href="<?= Url::to(['/contacts/create']) ?>"><i class="fa fa-plus"></i> Add Contact</a></li>
                </ul>
            </li>
             
        </ul>
        <!-- sidebar menu -->
    </section>
</aside>
<!-- End Left Section ==================================================-->