<?php

namespace api\controllers;

use common\components\Common;
/* USE COMMON MODELS */
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class PaymentController extends \yii\base\Controller
{
    public function actionCreateClientSecret()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'amount_with_tax_discount');
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
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            \Stripe\Stripe::setApiKey('sk_test_Riw74aG5a5dBFs873VnuZRl600NA1l75zn');

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $requestParam['amount_with_tax_discount'],
                'currency' => 'usd',
            ]);
            $client_secret = $intent->client_secret;
            // Device Registration
            $ssMessage = 'User Profile Details.';

            $amReponseParam['client_secret'] = $client_secret;

            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}
