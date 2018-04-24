<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use common\models\HolidayPackage;
use frontend\models\HolidayPackageSearch;
use common\models\MetaTag;
use yii\web\Response;
use yii\helpers\Url;


use common\models\HolidayPackageFeature;
use common\models\HolidayPackageFeatureItem;
use common\models\PhotoGallery;
use common\models\HolidayPackageItinerary;
use common\models\HolidayPackageItinerarySearch;
use common\models\HolidayPackageBooking;
use common\models\HolidayBookingGuest;


use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;

use yii\web\UploadedFile;

/**
 * HolidayPackageController implements the CRUD actions for HolidayPackage model.
 */
class HolidayPackageController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'list', 'details','create', 'update', 'delete','itinerary-list', 'create-itinerary', 'itinerary-view', 'itinerary-update', 'itinerary-list'],
                'rules' => [
                    [
//                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex(){
        
        $this->layout   =   'public_main';
        $model          = new HolidayPackage();
        return $this->render('index',['model' => $model]);
    }
    
    public function actionPackageDetails($id){
        $this->layout   =   'public_main';
        $model          =   $this->findModel($id);
        return $this->render('package-details',['model' => $model]);
    }
    /**
     * Finds the Holiday Package model based on its City value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $city
     * @return Holiday Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPackageList($city = null){
        $this->layout           =   'public_main';
        $keyword                = Yii::$app->request->get('city');
        $searchModel            = new HolidayPackageSearch();
        $searchModel->status    = HolidayPackage::STATUS_ACTIVE;
        $searchModel->keyword   = $keyword;
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('package-list',['city' => $city, 'dataProvider' => $dataProvider]);
    }

    public function actionSearch($type = null){
        $this->layout       =   'public_main';
        $source     = Yii::$app->request->get('source');
        $destination       = Yii::$app->request->get('destination');
        $month_year_travel               = Yii::$app->request->get('month_travel');  
        $searchModel        = new HolidayPackageSearch();
        $searchModel->status = HolidayPackage::STATUS_ACTIVE;
        $sourceArr  = explode('_', $source);
        $destinationArr    = explode('_', $destination);
        $fromLocation = '';
        $toLocation = '';
        
        $month = substr($month_year_travel, 0, 3);
        $year = substr($month_year_travel, 3);
        $searchModel->monthTravel = date('m', strtotime("$month 1 2011"));
        $searchModel->yearTravel = $year;
        if(count($sourceArr) == 2){
            $searchModel->source_city = $sourceArr[0];
            $searchModel->source_state = $sourceArr[1];
            $fromLocation = str_replace('_', ', ', $source);
        }
        if(count($destinationArr) == 2){
            $searchModel->destination_city = $destinationArr[0];
            $searchModel->destination_state = $destinationArr[1];
            $toLocation = str_replace('_', ', ', $destination);
        }
        $dataProvider = $searchModel->search(null);
        return $this->render('search', [
            'locationFromId'    => $source,
            'locationToId'      => $destination,
            'month_year_travel' => $month_year_travel,
            'fromLocation' => $fromLocation,
            'toLocation' => $toLocation,
            'dataProvider'      => $dataProvider
        ]);
    }
    
    public function actionList(){ //echo 11;exit;
        $this->layout           =   'main';
        $searchModel            = new HolidayPackageSearch();
        $searchModel->user_id   = Yii::$app->user->id;
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        
    }
    
    public function actionCreate(){
        $model              = new HolidayPackage(['scenario' =>'create']);
        $metaTagModel       = new MetaTag();
        $packageFeature     =   [new HolidayPackageFeature()];
        $packageFeatureItem =   [new HolidayPackageFeatureItem()];
        //$packageActivity    =   [new HolidayPackageItinerary()];
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $model->user_id = Yii::$app->user->id;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    if(isset($_POST['MetaTag']) && is_array($_POST['MetaTag']) && count($_POST['MetaTag']) > 0){
                        $modelName = StringHelper::basename($model->className());
                        $metaTagModel                   = new MetaTag();
                        $metaTagModel->model            = $modelName;
                        $metaTagModel->model_id         = $model->id;
                        $metaTagModel->page_title       = $_POST['MetaTag']['page_title'];
                        $metaTagModel->description      = $_POST['MetaTag']['description'];
                        $metaTagModel->keywords         = $_POST['MetaTag']['keywords'];
                        $metaTagModel->save();
                    }
                   // \yii\helpers\VarDumper::dump($_POST['HolidayPackageFeature']); exit;
                    if(isset($_POST['HolidayPackageFeature']) && is_array($_POST['HolidayPackageFeature']) && count($_POST['HolidayPackageFeature']) > 0){
                        foreach ($_POST['HolidayPackageFeature'] as $i => $feature) {
                            $featureModel = new HolidayPackageFeature(); //instantiate new HolidayPackageFeature model
                            $featureModel->holiday_package_id = $model->id;
                            $featureModel->holiday_package_type_id = $feature['holiday_package_type_id'];
                            if($featureModel->save()){
                                if(!empty($_POST['HolidayPackageFeatureItem'][$i])){
                                    foreach ($_POST['HolidayPackageFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new HolidayPackageFeatureItem(); //instantiate new HolidayPackageFeature model
                                            $itemModel->package_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            if($itemModel->save()){
                                               // \yii\helpers\VarDumper::dump($itemModel->errors);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Holiday Package has been Added successfully','redirectUrl' => Url::to(['holiday-package/list'])];
                }else{
                    \yii\helpers\VarDumper::dump($model->errors);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                print_r($ex);
            }
        } else {
            return $this->render('create', [
                'model'             => $model,
                'metaTagModel'      =>  $metaTagModel,
                'packageFeature'    =>  $packageFeature,
               // 'packageActivity'   =>  $packageActivity,
            ]);
        }
    }

    public function actionDetails($id){
        $this->layout           =   'main';
        $model                  = $this->findModel($id);
        $metaTagModel           = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $packageFeature         =   $model->holidayFeatures;
        //$packageActivity        = HolidayPackageActivity::findAll(['holiday_package_id' => $model->id]);
        return $this->render('details', [
            'model'             => $model,
            'metaTagModel'      =>  $metaTagModel,
            'packageFeature'    =>  $packageFeature,
           // 'packageActivity'   =>  $packageActivity,
        ]);
    }
    
    /**
     * Updates an existing HolidayPackage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model                  = $this->findModel($id);
        $metaTagModel           = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $packageFeature         = HolidayPackageFeature::findAll(['holiday_package_id' => $id]);
        $packageFeatureItem     = $model->holidayFeatures;
//        \yii\helpers\VarDumper::dump($model); exit;
        if ($model->load(Yii::$app->request->post()) ) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $model->user_id = Yii::$app->user->id;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    if ($metaTagModel->load(Yii::$app->request->post())) {
                        if(!$metaTagModel->save()){
                            print_r($metaTagModel->errors);die();
                        }
                    }
                    if(!empty($_POST['HolidayPackageFeature'])){
                        foreach ($_POST['HolidayPackageFeature'] as $i => $feature) {
                            if (!empty($feature['id']) && $feature['_destroy'] == 1) {
                                HolidayPackageFeature::findOne($feature['id'])->delete();
                                continue;
                            }
                            if (!empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = HolidayPackageFeature::findOne($feature['id']);
                            } elseif (empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = new HolidayPackageFeature();
                                $featureModel->holiday_package_id = $model->id;
                            } elseif (empty($feature['id']) && $feature['_destroy'] == 1) {
                                continue;
                            }
                            $featureModel->holiday_package_id = $model->id;
                            $featureModel->holiday_package_type_id = $feature['holiday_package_type_id'];
                           
                            if($featureModel->save()){
                                //\yii\helpers\VarDumper::dump($_POST['HolidayPackageFeatureItem'],4,12); exit;
                                if(!empty($_POST['HolidayPackageFeatureItem'][$i])){
                                    HolidayPackageFeatureItem::deleteAll(['package_feature_id' => $featureModel->id]);
                                    foreach ($_POST['HolidayPackageFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new HolidayPackageFeatureItem(); //instantiate new HolidayPackageFeature model
                                            $itemModel->package_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            if($itemModel->save()){
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Holiday Package has been Updated successfully','redirectUrl' => Url::to(['holiday-package/list'])];
                }else{
                    return ['success' => false, "message" => \Yii::t('app', "This form contains error(s)"), "errors" => $model->errors];
                    
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                print_r($ex);
            }
        } else {
            return $this->render('update', [
                'model'             => $model,
                'metaTagModel'      =>  $metaTagModel,
                'packageFeature'    =>  $packageFeature,
                'packageFeatureItem'=>  $packageFeatureItem,
                //'packageActivity'   =>  $packageActivity,
            ]);
        }
    }

    /**
     * Deletes an existing HolidayPackage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->photos as $photo){
            $photo->delete();
        }
        $packageFeature = HolidayPackageFeature::findAll(['holiday_package_id' => $id]);
        if(!empty($packageFeature)){
            HolidayPackageFeature::deleteAll(['holiday_package_id' => $id]);
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->redirect(['list']);
    }
    
    /**
     * Finds the Hotel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionItineraryList($id){
        $this->layout           =   'main';
        $searchModel = new HolidayPackageItinerarySearch();
        $searchModel->holiday_package_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('itinerary-list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $id,
            //'hotel_id'      =>  $hotel_id,
        ]);
    }
    
    public function actionCreateItinerary($holiday_package_id){
        $this->layout           =   'main';
        $itineraryModel  =   new HolidayPackageItinerary();
        if ($itineraryModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $itineraryModel->imageFiles = UploadedFile::getInstances($itineraryModel, 'imageFiles');
                if($itineraryModel->save()){
                    if(!empty($itineraryModel->imageFiles)){
                        $itineraryModel->upload();
                    }
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Holiday Package has been Added successfully','redirectUrl' => Url::to(['holiday-package/itinerary-list', 'id' => $holiday_package_id])];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create-itinerary', [
                'itineraryModel'        => $itineraryModel, 
                'holiday_package_id'    => $holiday_package_id,
            ]);
        }
    }
    /**
     * Displays a single Hotel model.
     * @param integer $id
     * @return mixed
     */
    public function actionItineraryView($id){
        $this->layout           =   'main';
        $itineraryModel         =   $this->findItineraryModel($id);
        $holiday_package_id     =   $itineraryModel->holiday_package_id;
        //\yii\helpers\VarDumper::dump($hotel_id); exit;
        return $this->render('itinerary-view', [
            'itineraryModel'        =>  $itineraryModel,
            'holiday_package_id'    =>  $holiday_package_id,
            'id'                    =>  $id,
        ]);
    }
    
    public function actionItineraryUpdate($id){
        $this->layout           =   'main';
        $itineraryModel         = $this->findItineraryModel($id);
        $holiday_package_id     =   $itineraryModel->holiday_package_id;
        if ($itineraryModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $itineraryModel->imageFiles = UploadedFile::getInstances($itineraryModel, 'imageFiles');
                if($itineraryModel->save()){
                    if(!empty($itineraryModel->imageFiles)){
                        $itineraryModel->upload();
                    }
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Holiday Package has been Updated successfully','redirectUrl' => Url::to(['holiday-package/itinerary-list', 'id' => $holiday_package_id])];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } 
        return $this->render('itinerary-update', [
            'itineraryModel'        =>  $itineraryModel,
            'holiday_package_id'    =>  $holiday_package_id,
        ]);
    }
    
    /**
     * Deletes an existing Hotel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionItineraryDelete($id){
        $this->layout                   =   'main';
        $itineraryModel                 =   $this->findItineraryModel($id);
        $searchModel                    =   new HolidayPackageItinerarySearch();
        $holiday_package_id             =   $itineraryModel->holiday_package_id;
        $itineraryModel->delete();
        $searchModel->holiday_package_id = $holiday_package_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->render('itinerary-list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $holiday_package_id,
        ]);
        
    }
    
    public function actionDeletePhoto($id){
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            echo json_encode(array('status' => 'success', 'message' => 'One image delete successfully'));die();
        }else{
            echo json_encode(array('status' => 'failed', 'message' =>'Sorry, We are unable to process your data'));die();
        }
    }
    
    public function actionPackageBooking($id){
        $this->layout         =   'public_main';
        $packageModel         =   $this->findModel($id);
        $packageGuest         =   [new HolidayBookingGuest()];
        return $this->render('package-booking', [
            'packageModel'      =>  $packageModel,
            'packageGuest'      =>  $packageGuest,
            'id'                =>  $id,
        ]);
    }
    public function actionBookingGuestInfo(){
        $this->layout           =   'public_main';
        $packageModel           =    new HolidayPackage();
        $packageGuest           =   [new HolidayBookingGuest()];
        $packageBooking         =   new HolidayPackageBooking();
        
        if(isset($_POST['HolidayBookingGuest']) && is_array($_POST['HolidayBookingGuest']) && count($_POST['HolidayBookingGuest']) > 0){
            Yii::$app->session->set('guestDetails', $_POST['HolidayBookingGuest']);

        }
        
        return $this->render('booking-guest-info', [
            'packageGuest'      =>  $packageGuest,
            'packageBooking'    =>  $packageBooking,
            
        ]);
    }
       
    public function actionProcessExpressCheckout() {
        $packageModel           =    new HolidayPackage();
        $packageGuest           =   [new HolidayBookingGuest()];
        $packageBooking         =   new HolidayPackageBooking();
        if ($itineraryModel->load(Yii::$app->request->post())) {
            
        }
        $plan = PlanMaster::findOne($selected_plan_id);
        if (empty($plan) || $plan->status != 'active') {
            throw new NotFoundHttpException('Selected plan currently not available');
        }

        $PayPalConfig = array(
            'Sandbox' => Yii::$app->params['Sandbox'],
            'APIUsername' => Yii::$app->params['APIUsername'],
            'APIPassword' => Yii::$app->params['APIPassword'],
            'APISignature' => Yii::$app->params['APISignature'],
        );

        $PayPal = new PayPal($PayPalConfig);

        $SECFields = array(
            'token' => '', // A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
            'maxamt' => '200.00', // The expected maximum total amount the order will be, including S&H and sales tax.
            'returnurl' => Url::to(['/holiday-package/do-express-checkout'], true), // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
            'cancelurl' => Url::to(['/holiday-package/cancel-payment'], true), // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
            'callback' => '', // URL to which the callback request from PayPal is sent.  Must start with https:// for production.
            'brandname' => Yii::$app->name,
            'noshipping' => '1'
        );

// Basic array of survey choices.  Nothing but the values should go in here.  
        $SurveyChoices = array('Yes', 'No');

        $Payments = array();
        $Payment = array(
            'amt' => $plan->amount, // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
            'currencycode' => 'USD', // A three-character currency code.  Default is USD.
            'insuranceoptionoffered' => '', // If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
            'handlingamt' => '', // Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
            'desc' => 'This is a test order.', // Description of items on the order.  127 char max.
            'custom' => json_encode(['plan_id' => $plan->id]), // Free-form field for your own use.  256 char max.
            'invnum' => '', // Your own invoice or tracking number.  127 char max.
            'notifyurl' => '', // URL for receiving Instant Payment Notifications
            'notetext' => 'This is a test note before ever having left the web site.', // Note to the merchant.  255 char max.  
            'allowedpaymentmethod' => '', // The payment method type.  Specify the value InstantPaymentOnly.
            'paymentaction' => 'Sale', // How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order. 
        );

        array_push($Payments, $Payment);
        $BillingAgreements = array();
        $PayPalRequest = array(
            'SECFields' => $SECFields,
            'SurveyChoices' => $SurveyChoices,
            'BillingAgreements' => $BillingAgreements,
            'Payments' => $Payments
        );

        $setExpressCheckoutResult = $PayPal->SetExpressCheckout($PayPalRequest);
        if($setExpressCheckoutResult['ACK'] == 'Success'){
//        \yii\helpers\VarDumper::dump($setExpressCheckoutResult, 22, 1);die();
            Yii::$app->session->set('token', $setExpressCheckoutResult['TOKEN']);
            return $this->redirect($setExpressCheckoutResult['REDIRECTURL']);
        }
    }
    
    public function actionDoExpressCheckout() {
        $token = Yii::$app->session->get('token');
        $PayPalConfig = array(
            'Sandbox' => Yii::$app->params['Sandbox'],
            'APIUsername' => Yii::$app->params['APIUsername'],
            'APIPassword' => Yii::$app->params['APIPassword'],
            'APISignature' => Yii::$app->params['APISignature'],
        );

        $PayPal = new PayPal($PayPalConfig);

        /*
         * Here we call GetExpressCheckoutDetails to obtain payer information from PayPal
         */
        $GECDResult = $PayPal->GetExpressCheckoutDetails($token);
        
        if($GECDResult['ACK'] != 'Success'){
            throw new Exception('Error while get express checkout', 500);
        }
        
        $customVal = json_decode($GECDResult['PAYMENTS'][0]['CUSTOM']);
        $plan = PlanMaster::findOne($customVal->plan_id);
        
        $DECPFields = array(
            'token' => $token, // Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
            'payerid' => $GECDResult['PAYERID'], // Required.  Unique PayPal customer id of the payer.  Returned by GetExpressCheckoutDetails, or if you used SKIPDETAILS it's returned in the URL back to your RETURNURL.
            'returnfmfdetails' => '1', // Flag to indicate whether you want the results returned by Fraud Management Filters or not.  1 or 0.
        );

        $Payments = array();
        $Payment = array(
            'amt' => $plan->amount, // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
            'currencycode' => 'USD', // A three-character currency code.  Default is USD.
//            'itemamt' => '80.00', // Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
            'insuranceoptionoffered' => '', // If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
            'handlingamt' => '', // Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
//            'taxamt' => '5.00', // Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
            'desc' => 'This is a test order.', // Description of items on the order.  127 char max.
            'custom' => '', // Free-form field for your own use.  256 char max.
            'notetext' => 'This is a test note before ever having left the web site.', // Note to the merchant.  255 char max.  
            'allowedpaymentmethod' => '', // The payment method type.  Specify the value InstantPaymentOnly.
            'paymentaction' => 'Sale', // How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order. 
        );

        array_push($Payments, $Payment);

        $PayPalRequest = array(
            'DECPFields' => $DECPFields,
            'Payments' => $Payments
        );

        $paypalResult = $PayPal->DoExpressCheckoutPayment($PayPalRequest);
        if($paypalResult['ACK'] != 'Success'){
            throw new Exception('Error while do express checkout', 500);
        }
        
        $paypalResultPayment = $paypalResult['PAYMENTS'][0];
        
        $transaction = new Transaction();
        $transaction->user_id = Yii::$app->user->id;
        $transaction->gateway = $paypalResultPayment['TRANSACTIONTYPE'];
        $transaction->transactionid = $paypalResultPayment['TRANSACTIONID'];
        $transaction->amt = $paypalResultPayment['AMT'];
        $transaction->currencycode = $paypalResultPayment['CURRENCYCODE'];
        $transaction->status = $paypalResult['ACK'];
        if(!$transaction->save()){
            throw new \yii\web\HttpException(500, 'Error saving model: Transaction'. json_encode($transaction->errors));
        }

        $subscription = new Subscription();
        $subscription->service_category_id = $plan->service_category_id;
        $subscription->transaction_id = $transaction->id;
        $subscription->user_id = Yii::$app->user->id;
        $subscription->plan_id = $plan->id;
        $subscription->paid_amount = $paypalResultPayment['AMT'];
        $subscription->subs_start = strtotime('now');
        $subscription->subs_end = strtotime("+{$plan->duration} days", $subscription->subs_start);
        $subscription->status = 'active';
        if(!$subscription->save()){
            throw new \yii\web\HttpException(500, 'Error saving model: Subscription'. json_encode($subscription->errors));
        }

        return $this->redirect(['subscription/payment-success', 'transactionid' => $paypalResultPayment['TRANSACTIONID'], 'subscriptionid' => $subscription->id]);
        
    }

    public function actionCancelPayment(){
        echo 'cancelled';die();
    }


    public function actionPaymentSuccess($transactionid, $subscriptionid) {
        $PayPalConfig = array(
            'Sandbox' => Yii::$app->params['Sandbox'],
            'APIUsername' => Yii::$app->params['APIUsername'],
            'APIPassword' => Yii::$app->params['APIPassword'],
            'APISignature' => Yii::$app->params['APISignature'],
        );

        $PayPal = new PayPal($PayPalConfig);

// Prepare request arrays
        $GTDFields = array(
            'transactionid' => $transactionid       // PayPal transaction ID of the order you want to get details for.
        );

        $PayPalRequestData = array('GTDFields' => $GTDFields);

        $paypalResult = $PayPal->GetTransactionDetails($PayPalRequestData);
        
//        echo '<pre>';
//        print_r($paypalResult);
//        die();
        
        $transaction = Transaction::find()->where(['transactionid' => $paypalResult['TRANSACTIONID']])->one();
        $transaction->receiveremail = $paypalResult['RECEIVEREMAIL'];
        $transaction->receiverid = $paypalResult['RECEIVERID'];
        $transaction->payerid = $paypalResult['PAYERID'];
        $transaction->payerstatus = $paypalResult['PAYERSTATUS'];
        $transaction->timestamp = $paypalResult['TIMESTAMP'];
        $transaction->correlationid = $paypalResult['CORRELATIONID'];
        $transaction->receiptid = isset($paypalResult['RECEIPTID'])?$paypalResult['RECEIPTID']:'';
        $transaction->paymenttype = $paypalResult['PAYMENTTYPE'];
        $transaction->paymentstatus = $paypalResult['PAYMENTSTATUS'];
        $transaction->gateway = $paypalResult['TRANSACTIONTYPE'];
        if(!$transaction->save()){
            throw new \yii\web\HttpException(500, 'Error saving model: Transaction');
        }
        
        $customVal = json_decode($paypalResult['CUSTOM']);
        $plan = PlanMaster::findOne($customVal->plan_id);
        $subscription = Subscription::findOne($subscriptionid);
        $template = EmailTemplate::findOne(['code' => 'SUBSCRIPTION_NOTIFICATION']);
        $ar['{{%FULL_NAME%}}']                  = $subscription->user->first_name;

        MailSend::sendMail('SUBSCRIPTION_NOTIFICATION', Yii::$app->user->identity->email, $ar);
//        Yii::$app->mailer->compose(['html' => 'subscriptionNotification-html'], ['plan' => $plan, 'subscription' => $subscription])
//            ->setTo(Yii::$app->user->identity->email)
//            ->setSubject('Subscription for: ' . Yii::$app->name)
//            ->send();
        
        return $this->render('payment-success', ['plan' => $plan, 'subscription' => $subscription, 'paypalResult' => $paypalResult]);
    }
    
    protected function findItineraryModel($id){
        if (($itineraryModel = HolidayPackageItinerary::findOne($id)) !== null) {
            return $itineraryModel;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModel($id)
    {
        if (($model = HolidayPackage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}