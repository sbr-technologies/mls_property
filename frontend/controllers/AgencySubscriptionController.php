<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Subscription;
use common\models\Transaction;
use common\models\PlanMaster;
use angelleye\PayPal\PayPal;
use common\components\MailSend;
use yii\web\UnauthorizedHttpException;
use common\models\CurrencyMaster;
use yii\base\Exception;
use common\models\User;

class AgencySubscriptionController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['subscriptions', 'plans', 'plan-details'],
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
    public function actionSubscriptions(){
        $user = Yii::$app->user->identity;
        if(empty($user->agency_id)){
            throw new NotFoundHttpException(Yii::t('app', 'You have not setup your agency'));
        }
        $subscriptions = Subscription::find()->where(['agency_id' => $user->agency_id])->orderBy(['service_category_id' => SORT_ASC, 'id' => SORT_DESC])->all();
        return $this->render('subscriptions', ['subscriptions' => $subscriptions]);
    }
    
    public function actionPlans($service_id) {
        $isAgency = 1;
        $plans = PlanMaster::find()->where(['for_agency' => $isAgency, 'service_category_id' => $service_id])->active()->all();
        if(empty($plans)){
            throw new NotFoundHttpException(Yii::t('app', 'Subscription Plans for this category have not been set yet. Please contact Administrator.'));
        }
        return $this->render('plans',['plans' => $plans]);
    }
    
    public function actionPlanDetails($id, $duration = null){
        $user = Yii::$app->user->identity;
        if(empty($user->agency_id)){
            throw new NotFoundHttpException('Agency Not found.');
        }
        $model = PlanMaster::find()->where(['id' => $id, 'for_agency' => 1, 'status' => 'active'])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Plan not found.');
        }
        $oldLSubs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => $model->service_category_id])->active()->exists();
        if($oldLSubs){
            throw new UnauthorizedHttpException('You already have an active subscription');
        }
        return $this->render('plan-details', ['model' => $model, 'duration' => $duration]);
    }
    
    public function actionSubscribe($selected_plan_id){
        $user = Yii::$app->user->identity;
        $agency = \common\models\Agency::findOne($user->agency_id);
        $duration = 1;
        $plan = PlanMaster::find()->where(['id' => $selected_plan_id, 'amount' => 0])->active()->one();
        if(empty($plan)){
            throw new NotFoundHttpException('Selected plan currently not available');
        }
        $oldLSubs = Subscription::find()->where(['user_id' => $user->id, 'service_category_id' => $plan->service_category_id])->active()->exists();
        if($oldLSubs){
            throw new UnauthorizedHttpException('You already have an active subscription' );
        }
        
        $subsStart = strtotime('now');
        $subscription = new Subscription();
        $subscription->service_category_id = $plan->service_category_id;
        $subscription->transaction_id = null;
        $subscription->user_id = null;
        $subscription->agency_id = $agency->id;
        $subscription->plan_id = $plan->id;
        $subscription->paid_amount = 0;
        $subscription->currency_code = 'USD';
        $subscription->duration = $duration;
        $subscription->subs_start = $subsStart;
        $subscription->subs_end = strtotime("+{$duration} months", $subsStart);
        $subscription->status = 'active';
        if(!$subscription->save()){
            throw new \yii\web\HttpException(500, 'Error saving model: Subscription'. json_encode($subscription->errors));
        }
        return $this->redirect(['success', 'subscriptionid' => $subscription->id]);
    }
    
    public function actionProcessCard() {
        $currency = new CurrencyMaster();
        $rate = $currency->convert('NGN', 'USD');
	$user = Yii::$app->user->identity;
        $cardDetails = Yii::$app->request->post('card');
        $planId = Yii::$app->request->post('selected_plan_id');
        $duration = Yii::$app->request->post('duration');
        $plan = PlanMaster::findOne($planId);
        if(empty($plan) || $plan->status != 'active'){
            throw new NotFoundHttpException('Selected plan currently not available');
        }
        $oldLSubs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => $plan->service_category_id])->active()->exists();
        if($oldLSubs){
            throw new UnauthorizedHttpException('You already have an active subscription' );
        }
        $PayPalConfig = array(
            'Sandbox' => Yii::$app->params['Sandbox'],
            'APIUsername' => Yii::$app->params['APIUsername'],
            'APIPassword' => Yii::$app->params['APIPassword'],
            'APISignature' => Yii::$app->params['APISignature'],
//            'PrintHeaders' => $print_headers,
//            'LogResults' => $log_results,
//            'LogPath' => $log_path,);
            );
        $PayPal = new PayPal($PayPalConfig);

        $DPFields = array(
            'paymentaction' => 'Sale', // How you want to obtain payment.  Authorization indicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
            'ipaddress' => $_SERVER['REMOTE_ADDR'], // Required.  IP address of the payer's browser.
            'returnfmfdetails' => '1'      // Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
        );

        $CCDetails = array(
            'creditcardtype' => ucfirst($cardDetails['type']), // Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
            'acct' => $cardDetails['card_number'], // Required.  Credit card number.  No spaces or punctuation.
            'expdate' => str_pad($cardDetails['exp_month'], 2, '0', STR_PAD_LEFT). $cardDetails['exp_year'], // Required.  Credit card expiration date.  Format is MMYYYY
            'cvv2' => $cardDetails['cvv2'], // Requirements determined by your PayPal account settings.  Security digits for credit card.
            'startdate' => '', // Month and year that Maestro or Solo card was issued.  MMYYYY
            'issuenumber' => ''       // Issue number of Maestro or Solo card.  Two numeric digits max.
        );

        $PayerInfo = array();

        $PayerName = array();

        $BillingAddress = array();
        $amount = $plan->amount;
        if($duration == 3){
            $amount = $plan->amount_for_3_months;
        }elseif($duration == 6){
            $amount = $plan->amount_for_6_months;
        }elseif($duration == 12){
            $amount = $plan->amount_for_12_months;
        }else{
            $duration = 1;
        }
        $PaymentDetails = array(
            'amt' => $amount * $rate, // Required.  Total amount of order, including shipping, handling, and tax.  
            'currencycode' => 'USD', // Required.  Three-letter currency code.  Default is USD.
            'itemamt' => '', // Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
            'shippingamt' => '', // Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
            'handlingamt' => '', // Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
            'taxamt' => '', // Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax. 
            'desc' => 'Subscription to:'. $plan->title, // Description of the order the customer is purchasing.  127 char max.
            'custom' => json_encode(['plan_id' => $plan->id, 'duration' => $duration]), // Free-form field for your own use.  256 char max.
            'invnum' => '', // Your own invoice or tracking number
            'buttonsource' => '', // An ID code for use by 3rd party apps to identify transactions.
            'notifyurl' => ''      // URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
        );

        $OrderItems = array();

        $PayPalRequestData = array(
            'DPFields' => $DPFields,
            'CCDetails' => $CCDetails,
            'PayerInfo' => $PayerInfo,
            'PayerName' => $PayerName,
            'BillingAddress' => $BillingAddress,
            'PaymentDetails' => $PaymentDetails,
            'OrderItems' => $OrderItems
        );
        $paypalResult = $PayPal->DoDirectPayment($PayPalRequestData);
//        echo '<pre>';
//        print_r($paypalResult);die();
        if($paypalResult['ACK'] == 'Success'){
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->agency_id = $user->agency_id;
            $transaction->gateway = 'Paypal';
            $transaction->transactionid = $paypalResult['TRANSACTIONID'];
            $transaction->amt = $paypalResult['AMT'];
            $transaction->currencycode = $paypalResult['CURRENCYCODE'];
            $transaction->status = $paypalResult['ACK'];
            if(!$transaction->save()){
                throw new \yii\web\HttpException(500, 'Error saving model: Transaction'. json_encode($transaction->errors));
            }
            $subsStart = strtotime('now');
            $subscription = new Subscription();
            $subscription->service_category_id = $plan->service_category_id;
            $subscription->transaction_id = $transaction->id;
            $subscription->agency_id = $user->agency_id;
            $subscription->plan_id = $plan->id;
            $subscription->paid_amount = $paypalResult['AMT'];
            $subscription->currency_code = $paypalResult['CURRENCYCODE'];
            $subscription->duration = $duration;
            $subscription->subs_start = $subsStart;
            $subscription->subs_end = strtotime("+{$duration} months", $subsStart);
            $subscription->status = 'active';
            if(!$subscription->save()){
                throw new \yii\web\HttpException(500, 'Error saving model: Subscription'. json_encode($subscription->errors));
            }
            
            return $this->redirect(['agency-subscription/payment-success', 'transactionid' => $paypalResult['TRANSACTIONID'], 'subscriptionid' => $subscription->id]);
        }
        Yii::$app->session->setFlash('error', 'Transaction could not completed at this time try again later');
        return $this->redirect(['agency-subscription/plan-details', 'id' => $plan->id]);
    }
    
    public function actionProcessExpressCheckout($selected_plan_id, $duration = null) {
		
        $currency = new CurrencyMaster();
        $rate = $currency->convert('NGN', 'USD');
	$user = Yii::$app->user->identity;
        $plan = PlanMaster::findOne($selected_plan_id);
        if (empty($plan) || $plan->status != 'active') {
            throw new NotFoundHttpException('Selected plan currently not available');
        }
        
        $oldLSubs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => $plan->service_category_id])->active()->exists();
        if($oldLSubs){
            throw new UnauthorizedHttpException('You already have an active subscription' );
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
            //'maxamt' => '200.00', // The expected maximum total amount the order will be, including S&H and sales tax.
            'returnurl' => Url::to(['/agency-subscription/do-express-checkout'], true), // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
            'cancelurl' => Url::to(['/agency-subscription/cancel-payment'], true), // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
            'callback' => '', // URL to which the callback request from PayPal is sent.  Must start with https:// for production.
            'brandname' => Yii::$app->name,
            'noshipping' => '1'
        );

// Basic array of survey choices.  Nothing but the values should go in here.  
        $SurveyChoices = array('Yes', 'No');
        $amount = $plan->amount;
        if($duration == 3){
            $amount = $plan->amount_for_3_months;
        }elseif($duration == 6){
            $amount = $plan->amount_for_6_months;
        }elseif($duration == 12){
            $amount = $plan->amount_for_12_months;
        }else{
            $duration = 1;
        }
        $Payments = array();
        $Payment = array(
            'amt' => $amount * $rate, // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
            'currencycode' => 'USD', // A three-character currency code.  Default is USD.
            'insuranceoptionoffered' => '', // If true, the insurance drop-down on the PayPal review page displays the string 'Yes' and the insurance amount.  If true, the total shipping insurance for this order must be a positive number.
            'handlingamt' => '', // Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
            'desc' => 'This is a test order.', // Description of items on the order.  127 char max.
            'custom' => json_encode(['plan_id' => $plan->id, 'duration' => $duration, 'user_id' => $user->id]), // Free-form field for your own use.  256 char max.
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
        }else{
			echo '<pre>';
			print_r($setExpressCheckoutResult);
			die();
		}
    }

    public function actionDoExpressCheckout() {
	
	$currency = new CurrencyMaster();
        $rate = $currency->convert('NGN', 'USD');
        $user = Yii::$app->user->identity;
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
        $duration = $customVal->duration;
        $userId = $customVal->user_id;
        $plan = PlanMaster::findOne($customVal->plan_id);
        if(!empty($user)){
            $user = \common\models\User::findOne($userId);
        }
        $DECPFields = array(
            'token' => $token, // Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
            'payerid' => $GECDResult['PAYERID'], // Required.  Unique PayPal customer id of the payer.  Returned by GetExpressCheckoutDetails, or if you used SKIPDETAILS it's returned in the URL back to your RETURNURL.
            'returnfmfdetails' => '1', // Flag to indicate whether you want the results returned by Fraud Management Filters or not.  1 or 0.
        );
        
        $amount = $plan->amount;
        if($duration == 3){
            $amount = $plan->amount_for_3_months;
        }elseif($duration == 6){
            $amount = $plan->amount_for_6_months;
        }elseif($duration == 12){
            $amount = $plan->amount_for_12_months;
        }else{
            $duration = 1;
        }
        
        $Payments = array();
        $Payment = array(
            'amt' => $amount * $rate, // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
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
        $transaction->user_id = $user->id;
        $transaction->agency_id = $user->agency_id;
        $transaction->gateway = $paypalResultPayment['TRANSACTIONTYPE'];
        $transaction->transactionid = $paypalResultPayment['TRANSACTIONID'];
        $transaction->amt = $paypalResultPayment['AMT'];
        $transaction->currencycode = $paypalResultPayment['CURRENCYCODE'];
        $transaction->status = $paypalResult['ACK'];
        if(!$transaction->save()){
            throw new \yii\web\HttpException(500, 'Error saving model: Transaction'. json_encode($transaction->errors));
        }
        
        $subsStart = strtotime('now');
        $subscription = new Subscription();
        $subscription->service_category_id = $plan->service_category_id;
        $subscription->transaction_id = $transaction->id;
        $subscription->agency_id = $user->agency_id;
        $subscription->plan_id = $plan->id;
        $subscription->paid_amount = $paypalResultPayment['AMT'];
        $subscription->currency_code = $paypalResultPayment['CURRENCYCODE'];
        $subscription->duration = $duration;
        $subscription->subs_start = $subsStart;
        $subscription->subs_end = strtotime("+{$duration} months", $subsStart);
        $subscription->status = 'active';
        if(!$subscription->save()){
            throw new \yii\web\HttpException(500, 'Error saving model: Subscription'. json_encode($subscription->errors));
        }

        return $this->redirect(['agency-subscription/payment-success', 'transactionid' => $paypalResultPayment['TRANSACTIONID'], 'subscriptionid' => $subscription->id]);
        
    }

    public function actionCancelPayment(){
        echo 'cancelled';die();
    }

    public function actionSuccess($subscriptionid){
        $subscription = Subscription::findOne($subscriptionid);
        if(empty($subscription)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $plan = PlanMaster::findOne($subscription->plan_id);
        $broker = \common\models\User::find()->where(['agency_id' => $subscription->agency->id, 'profile_id' => User::PROFILE_AGENCY])->one();
        //$template = EmailTemplate::findOne(['code' => 'SUBSCRIPTION_NOTIFICATION']);
        $ar['{{%FULL_NAME%}}']                  = $broker->first_name;

        MailSend::sendMail('SUBSCRIPTION_NOTIFICATION', $broker->email, $ar);
        
        return $this->render('payment-success', ['plan' => $plan, 'subscription' => $subscription]);
    }
    public function actionPaymentSuccess($transactionid, $subscriptionid) {
        $user = Yii::$app->user->identity;
        if(empty($user)){
            throw new UnauthorizedHttpException('You are not logged in');
        }
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
        $broker = \common\models\User::find()->where(['agency_id' => $subscription->agency->id, 'profile_id' => User::PROFILE_AGENCY])->one();
        //$template = EmailTemplate::findOne(['code' => 'SUBSCRIPTION_NOTIFICATION']);
        $ar['{{%FULL_NAME%}}']                  = $broker->fullName;

        MailSend::sendMail('AGENCY_SUBSCRIPTION_NOTIFICATION', $broker->email, $ar);
//        Yii::$app->mailer->compose(['html' => 'subscriptionNotification-html'], ['plan' => $plan, 'subscription' => $subscription])
//            ->setTo(Yii::$app->user->identity->email)
//            ->setSubject('Subscription for: ' . Yii::$app->name)
//            ->send();
        
        return $this->render('payment-success', ['plan' => $plan, 'subscription' => $subscription, 'paypalResult' => $paypalResult]);
    }

        
    public function actionTerminate($id){
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        if(empty($agency)){
            throw new UnauthorizedHttpException('You are not authorized to access this page');
        }
        $subscription = Subscription::find()->where(['id' => $id, 'agency_id' => $agency->id])->active()->one();
        if(empty($subscription)){
            throw new NotFoundHttpException('Subscription not found');
        }
        
        $subscription->status = Subscription::STATUS_INACTIVE;
        $subscription->save();
        Yii::$app->session->setFlash('success', 'Current subscription for your Office has been terminated');
        return $this->redirect(['subscriptions']);
    }
    /**
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Property the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscription::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}