<?php
include_once 'aliyun-php-sdk-core/Config.php';
use Sms\Request\V20160927 as Sms;

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '1';
$mobile = $_REQUEST['mobile'];
switch ($type) {
    case '1':
        $verify = $_REQUEST['verify'];
        $templateCode = "SMS_53515052";
        $paramString = "{\"name\":\"".$mobile."\",\"verify\":\"".$verify."\"}";
        break;
    case '2':
        $date = $_REQUEST['date'];
        $templateCode = "SMS_56685383";
        $paramString = "{\"name\":\"".$mobile."\",\"date\":\"".$date."\"}";
        break;
    case "3":
        $templateCode = "SMS_56575411";
        $paramString = "{\"name\":\"".$mobile."\"}";
        break;
}



//$mobile = '15168202013';
sendSMS($mobile, $templateCode, $paramString);

function sendSMS($mobile, $templateCode, $paramString) {
    $access_key = "LTAI5wQxXRSeK0vE";
    $access_key_secret = "a3O1cIxR7Wt61O6hSobV0hRXiWXxNo";
    $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $access_key, $access_key_secret);
    $client = new DefaultAcsClient($iClientProfile);
    $request = new Sms\SingleSendSmsRequest();
    $request->setSignName("毕设");/*签名名称*/
    $request->setTemplateCode($templateCode);/*模板code*/
    $request->setRecNum($mobile);/*目标手机号*/
    $request->setParamString($paramString);/*模板变量，数字一定要转换为字符串*/
    try {
        $response = $client->getAcsResponse($request);
        $arr = array('Model' => $response->Model, 'RequestId' => $response->RequestId);
        echo json_encode($arr);
    }
    catch (ClientException  $e) {
        $arr = array('errorno' => $e->getErrorCode(), 'errormsg' => $e->getErrorMessage());
        echo json_encode($arr);
    }
    catch (ServerException  $e) {
        $arr = array('errorno' => $e->getErrorCode(), 'errormsg' => $e->getErrorMessage());
        echo json_encode($arr);
    }
}

function dbConnect() {
    $dsn = "mysql:dbname=rentdb;host=localhost";
    $user = "wangjianfeng";
    $password = "051252754231";
    $db = new PDO($dsn, $user, $password);
    return $db;
}