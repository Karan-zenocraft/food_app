<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Restaurants;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class RestaurantsController extends \yii\base\Controller
{
    public function actionGetRestaurantsList()
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
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurantList = Restaurants::find()->asArray()->all();
            if (!empty($restaurantList)) {
                $amReponseParam = $restaurantList;
                $ssMessage = 'Restaurants List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $ssMessage = 'Restaurants not found.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}