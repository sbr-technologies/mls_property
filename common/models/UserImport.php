<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
use common\models\User;
use common\models\Profile;



class UserImport extends \yii\db\ActiveRecord
{
    public $userCsv;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['userCsv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'], 
        ];
    }
    
    public function import(){
        if (!isset($_FILES['UserImport'])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File can't be empty."));
            return false;
        }
        set_time_limit(0);
        if (!isset($_FILES['UserImport']["tmp_name"]["userCsv"]) || empty($_FILES['UserImport']["tmp_name"]["userCsv"])) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', "CSV File Not Found."));
        } else {
            $file = $_FILES['UserImport'];
            $name = $file["name"]["userCsv"];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            if ($extension != 'csv') {
                \Yii::$app->session->setFlash('error', \Yii::t('app', "Only CSV files are allowed."));
                return false;
            }
            $file = fopen($file["tmp_name"]["userCsv"], "r");
            $allowedHeader = [
                'profile_type',
                'salutation',
                'first_name',
                'middle_name',
                'last_name',
                'username',
                'short_name',
                'password',
                'email',
                'mobile1',
                'calling_code',
                'gender',
                'dob',
                'tagline',
                'address1',
                'address2',
                'city',	
                'state',	
                'country',	
                'zip_code',	
                'status'
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
                        //\yii\helpers\VarDumper::dump($diff,43,1); exit;
                        if (!empty($diff)) {
                            $errors = "Invalid CSV File uploaded. Please download the sample file for correct format.";
                            break;
                        }
                        $flipped = array_flip($header);
                    } else {
                        $body = fgetcsv($file);
                        if (empty($body)) {
                            break;
                        }
                        //\yii\helpers\VarDumper::dump($body,43,1); exit;
                        $model = User::find()->where(['email' => $body[$flipped['email']]])->one();
                        $existing = true;
                        if (empty($model)) {
                            $model = new User;
                            $existing = false;
                        }
                        if (!$existing) {
                            $profileObj = Profile::find()->where(['title' => $body[$flipped['profile_type']]])->one();
                            if (!empty($profileObj)) {
                                $model->profile_id = $profileObj->id;
                            } else {
                                $errors .= "Invalid Profile Type at Row #" . $row . "<br/>";
                                continue;
                            }
                        }



                        $model->email = $body[$flipped['email']];
                        $model->salutation = $body[$flipped['salutation']];
                        $model->first_name = $body[$flipped['first_name']];
                        $model->short_name = strtoupper($body[$flipped['short_name']]);
                        $model->middle_name = $body[$flipped['middle_name']];
                        $model->last_name = $body[$flipped['last_name']];
                        $model->username = $body[$flipped['username']];
                        $model->mobile1 = $body[$flipped['mobile1']];
                        $model->calling_code = $body[$flipped['calling_code']];
                        $model->zip_code = $body[$flipped['zip_code']];
                        $model->address1 = $body[$flipped['address1']];
                        $model->address2 = $body[$flipped['address2']];
                        $model->dob = $body[$flipped['dob']];
                        $model->tagline = $body[$flipped['tagline']];
                        $model->mobile1 = $body[$flipped['mobile1']];
                        $model->city = $body[$flipped['city']];
                        $model->state = $body[$flipped['state']];
                        $model->country = $body[$flipped['country']];
                        $model->status = $body[$flipped['status']] == "active" ? User::STATUS_ACTIVE : User::STATUS_PENDING_APPROVAL;
                        if ($existing) {
                            if (!empty($body[$flipped['password']])) {
                                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($body[$flipped['password']]);
                            }
                        } else {
                            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($body[$flipped['password']]);
                        }

                        $model->gender = $body[$flipped['gender']] == "male" ? User::GENDER_MALE : ($body[$flipped['gender']] == "female" ? User::GENDER_FEMALE : "");
                        if (empty($model->gender)) {
                            $errors .= "Invalid Gender at Row #" . $row . ". Can be M, or F.<br/>";
                            continue;
                        }

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
                if (!empty($errors)) {
                    \Yii::$app->session->setFlash('error', \Yii::t('app', $errors));
                    $transaction->rollBack();
                } else {
                    \Yii::$app->session->setFlash('success', \Yii::t('app', "Users imported successfully."));
                    $transaction->commit();
                }
            } catch (HttpException $e) {
                $transaction->rollBack();
            }
        }
    }

   
    
    
    
    

}
