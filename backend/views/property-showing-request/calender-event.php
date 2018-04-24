<?php

use yii\helpers\Html;
use yii\web\View;


$this->registerCssFile(
    '@web/calender/fullcalendar.css',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/plugins/bootstrap-datepicker/js/moment/moment.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);		
$this->registerJsFile(
    '@web/calender/fullcalendar2.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->title                = "Calender Event";
$finalRequestArr            =   [];
$requests                   =   $dataProvider->getModels();
if(!empty($requests)){
    foreach($requests as  $request){
        $finalRequestArr[]  =   ['id' => $request->id, 'title' => $request->note,'start' => date("Y-m-d",$request->schedule),'url' => 'index.php?r=property-showing-request%2Fview&id='.$request->id];
    }
}
//http://localhost/mls_property/backend/web/index.php?r=property-showing-request%2Fview&id=18
//mls_property/backend/web/index.php?r=property-showing-request%2Fview&id=18
$requestJson = json_encode($finalRequestArr);
//echo "<pre>"; print_r($finalRequestArr); echo "<pre>"; exit;
//\yii\helpers\VarDumper::dump($finalRequestArr,4,12); exit;
?>

<div class="hotel-create" style="background: #fff;">
    <div id="calendar"></div>
</div>
<?php 
$js =   "$(document).ready(function () {
            var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                timezone:'America/Chicago',
                defaultDate:'2017-05-01',
                selectable: true,
                selectHelper: true,
                editable: true,
                droppable: false, // this allows things to be dropped onto the calendar !!!
                dayClick: function (date, jsEvent, view) {
                    calenderPopup(date);
                },
                eventClick: function (calEvent, jsEvent, view) { 
                    var title = '';
                    var start = '';
                    if (calEvent.start) {
                        start = calEvent.start.format('MM/DD/YYYY');
                        if (calEvent.start.hasTime()) {
                            start_time = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
                        }
                    }
                },
                events: ".$requestJson.",
            });
        });";

$this->registerJs($js, View::POS_END);
?>



