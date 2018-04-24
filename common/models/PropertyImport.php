<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
use common\models\Property;
use common\models\MetricType;
use common\models\PropertyCategory;
use common\models\PropertyType;
use common\models\ConstructionStatusMaster;



class PropertyImport extends \yii\db\ActiveRecord
{
    public $propertyCsv;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['propertyCsv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'], 
        ];
    }
    
    public function import(){
        if (!isset($_FILES['PropertyImport'])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File can't be empty."));
            return false;
        }
        set_time_limit(0);
        if (!isset($_FILES['PropertyImport']["tmp_name"]["propertyCsv"]) || empty($_FILES['PropertyImport']["tmp_name"]["propertyCsv"])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File Not Found."));
        }
        $file = $_FILES['PropertyImport'];
        $name = $file["name"]["propertyCsv"];
       // \yii\helpers\VarDumper::dump($file['name']);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "Only CSV files are allowed."));
        } else {
                $file = fopen($file["tmp_name"]["propertyCsv"], "r");
                $allowedHeader = [
                    'title',	
                    'description',	
                    'country',	
                    'state',	
                    'city',	
                    'address1',	
                    'address2',	
                    'lat',	
                    'lng',	
                    'zip_code',	
                    'near_buy_location',	
                    'metric_type',	
                    'size',	
                    'no_of_room',
                    'no_of_balcony',	
                    'no_of_bathroom',	
                    'lift',	
                    'furnished',
                    'water_availability',
                    'status_of_electricity',	
                    'currency',	
                    'currency_symbol',	
                    'price',	
                    'water_mark_image',	
                    'property_video_link',	
                    'property_type',	
                    'property_category',	
                    'construction_status',	
                    'status',
                ];
                $header = [];
                $row = 0;
                $flipped = [];
                $errors = "";
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                //try {
                    while (!feof($file)) {
                        if ($row == 0) {
                            $header = fgetcsv($file);
                            $diff = array_diff($allowedHeader, $header);
                               // \yii\helpers\VarDumper::dump($diff);exit;
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

                            $model = new Property;
                            
                            $metricTypeObj  = MetricType::find()->where(['name'=> $body[$flipped['metric_type']]])->one();
                            if (!empty($metricTypeObj)) {
                                $model->metric_type_id = $metricTypeObj->id;
                            } else {
                                $errors .= "Invalid Metric Type at Row #" . $row . "<br/>";
                                continue;
                            }

                            //Used for Define Property Category
                            $propertyCategoryObj  = PropertyCategory::find()->where(['title'=> $body[$flipped['property_category']]])->one();
                            if (!empty($propertyCategoryObj)) {
                                $model->property_category_id = $propertyCategoryObj->id;
                            } else {
                                $errors .= "Invalid Property Category at Row #" . $row . "<br/>";
                                continue;
                            }

                            //Used for Define Property Type
                            $propertyTypeObj  = PropertyType::find()->where(['title'=> $body[$flipped['property_type']], 'property_category_id' => $propertyCategoryObj->id])->one();
                            if (!empty($propertyTypeObj)) {
                                $model->property_type_id = $propertyTypeObj->id;
                            } else {
                                $errors .= "Invalid Property Type at Row #" . $row . "<br/>";
                                continue;
                            }

                            //Used for Define Property Type
                            $constructionStatusObj  = ConstructionStatusMaster::find()->where(['title'=> $body[$flipped['construction_status']]])->one();
                            if (!empty($propertyTypeObj)) {
                                $model->construction_status_id = $propertyTypeObj->id;
                            } else {
                                $errors .= "Invalid Construction Status at Row #" . $row . "<br/>";
                                continue;
                            }
                            
                            $model->user_id =  Yii::$app->user->id;
                            $model->title = $body[$flipped['title']];
                            $model->description = $body[$flipped['description']];
                            $model->country = $body[$flipped['country']];
                            $model->state = $body[$flipped['state']];
                            $model->city = $body[$flipped['city']];
                            $model->address1 = $body[$flipped['address1']];
                            $model->address2 = $body[$flipped['address2']];
                            $model->lat = $body[$flipped['lat']];
                            $model->lng = $body[$flipped['lng']];
                            $model->zip_code = $body[$flipped['zip_code']];
                            $model->near_buy_location = $body[$flipped['near_buy_location']];
                            $model->address2 = $body[$flipped['address2']];
                            $model->size = $body[$flipped['size']];
                            $model->no_of_room = $body[$flipped['no_of_room']];
                            $model->no_of_balcony = $body[$flipped['no_of_balcony']];
                            $model->no_of_bathroom = $body[$flipped['no_of_bathroom']];
                            $model->lift = $body[$flipped['lift']];
                            $model->furnished = $body[$flipped['furnished']];
                            $model->water_availability = $body[$flipped['water_availability']];
                            $model->status_of_electricity = $body[$flipped['status_of_electricity']];
                            $model->currency = $body[$flipped['currency']];
                            $model->currency_symbol = $body[$flipped['currency_symbol']];
                            $model->price = $body[$flipped['price']];
                            $model->water_mark_image = $body[$flipped['water_mark_image']];
                            $model->property_video_link = $body[$flipped['property_video_link']];
                            $model->status = $body[$flipped['status']] == "active" ? Property::STATUS_ACTIVE : Property::STATUS_INACTIVE;

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
                        \Yii::$app->session->setFlash('success', \Yii::t('app', "Property imported successfully."));
                        $transaction->commit();
                    }
                /*} catch (HttpException $e) {
                    $transaction->rollBack();
                }*/
            }
    }
}
