<?php

use yii\helpers\Html;
use common\models\Property;
use yii\helpers\Url;
use frontend\helpers\PropertyHelper;
use yii\web\Session;


$requestReplay = $dataProvider->getModels();
//\yii\helpers\VarDumper::dump($requestReplay,4,12); exit;
?>

<div class="guest-box-sec">
    <?php
    if (!empty($requestReplay)) { ?>
        <h3>Messages</h3>
        <?php
        $sl = 1;
        ?>
        <table class="table table-striped" width="100%">
            <thead>
            <th >Sl.</th>
            <th >Message </th>
            <th >Updated By </th>
            <th >Action </th>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                foreach ($requestReplay as $replay) {
                   // \yii\helpers\VarDumper::dump($replay); exit;
                    ?>
                    <tr>
                        <td ><?= $sl ?></td>
                        <td ><?= $replay->replay ?></td>
                        <td ><?= $replay->user->fullName ?></td>
                        <td>
                            <?php
                            echo Html::button(Yii::t('app', '<i class="fa fa-trash"></i>'), [
                                'class'     => 'btn btn-danger',
                                'onclick'   =>  "deletePropertyEnquiery($replay->id);",

                            ]);
                            ?>
                        </td>
                    </tr>
                    <?php
                    $sl++;
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>