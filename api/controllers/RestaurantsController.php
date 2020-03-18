<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Feedbacks;
use common\models\Restaurants;
use common\models\SpecialOffers;
use common\models\UserAddress;
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
            if (!empty($requestParam['lat']) && !empty($requestParam['longg'])) {
                $user_latitude = $requestParam['lat'];
                $user_longitude = $requestParam['longg'];
                $radius = 20;

                $query = "select *
                            from restaurants
                            WHERE round(( 3959 * acos( least(1.0,cos( radians(" . $user_latitude . ") ) * cos( radians(lattitude) ) * cos( radians(longitude) - radians(" . $user_longitude . ") ) + sin( radians(" . $user_latitude . ") ) * sin( radians(lattitude))))), 1) < " . $radius . " AND status = " . Yii::$app->params['user_status_value']['active'] . "";
                $restaurantList = Yii::$app->db->createCommand($query)->queryAll();
            } else {
                $restaurantList = Restaurants::find()->asArray()->all();

            }
            if (!empty($restaurantList)) {
                $amReponseParam = $restaurantList;
                array_walk($restaurantList, function ($arr) use (&$amResponseData, $requestParam) {
                    $ttt = $arr;
                    $ttt['photo'] = !empty($ttt['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurants/" . $ttt['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurants/" . $ttt['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                    $ttt['restaurant_type'] = Restaurants::getRestaurantTypes($ttt['restaurant_type'], "type");
                    $ttt['specialOffers'] = SpecialOffers::getSpecialOffers($ttt['id']);
                    $userDefaultAddress = UserAddress::find()->where(['user_id' => $requestParam['user_id'], 'is_default' => "1"])->one();
                    if (!empty($requestParam['lat']) && !empty($requestParam['longg'])) {
                        $lat = $requestParam['lat'];
                        $long = $requestParam['longg'];
                    } else {
                        $lat = $userDefaultAddress['lat'];
                        $long = $userDefaultAddress['long'];
                    }
                    $distance = Common::distance($ttt['lattitude'], $ttt['longitude'], $lat, $long, "K");
                    if ($distance > 20) {
                        $ttt['avg_time'] = "Not available at your location";
                    } else {
                        $time = floor(($distance / 20) * 60);
                        $time2 = $time + 10;
                        $ttt['avg_time'] = $time . "-" . $time2 . " mins";

                    }
                    $ttt['distance'] = $distance;
                    $Feedbacks = Feedbacks::find()->select("AVG(rating) AS rating")->where(["restaurant_id" => $ttt['id']])->asArray()->all();

                    $ttt['feedback_rating'] = !empty($Feedbacks[0]['rating']) ? $Feedbacks[0]['rating'] : "0";
                    $FeedbackCount = Feedbacks::find()->where(["restaurant_id" => $ttt['id']])->count();
                    $ttt['feedback_count'] = !empty($FeedbackCount) ? $FeedbackCount : "0";
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
                $ssMessage = 'Restaurants List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $amReponseParam = [];
                $ssMessage = 'Restaurants not found.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
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

                    $amReponseParam[0]['specialOffers'] = $amResponseDataOffers;
                } else {
                    $amReponseParam[0]['specialOffers'] = [];
                }
                $Feedbacks = Feedbacks::find()->select("AVG(rating) AS rating")->where(["restaurant_id" => $requestParam['restaurant_id']])->asArray()->all();

                $amReponseParam[0]['feedback_rating'] = !empty($Feedbacks[0]['rating']) ? $Feedbacks[0]['rating'] : "0";
                $FeedbackCount = Feedbacks::find()->where(["restaurant_id" => $requestParam['restaurant_id']])->count();
                $amReponseParam[0]['feedback_count'] = !empty($FeedbackCount) ? $FeedbackCount : "0";
                $userDefaultAddress = UserAddress::find()->where(['user_id' => $requestParam['user_id'], 'is_default' => "1"])->one();
                $lat = $userDefaultAddress['lat'];
                $long = $userDefaultAddress['long'];
                $distance = Common::distance($restaurant[0]['lattitude'], $restaurant[0]['longitude'], $lat, $long, "K");
                if ($distance > 20) {
                    $amReponseParam[0]['avg_time'] = "Not available at your location";
                } else {
                    $time = floor(($distance / 20) * 60);
                    $time2 = $time + 10;
                    $amReponseParam[0]['avg_time'] = $time . "-" . $time2 . " mins";

                }

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

    public function actionSearchRestaurant()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'search_keyword');
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
            if (!empty($requestParam['search_keyword'])) {
                $search_keyword = $requestParam['search_keyword'];

                $query = "SELECT DISTINCT restaurants.*
                FROM `restaurants`
                LEFT JOIN menu_categories
                ON `restaurants`.id=`menu_categories`.restaurant_id
                LEFT JOIN restaurant_menu
                ON `restaurants`.id=`restaurant_menu`.restaurant_id
                WHERE `restaurants`.name LIKE '%" . $search_keyword . "%' OR `restaurant_menu`.name LIKE '%" . $search_keyword . "%' OR `menu_categories`.name LIKE '%" . $search_keyword . "%'";
                $restaurantList = Yii::$app->db->createCommand($query)->queryAll();

                if (!empty($restaurantList)) {
                    $amReponseParam = $restaurantList;
                    array_walk($restaurantList, function ($arr) use (&$amResponseData, $requestParam) {
                        $ttt = $arr;
                        $ttt['photo'] = !empty($ttt['photo']) && file_exists(Yii::getAlias('@root') . '/' . "uploads/restaurants/" . $ttt['photo']) ? Yii::$app->params['root_url'] . '/' . "uploads/restaurants/" . $ttt['photo'] : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                        $ttt['restaurant_type'] = Restaurants::getRestaurantTypes($ttt['restaurant_type'], "type");
                        $ttt['specialOffers'] = SpecialOffers::getSpecialOffers($ttt['id']);
                        $userDefaultAddress = UserAddress::find()->where(['user_id' => $requestParam['user_id'], 'is_default' => "1"])->one();
                        $lat = $userDefaultAddress['lat'];
                        $long = $userDefaultAddress['long'];
                        $distance = Common::distance($ttt['lattitude'], $ttt['longitude'], $lat, $long, "K");
                        if ($distance > 20) {
                            $ttt['avg_time'] = "Not available at your location";
                        } else {
                            $time = floor(($distance / 20) * 60);
                            $time2 = $time + 10;
                            $ttt['avg_time'] = $time . "-" . $time2 . " mins";

                        }
                        $Feedbacks = Feedbacks::find()->select("AVG(rating) AS rating")->where(["restaurant_id" => $ttt['id']])->asArray()->all();

                        $ttt['feedback_rating'] = !empty($Feedbacks[0]['rating']) ? $Feedbacks[0]['rating'] : "0";
                        $FeedbackCount = Feedbacks::find()->where(["restaurant_id" => $ttt['id']])->count();
                        $ttt['feedback_count'] = !empty($FeedbackCount) ? $FeedbackCount : "0";
                        $amResponseData[] = $ttt;
                        return $amResponseData;
                    });
                    $amReponseParam = $amResponseData;
                    $ssMessage = 'Restaurants List';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                } else {
                    $amReponseParam = [];
                    $ssMessage = 'Restaurants not found.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                }
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}
