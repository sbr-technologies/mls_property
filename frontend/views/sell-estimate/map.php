<?php 
use yii\web\View;
?>
    <div class="container">
        <div class="col-sm-12">
            <div class="sell_estimate_thumbnails">
            <div class="row property-listing-top-title">
                <div class="col-sm-6 breadcrumb-list">
                    
                        <ul>
                            <?php
                            foreach ($breadcrumb as $item) {
                                if (is_array($item)) {
                                    echo '<li><a href="#">' . implode('|', $item) . '</a></li>';
                                } else {
                                    echo '<li><a href="#">' . $item . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    
                </div>
                <div class="col-sm-6 text-right">
                    <?php if (1) { ?>
                        <div class="form-group clearfix">
                            <a href="javascript:void(0)" data-type="summary" class="btn btn-default sell_estimate_view" title="Summary"><i class="fa fa-th-large"></i></a>
                            <a href="javascript:void(0)" data-type="list" class="btn btn-default  sell_estimate_view" title="List"><i class="fa fa-list"></i></a>
                            <a href="javascript:void(0)" data-type="thumbnails" class="btn btn-default sell_estimate_view" title="Thumbnails"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0)" data-type="map" class="btn btn-default active sell_estimate_view" title="Map"><i class="fa fa-map"></i></a>
                            <a href="javascript:void(0)" data-type="chart" class="btn btn-default sell_estimate_view" title="Chart"><i class="fa fa-bar-chart"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <h3>Map View</h3>
            <div id="realestate_map_view_container" style="min-height: 450px;">
                
            </div>
        </div>
    </div>
</div>
<?php
$resJs = "var propData=". json_encode($items). ";";
$this->registerJs($resJs, View::POS_HEAD);

$js = "$(function(){
            initialize(propData);
       });";

$this->registerJs($js, View::POS_END);