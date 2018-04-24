<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Clinic;
use common\models\DoctorAppointmentBookings;

class Common extends Model {

    public static function cleanInput($input) {

        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<style[^>]*?>.*?</style>@siU' // Strip style tags properly
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }

// Encrypt Function
    public static function stEncrypt($encrypt, $key = '') {
        if ($key == '') {
            $key = Yii::$app->params['encryption_key'];
        }

        $encrypt = serialize($encrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt) . '|' . base64_encode($iv);
        
        return base64_encode($encoded);;
    }

// Decrypt Function
    public static function stDecrypt($decrypt, $key = '') {
       $decrypt =  base64_decode($decrypt);
        if ($key == '') {
            $key = Yii::$app->params['encryption_key'];
        }
        $decrypt = explode('|', $decrypt . '|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {
            return false;
        }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if ($calcmac !== $mac) {
            return false;
        }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }

    public static function generateBookingId($clinicId, $doctorId, $timestamp, $numeric = false, $patientID = false, $randomize = false) {
       $count =  (int) DoctorAppointmentBookings::find()
                ->where(['doctor_id' => $doctorId, 'clinic_id' => $clinicId])
                ->andWhere(['DATE(visiting_time)' => date('Y-m-d' , $timestamp)])
                ->count();
       $count++;
        $setting = \common\models\SiteConfig::setting("alphanumeric_booking_no");
        $numeric = $setting == "yes" ? false : true;
        $toReturn = null;

        $date = date('Ymd', $timestamp);
        if ($numeric) {
            if (isset($patientID) && $patientID <> "") {
                $toReturn = $clinicId . $doctorId . $patientID . $date . $count;
            } else {
                $toReturn = str_pad($clinicId, 3, '0', STR_PAD_LEFT) . str_pad($doctorId, 3, '0', STR_PAD_LEFT) . $date . $count;
            }
        } else {
            $clinicSlug = Clinic::findOne($clinicId)->short_name;
            $doctorSlug = User::findOne($doctorId)->short_name;
            if (empty($clinicSlug)) {
                $clinicSlug = "CLI";
            }
            if (empty($doctorSlug)) {
                $doctorSlug = "DOC";
            }
            if (isset($patientID) && $patientID <> "") {
                $toReturn = $clinicSlug . $doctorSlug . $patientID . $date . $count;
            } else {
                $toReturn = $clinicSlug . $doctorSlug . $date . $count;
            }
        }


        /* Duplicate Check */
        $current = DoctorAppointmentBookings::find()->where(['bookingID' => $toReturn])->one();

        if (empty($current)) {
            return $toReturn;
        } else {
            return static::generateBookingId($clinicId, $doctorId, $timestamp, $numeric, $patientID, true);
        }
    }

    public static function generateName($firstName = null, $middleName = null, $lastName = null, $prserveCase = false) {
        $name = !$prserveCase ? ucfirst($firstName) : $firstName;
        if (!empty($middleName))
            $name .=!$prserveCase ? ' ' . ucfirst($middleName) : ' ' . $middleName;
        if (!empty($lastName))
            $name .=!$prserveCase ? ' ' . ucfirst($lastName) : ' ' . $lastName;
        return $name;
    }

    public static function generateActivationKey() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateOTPKey($length = 4) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function apiError($errors) {
        if (!empty($errors)) {
            foreach ($errors as $key => $error) {
                if ($key == 'password2') {
                    unset($errors[$key]);
                } elseif ($key == 'password1') {
                    $errors['password'] = $error[0];
                    unset($errors[$key]);
                } else {
                    $errors[$key] = $error[0];
                }
            }
        }
        return $errors;
    }

    public static function excerpt($str, $startPos = 0, $maxLength = 100) {
        $str = strip_tags($str);
        if (strlen($str) > $maxLength) {
            $excerpt = substr($str, $startPos, $maxLength - 3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt = substr($excerpt, 0, $lastSpace);
            $excerpt .= '...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }

    public static function userTimeZone($userId = NULL) {
        if ($userId) {
            $user = User::findOne($userId);
            if (empty($user))
                return false;
            return $user->timezone;
        }
        $timezone = "UTC";
        if (Yii::$app->user->id) {

            if (isset($_COOKIE['utz'])) {
                $timezone = $_COOKIE['utz'];
            } else {
                $timezone = Yii::$app->user->identity->timezone;
            }
        }
        return $timezone;
    }

    public static function date($format, $stamp = null, $timezone = 'UTC') {

        try {
            @date_default_timezone_set($timezone);
        } catch (Exception $ex) {
            date_default_timezone_set("UTC");
        }
        $date = empty($stamp) ? date($format) : date($format, $stamp);
        date_default_timezone_set("UTC");
        return $date;
    }

    public static function timezoneString() {
        $session = Yii::$app->session;
        $session->open();
        return $session->get('timezone', 'UTC');
    }

    public static function myDate($format, $stamp = null) {
        $session = Yii::$app->session;
        $session->open();
        $timezone = $session->get('timezone');
        if (empty($timezone)) {
            $timezone = 'UTC';
        }
        try {
            @date_default_timezone_set($timezone);
        } catch (Exception $ex) {
            date_default_timezone_set("UTC");
        }
        $date = empty($stamp) ? date($format) : date($format, $stamp);
        date_default_timezone_set("UTC");
        return $date;
    }

    public static function strtomytime($stamp, $timezone = null, $int = false) {
        if (empty($timezone)) {
            $timezone = "UTC";
        }

        $offset = static::getTimezoneOffset($timezone, 'UTC');

        return $int ? $stamp - $offset : strtotime($stamp) - $offset;
    }

    public static function convertToTz($timestamp, $utz, $stz, $format = 'c') {

        if (empty($utz)) {
            $utz = "UTC";
        }
        if (empty($stz)) {
            $stz = "UTC";
        }
        $curr = date_default_timezone_get();
        date_default_timezone_set("UTC");

        $offset = static::getTimezoneOffset($utz, $stz);
        $timestamp = strtotime($timestamp) - $offset;
        date_default_timezone_set($utz);
        $dt = date('c', $timestamp);
        if ($format != 'c') {
            $dt = date($format, strtotime($dt));
        }
        date_default_timezone_set($curr);
        return $dt;
    }

    public static function dateTimeShift($dateString, $fromTimezone, $toTimeZone , $format = 'Y-m-d H:i' ) {
        if ($fromTimezone == $toTimeZone) {
            return $dateString;
        }
        $date = new \DateTime($dateString, new \DateTimeZone($fromTimezone));
        $date->setTimezone(new \DateTimeZone($toTimeZone));
        return $date->format($format);
    }

    public static function getUtcSlotTime($stamp, $id, $timezone = null) {
        //echo $stamp . PHP_EOL;
        list($date, $time) = explode(" ", $stamp, 2);

        $user = User::findOne($id);
        if (empty($timezone)) {
            $timezone = isset($_GET['timezone']) ? $_GET['timezone'] : (isset($user->timezone) && !empty($user->timezone) ? $user->timezone : 'UTC');
        }

        $offset = static::getTimezoneOffset($timezone, 'UTC');
        //  echo $offset;echo "<br>";echo $timezone;echo "<br>";echo $date; echo "<br>";echo $time;echo "<br>";
        // this is system generated date, e.g. UTC
        $utcTimestampDate = strtotime($date . "00:00:00");

        $timestampTime = static::getSeconds($time);
        $utcTimestampTime = $timestampTime + $offset;
        //echo $utcTimestampTime . PHP_EOL;
        /* in case the difference goes to previous day */
        if ($utcTimestampTime < 0) {
            //$utcTimestampDate = strtotime("-1day", $utcTimestampDate);
        }
        /* in case the difference goes to next  day */
        if ($utcTimestampTime > 24 * 60 * 60) {
            // $utcTimestampDate = strtotime("+1day", $utcTimestampDate);
        }

        //  echo date('Y-m-d H:i a' , ($utcTimestampDate + $utcTimestampTime)) . PHP_EOL;
        return $utcTimestampDate + $utcTimestampTime;
    }

    public static function getSeconds($time) {

        return strtotime("1970-01-01 $time UTC");
    }

    public static function strtoutctime($time) {
        date_default_timezone_set("UTC");
        return strtotime($time);
    }

    public static function getTimezoneOffset($remote_tz, $origin_tz = null) {
        if (empty($remote_tz)) {
            $remote_tz = "UTC";
        }
        if (empty($origin_tz)) {
            $origin_tz = "UTC";
        }
        try {
            $origin_dtz = new \DateTimeZone($origin_tz);
        } catch (Exception $ex) {
            $origin_dtz = new \DateTimeZone("UTC");
        }
        try {
            $remote_dtz = new \DateTimeZone($remote_tz);
        } catch (Exception $e) {
            $remote_dtz = new \DateTimeZone("UTC");
        }

        $origin_dt = new \DateTime("now", $origin_dtz);
        $remote_dt = new \DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);

        return $offset;
    }

    public static function localToUtc($time, $format = 'Y-m-d H:i:s', $userId = null) {
        $uTz = static::userTimeZone($userId);
        $uTzOffset = static::getTimezoneOffset($uTz);
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }

        return date($format, $time + $uTzOffset);
    }

    function gmdate($pattern, $stamp = null) {
        $currentZone = date_default_timezone_get();
        date_default_timezone_set("UTC");
        $date = !empty($stamp) ? date($pattern, $stamp) : date($pattern);
        date_default_timezone_set($currentZone);
        return $date;
    }

    public static function setHttpHeaders($type, $name, $mime, $encoding = 'utf-8') {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") == false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        } else {
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: public");
        }
        header("Expires: Sat, 26 Jul 1979 05:00:00 GMT");
        header("Content-Encoding: {$encoding}");
        header("Content-Type: {$mime}; charset={$encoding}");
        header("Content-Disposition: attachment; filename={$name}.{$type}");
        header("Cache-Control: max-age=0");
    }

    public static function prepareSearchLink($string) {
        $string = urldecode($string);
        $array = explode(",", $string);
        if (!empty($array)) {
            foreach ($array as $key => $val) {
                $val = trim($val);
                $val = htmlspecialchars($val);
                $array[$key] = \yii\helpers\Html::a($val, ['/site/search', 'entity' => $val, 'lat' => 0, 'lng' => 0]);
            }
        }
        return implode(',', $array);
    }

    public static function toObj($array) {
        return json_decode(json_encode($array));
    }

    public static function timeElapsed($ptime) {
        $etime = time() - $ptime;

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array(365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        $a_plural = array('year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

    public static function getMimeType($filename) {
        $realpath = realpath($filename);
        if ($realpath && function_exists('finfo_file') && function_exists('finfo_open') && defined('FILEINFO_MIME_TYPE')
        ) {
            // Use the Fileinfo PECL extension (PHP 5.3+)
            return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $realpath);
        }
        if (function_exists('mime_content_type')) {
            // Deprecated in PHP 5.3
            return mime_content_type($realpath);
        }
        return false;
    }

    public static function minimumAvailableTime($beginTimeShifted, $timeEachSlot, $compareWith) {
        date_default_timezone_set("UTC");
        $beginTimeShifted = strtotime($beginTimeShifted);
        $timeEachSlot = $timeEachSlot * 60;
        $now = strtotime($compareWith);
        while ($now >= $beginTimeShifted) {
            $beginTimeShifted += $timeEachSlot;
        }
        return date("H:i", $beginTimeShifted);
    }

    public static function prepareSchedule($schedules, $passedDays) {
        //days match
        $temp = [];
        foreach ($passedDays as $key => $value) {
            $temp[$value] = null;
        }
        foreach ($schedules as $key => $value) {
            $temp[$value->day] = $value;
        }
//        echo "<pre>";
//        var_dump($schedules);
//        echo "</pre>";
//        echo "<pre>";
//        var_dump($temp);
//        echo "</pre>";
        return array_values($temp);
    }
    
    public static function firstElement($obj)
    {
        if(!empty($obj)){
            foreach($obj as $prop) {
               $first_prop = $prop;
               break; // or exit or whatever exits a foreach loop...
            }
            return $first_prop;
        }
        return false;
    }

}
