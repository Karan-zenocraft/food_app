<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Restaurants;
use common\models\SpecialOffers;
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
                array_walk($restaurantList, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['photo'] = !empty($ttt['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurants/" . $ttt['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurants/" . $ttt['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                    $ttt['restaurant_type'] = Restaurants::getRestaurantTypes($ttt['restaurant_type'], "type");
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
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

    public function actionGetRestaurantDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'restaurant_id');
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
            $restaurant = Restaurants::find()->with('restaurantGalleries')->with(['menuCategories' => function ($q) {
                return $q->with('restaurantMenus');
            }])->where(['id' => $requestParam['restaurant_id']])->asArray()->all();

            if (!empty($restaurant)) {
                $amReponseParam = $restaurant;
                $amReponseParam['specialOffers'] = SpecialOffers::getSpecialOffers($requestParam['restaurant_id']);
                /*            array_walk($restaurantList, function ($arr) use (&$amResponseData) {
                $ttt = $arr;
                $ttt['photo'] = !empty($ttt['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurants/" . $ttt['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurants/" . $ttt['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                $ttt['restaurant_type'] = Restaurants::getRestaurantTypes($ttt['restaurant_type'], "type");
                $amResponseData[] = $ttt;
                return $amResponseData;
                });
                $amReponseParam = $amResponseData;*/
                $ssMessage = 'Restaurants Details';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $ssMessage = 'Restaurant not found.';
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
