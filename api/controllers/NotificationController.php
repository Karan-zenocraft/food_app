<?php

namespace api\controllers;

use common\components\Common;
use common\models\NotificationList;

/* USE COMMON MODELS */
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class NotificationController extends \yii\base\Controller
{
    public function actionGetNotificationList()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne($snUserId);
        if (!empty($model)) {
            $notificationList = NotificationList::find()->where(["user_id" => $requestParam['user_id']])->asArray()->All();
            if (!empty($notificationList)) {
                $ssMessage = 'Notifications List';
                $amReponseParam = $notificationList;
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Notifications not found';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionSendSms()
    {
        /* $apiKey = urlencode('1pH+bl8dd8c-5GhsZPbi0vBZduovN5BiucRuBUWqhe');

        // Message details
        $numbers = urlencode('917405678817');
        $sender = urlencode('TXTLCL');
        $message = rawurlencode('this is text local test message');

        // Prepare data for POST request
        $data = 'apikey=' . $apiKey . '&numbers=' . $numbers . "&sender=" . $sender . "&message=" . $message;

        // Send the GET request with cURL
        $ch = curl_init('https://api.textlocal.in/send/?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        echo $response;*/
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://messagebird-sms-gateway.p.rapidapi.com/sms?username=rutusha.joshi&password=Zenocraft%2540123",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "type=normal&dlr_url=http%3A%2F%2Fwww.example.com%2Fdlr-messagebird.php&timestamp=201308020025&reference=268431687&sender=MessageBird&destination=917405678817%2C919033409265&body=Test%20Message%20MessageBird",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "x-rapidapi-host: messagebird-sms-gateway.p.rapidapi.com",
                "x-rapidapi-key: a70bdbffe4msha97c1400836f3bfp14daadjsn946c326ef109",
            ),
        ));

        $response = curl_exec($curl);
        //p($response);
        $err = curl_error($curl);
        p($err);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
