<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile(
    '@web/plugins/owl-carousel/owl.carousel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->registerCssFile(
    '@web/plugins/owl-carousel/owl.carousel.css',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->title = 'Favourite Property';
?>
<div class="content-wrapper">
    <!-- Content Title Sec -->
    <section class="content-header">
        <h1>Favorite Property</h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"><i class="fa fa-home" aria-hidden="true"></i> Property Management</a></li>
            <li class="active">Favorite Property</li>
        </ol>
    </section>
    <!-- Content Title Sec -->

    <!-- Main content -->
    <section class="content">
        <div class="manage-profile-sec">
            <div role="alert" class="alert alert-success alert-dismissible fade in" style="display:none;" id="sucMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="sucmsgdiv"></span>
            </div>
            <div role="alert" class="alert alert-danger alert-dismissible fade in" style="display:none;" id="failMsgDiv">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <span class="failmsgdiv"></span>
            </div>
            <!-- Manage Profile Form -->
            <div class="new-property-form-sec">
                <div class="property-listing-sec listing_item">
                    <?php
                    if (!empty($modelArr)) {
                        $slCnt = 1;
                        foreach ($modelArr as $favorite) {
                            $property = $favorite->property;
                        ?>
                            <div class="property-listing">
                                <div class="col-sm-5 property-listing-left">
                                    <?php
                                    $photos = $property->photos;
                                    ?>
                                    <div class="favourite_property_slide">
                                        <div class="owl-carousel owl-theme">
                                            <?php
                                            foreach ($photos as $photo) {
                                                $alias = $photo->imageUrl;
                                                ?>
                                                <div class="item">
                                                    <?php
                                                    echo Html::img($alias, ['class' => '']);
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>                                    
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-7 property-listing-right">
                                    <div class="pull-left indicator-block">
                                        <?php if($property->market_status == "Active"){?>
                                            <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                                        <?php }elseif($property->market_status == "Sold"){?>
                                            <span class="btn btn-default btn-sm red-new-btn"><?= $property->market_status ?></span>
                                        <?php }elseif($property->market_status == "Pending"){?>
                                            <span class="btn btn-success btn-sm "> <?= $property->market_status ?></span>
                                        <?php } ?>
                                        <span class="btn btn-info btn-sm"><?php echo $property->categoryName?></span>
                                        <?php if($property->isNew){?>
                                            <span class="btn btn-default btn-sm">New</span>
                                        <?php }?>
                                    </div>
                                    <!--<span class="btn btn-default btn-sm green-new-btn">New</span>-->
                                    <div class="property-listing-save-icon">
                                        <!--<a href="javascript:void(0)" class="save_as_favorite" data-href="/mls_property/frontend/web/property/save-favorite?id=117"><i class="fa fa-heart-o" aria-hidden="true"></i></a>-->
                                    </div>
                                    <h2><?php echo Yii::$app->formatter->asCurrency($property->price); ?></h2>
                                    <h4><?= $property->formattedAddress ?></h4>
                                    <a href="javascript:void(0)" class="property-listing-refid">Property ID # <?= $property->referenceId ?></a>
                                    <p><?= $property->firstPropertyType?></p>
<!--                                    <ul class="property-listing-room-details">
                                        <li><strong><i class="fa fa-bed" aria-hidden="true"></i></strong> bd <span><?php echo $property->no_of_room; ?></span></li>
                                        <li><strong><i class="fa fa-bath" aria-hidden="true"></i></strong> ba <span><?php echo $property->no_of_bathroom; ?></span></li>
                                        <li><strong><i class="fa fa-square" aria-hidden="true"></i></strong> Sq ft <span><?php echo $property->lot_size; ?></span></li>
                                    </ul>-->
                                    <ul class="property-listing-room-details">
                                        <li><strong><i class="fa fa-bed" aria-hidden="true"></i></strong> bd <span><?php echo $property->no_of_room; ?></span></li>
                                        <li><strong><i class="fa fa-bath" aria-hidden="true"></i></strong> ba <span><?php echo $property->no_of_bathroom ? $property->no_of_bathroom : "NA"; ?></span></li>
                                        <li><strong><i class="fa fa-trello" aria-hidden="true"></i></strong> tl <span><?php echo $property->no_of_toilet ? $property->no_of_toilet : "NA"; ?></span></li>
                                        <li><strong><i class="fa fa-glide-g" aria-hidden="true"></i></strong> gr <span><?php echo $property->no_of_garage ? $property->no_of_garage : "NA"; ?></span></li>
                                        <li><strong><i class="fa fa-square" aria-hidden="true"></i></strong> Sq ft <span><?php echo $property->lot_size; ?></span></li>
                                    </ul>
                                    <a href="<?= Url::to(['property/view', 'slug' => $property->slug])?>" class="btn btn-primary btn-sm">Read More</a>
                                    <?php echo Html::a(Yii::t('app', 'Delete'), ['/property/delete-favorite', 'id' => $favorite->id], [
                                        'class' => 'btn btn-danger btn-sm',
                                        'id' => $favorite->id,
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]); ?>
                                </div>
                            </div>

                            <?php
                            $slCnt++;
                        }
                    } else {
                        ?>
                        <div class="alert alert-danger margine10top">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> 				
                            No data found.
                        </div>
                    <?php } ?>
                </div>
            </div>
           
            <!-- Manage Profile Form -->
        </div>
    </section>
    <!-- Main content -->
</div>


<?php
$js = "$('.owl-carousel').owlCarousel({
    loop:true,
	items : 1,
    margin:0,
    nav:true,
    autoPlay : true,
	navigation : true,
	navigationText : ['<i class=\"fa fa-chevron-left\"></i>', '<i class=\"fa fa-chevron-right\"></i>'],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})";
$this->registerJs($js, View::POS_END);
?>