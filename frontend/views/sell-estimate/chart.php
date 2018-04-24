<?php 
use yii\web\View;
use yii\helpers\Url;
use miloschuman\highcharts\HighchartsAsset;
HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting']);
?>
    <div class="container">
        <div class="col-sm-12">
            <div class="sell_estimate_chart">
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
                            <a href="javascript:void(0)" data-type="map" class="btn btn-default sell_estimate_view" title="Map"><i class="fa fa-map"></i></a>
                            <a href="javascript:void(0)" data-type="chart" class="btn btn-default active sell_estimate_view" title="Chart"><i class="fa fa-bar-chart"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <h3>Price Chart</h3>
            <div id="chart_container" style="min-height: 400px;"></div>
        </div>
    </div>
</div>
<?php
$ID = [];
$listPrice = [];
$soldPrice = [];
if(!empty($items)){
foreach ($items as $item){
    array_push($ID, $item['propertyID']);
    array_push($listPrice, $item['price']);
    array_push($soldPrice, $item['sold_price']);
}
$varJs = "var propIDs = ". json_encode($ID). ";var listPrice = ". json_encode($listPrice). ";var soldPrice = ". json_encode($soldPrice). ";";
$this->registerJs($varJs, VIew::POS_HEAD);
}
$js = "Highcharts.chart('chart_container', { 
                        chart: { type: 'column' }, 
                        title: { text: 'Property Listed & Sold Prices' }, 
                        credits: {
                            enabled: false
                        },
                        subtitle: { text: 'Source: NaijaHouses.com' }, 
                        xAxis: { categories: propIDs, crosshair: true }, 
                        yAxis: { min: 0, title: { text: 'Price' } }, 
                        tooltip: { headerFormat: '<span style=\"font-size:10px\"><a href=\"#\">{point.key}</a></span><table>', pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' + '<td style=\"padding:0\"><b>NGN {point.y:.1f}</b></td></tr>', footerFormat: '</table>', shared: true, useHTML: true }, 
                        plotOptions: { column: { pointPadding: 0.1, borderWidth: 0 } }, 
                        series: [{ name: 'List Price', data: listPrice }, 
                                 { name: 'Sold Price', data: soldPrice }] });";



$this->registerJs($js, View::POS_END);