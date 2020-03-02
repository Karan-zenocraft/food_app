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
class SpecialOffersController extends \yii\base\Controller
{
    public function actionGetSpecialOffersList()
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
            if (!empty($requestParam['date'])) {
                $SpecialOffersList = SpecialOffers::find()->where("'" . $requestParam['date'] . "'" . " BETWEEN from_date AND to_date")->asArray()->all();
            } else {
                $SpecialOffersList = SpecialOffers::find()->where("NOW() BETWEEN from_date AND to_date")->asArray()->all();
            }

            if (!empty($SpecialOffersList)) {
                $amReponseParam = $SpecialOffersList;
                array_walk($SpecialOffersList, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['photo'] = !empty($ttt['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurants_offers/" . $ttt['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurants_offers/" . $ttt['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                    $restaurantIds = explode(",", $ttt['restaurant_id']);
                    $restaurantNames = Restaurants::getRestaurantNamesWithId($ttt['restaurant_id']);
                    unset($ttt['restaurant_id']);
                    unset($ttt['created_at']);
                    unset($ttt['updated_at']);
                    $ttt['restaurants'] = $restaurantNames;
                    $amResponseData[] = $ttt;

                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
                $ssMessage = 'Special Offers List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $amReponseParam = [];
                $ssMessage = 'Special Offers not found.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}
