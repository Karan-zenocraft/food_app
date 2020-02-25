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
                    $ttt['specialOffers'] = SpecialOffers::getSpecialOffers($ttt['id']);
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
                $restaurantGalleries = $restaurant[0]['restaurantGalleries'];
                if (!empty($restaurantGalleries)) {
                    array_walk($restaurantGalleries, function ($arr) use (&$amResponseData) {
                        $ttt = $arr;
                        $ttt['image_name'] = !empty($ttt['image_name']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurant/" . $ttt['image_name']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurant/" . $ttt['image_name'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                        $amResponseData[] = $ttt;
                        return $amResponseData;
                    });

                    $restaurant[0]['restaurantGalleries'] = $amResponseData;
                }

                $menuCategories = $restaurant[0]['menuCategories'];
                if (!empty($menuCategories)) {
                    array_walk($menuCategories, function ($arr) use (&$amResponseDataCategories) {
                        $ttt = $arr;
                        $restaurantMenus = $ttt['restaurantMenus'];
                        if (!empty($restaurantMenus)) {
                            array_walk($restaurantMenus, function ($arrMenu) use (&$amResponseDataMenu) {
                                $tttMenu = $arrMenu;
                                $tttMenu['photo'] = !empty($tttMenu['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/menus/" . $tttMenu['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/menus/" . $tttMenu['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                                $amResponseDataMenu[] = $tttMenu;
                                return $amResponseDataMenu;
                            });
                            $ttt['restaurantMenus'] = $amResponseDataMenu;
                        }
                        $amResponseDataCategories[] = $ttt;
                        return $amResponseDataCategories;
                    });
                    $restaurant[0]['menuCategories'] = $amResponseDataCategories;
                }

                $amReponseParam = $restaurant;
                $specialOffers = SpecialOffers::getSpecialOffers($requestParam['restaurant_id']);
                if (!empty($specialOffers)) {
                    array_walk($specialOffers, function ($arr) use (&$amResponseDataOffers) {
                        $ttt = $arr;
                        $ttt['photo'] = !empty($ttt['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurants_offers/" . $ttt['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurants_offers/" . $ttt['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                        $amResponseDataOffers[] = $ttt;
                        return $amResponseDataOffers;
                    });

                    $amReponseParam['specialOffers'] = $amResponseDataOffers;
                }
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
                $amReponseParam = [];
                $ssMessage = 'Restaurant not found.';
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
