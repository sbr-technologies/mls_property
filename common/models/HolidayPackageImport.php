<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
use common\models\HolidayPackage;
use common\models\HolidayPackageCategory;



class HolidayPackageImport extends \yii\db\ActiveRecord
{
    public $holidayPackageCsv;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['holidayPackageCsv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'], 
        ];
    }
    
    public function import(){
        if (!isset($_FILES['HolidayPackageImport'])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File can't be empty."));
            return false;
        }
        set_time_limit(0);
        if (!isset($_FILES['HolidayPackageImport']["tmp_name"]["holidayPackageCsv"]) || empty($_FILES['HolidayPackageImport']["tmp_name"]["holidayPackageCsv"])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File Not Found."));
        }
        $file = $_FILES['HolidayPackageImport'];
        $name = $file["name"]["holidayPackageCsv"];
       // \yii\helpers\VarDumper::dump($file['name']);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "Only CSV files are allowed."));
        } else {
                $file = fopen($file["tmp_name"]["holidayPackageCsv"], "r");
                $allowedHeader = [
                    'holiday_package_category',
                    'name',
                    'description',
                    'package_amount',
                    'no_of_days',
                    'no_of_nights',
                    'hotel_transport_info',
                    'departure_date',
                    'inclusion',
                    'exclusions',
                    'payment_policy',
                    'cancellation_policy',
                    'status',
                ];
                $header = [];
                $row = 0;
                $flipped = [];
                $errors = "";
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {
                    while (!feof($file)) {
                        if ($row == 0) {
                            $header = fgetcsv($file);
                            $diff = array_diff($allowedHeader, $header);
                            //\yii\helpers\VarDumper::dump($diff);exit;
                            if (!empty($diff)) {
                                $errors = "Invalid CSV File uploaded. Please download the sample file for correct format.";
                                break;
                            }
                            $flipped = array_flip($header);
                        } else {
                            $body = fgetcsv($file);
//                                \yii\helpers\VarDumper::dump($body); exit;
                            if (empty($body)) {
                                break;
                            }

                            $model = new HolidayPackage;
                            
                            $packageCategoryObj  = HolidayPackageCategory::find()->where(['title'=> $body[$flipped['holiday_package_category']]])->one();
                            if (!empty($packageCategoryObj)) {
                                $model->category_id = $packageCategoryObj->id;
                            } else {
                                $errors .= "Invalid Hloiday Package Category at Row #" . $row . "<br/>";
                                continue;
                            }
                            

                         //$model->user_id =  Yii::$app->user->id;
                            $model->name = $body[$flipped['name']];
                            $model->description = $body[$flipped['description']];
                            $model->package_amount = $body[$flipped['package_amount']];
                            $model->no_of_days = $body[$flipped['no_of_days']];
                            $model->no_of_nights = $body[$flipped['no_of_nights']];
                            $model->hotel_transport_info = $body[$flipped['hotel_transport_info']];
                            $model->departure_date = strtotime($body[$flipped['departure_date']]);
                            $model->inclusion = $body[$flipped['inclusion']];
                            $model->exclusions = $body[$flipped['exclusions']];
                            $model->payment_policy = $body[$flipped['payment_policy']];
                            $model->cancellation_policy = $body[$flipped['cancellation_policy']];
                            $model->status = $body[$flipped['status']] == "active" ? HolidayPackage::STATUS_ACTIVE : HolidayPackage::STATUS_INACTIVE;

                           // \yii\helpers\VarDumper::dump($model); exit;



                            $model->save(false);
                            $mErrors = $model->getErrors();

                            if (!empty($mErrors)) {
                                foreach ($mErrors as $val) {
                                    foreach ($val as $k => $v) {
                                        $val[$k] = $v . " at Row #" . $row . "<br/>";
                                    }

                                    $mErrors = implode("<br/>", $val);
                                }

                                $errors .= $mErrors;
                            }
                        }
                        $row++;
                    }
                    //\yii\helpers\VarDumper::dump($row); //exit;
                    if (!empty($errors)) {
                        \Yii::$app->session->setFlash('error', \Yii::t('app', $errors));
                        $transaction->rollBack();
                    } else {
                        \Yii::$app->session->setFlash('success', \Yii::t('app', "Holiday Package imported successfully."));
                        $transaction->commit();
                    }
                } catch (HttpException $e) {
                    $transaction->rollBack();
                }
            }
    }
}
