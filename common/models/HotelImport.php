<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
use common\models\Hotel;



class HotelImport extends \yii\db\ActiveRecord
{
    public $hotelCsv;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['hotelCsv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'], 
        ];
    }
    
    public function import(){
        if (!isset($_FILES['HotelImport'])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File can't be empty."));
            return false;
        }
        set_time_limit(0);
        if (!isset($_FILES['HotelImport']["tmp_name"]["hotelCsv"]) || empty($_FILES['HotelImport']["tmp_name"]["hotelCsv"])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File Not Found."));
        }
        $file = $_FILES['HotelImport'];
        $name = $file["name"]["hotelCsv"];
       // \yii\helpers\VarDumper::dump($file['name']);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "Only CSV files are allowed."));
        } else {
                $file = fopen($file["tmp_name"]["hotelCsv"], "r");
                $allowedHeader = [
                    'name',
                    'tagline',
                    'description',
                    'address1',
                    'address2',
                    'country',
                    'state',
                    'city',
                    'zip_code',
                    'estd',
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

                            $model = new Hotel;
                            
                            //$model->user_id =  Yii::$app->user->id;
                            $model->name = $body[$flipped['name']];
                            $model->tagline = $body[$flipped['tagline']];
                            $model->description = $body[$flipped['description']];
                            $model->address1 = $body[$flipped['address1']];
                            $model->address2 = $body[$flipped['address2']];
                            $model->country = $body[$flipped['country']];
                            $model->state = $body[$flipped['state']];
                            $model->city = $body[$flipped['city']];
                            $model->zip_code = $body[$flipped['zip_code']];
                            $model->estd = $body[$flipped['estd']];
                            $model->status = $body[$flipped['status']] == "active" ? Hotel::STATUS_ACTIVE : Hotel::STATUS_INACTIVE;

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
                        \Yii::$app->session->setFlash('success', \Yii::t('app', "Hotel imported successfully."));
                        $transaction->commit();
                    }
                } catch (HttpException $e) {
                    $transaction->rollBack();
                }
            }
    }
}
