<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\DeviceDetails;
use common\models\EmailFormat;
use common\models\NotificationList;
use common\models\OrderMenus;
use common\models\OrderPayment;
use common\models\Orders;
use common\models\Restaurants;
use common\models\UserFavouriteOrders;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class OrdersController extends \yii\base\Controller
{
    public function actionAddOrder()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'total_amount', 'transaction_id', 'payment_type', 'user_address_id', 'special_offer_id', 'discount', 'coupan_code', 'discounted_price', 'amount_with_tax_discount', 'delivery_charges', 'other_charges', 'restaurant_id');
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
            $order = new Orders();
            $order->user_id = $snUserId;
            $order->restaurant_id = $requestParam['restaurant_id'];
            $order->payment_type = $requestParam['payment_type'];
            $order->total_amount = $requestParam['total_amount'];
            $order->status = Yii::$app->params['order_status']['placed'];
            $order->delivery_charges = $requestParam['delivery_charges'];
            $order->other_charges = $requestParam['other_charges'];
            $order->special_offer_id = !empty($requestParam['special_offer_id']) ? $requestParam['special_offer_id'] : "";
            $order->discount = !empty($requestParam['discount']) ? $requestParam['discount'] : 0;
            $order->coupan_code = !empty($requestParam['coupan_code']) ? $requestParam['coupan_code'] : "";
            $order->discounted_price = $requestParam['discounted_price'];
            $order->amount_with_tax_discount = $requestParam['amount_with_tax_discount'];
            $owner_charge = $order->discounted_price * 10 / 100;
            $order->price_to_owner = $order->discounted_price - $owner_charge;
            $order->user_address_id = $requestParam['user_address_id'];

            if ($order->save(false)) {
                $amReponseParam['order'] = $order;
                $orderPayment = new OrderPayment();
                $orderPayment->order_id = $order->id;
                $orderPayment->transaction_id = $requestParam['transaction_id'];
                $amReponseParam['orderPayments'] = $orderPayment;
                if ($orderPayment->save(false)) {
                    if (!empty($requestParam['menus'])) {
                        $menus = $requestParam['menus'];
                        foreach ($menus as $key => $menu) {
                            $menuModel = new OrderMenus();
                            $menuModel->order_id = $order->id;
                            $menuModel->restaurant_id = $requestParam['restaurant_id'];
                            $menuModel->menu_id = $menu['menu_id'];
                            $menuModel->quantity = $menu['quantity'];
                            $menuModel->price = $menu['price'];
                            $menuModel->menu_total = $menu['quantity'] * $menu['price'];
                            $menuModel->save(false);
                            $menusData[] = $menuModel;
                        }
                        $user_id = $requestParam['user_id'];
                        $deviceModel = DeviceDetails::find()->select('device_tocken,type')->where(['user_id' => $user_id])->one();
                        $device_tocken = $deviceModel->device_tocken;
                        $type = $deviceModel->type;
                        $title = "Order Placed successfully";
                        $body = "Your order is " . Yii::$app->params['order_status_value'][$order->status];
                        if ($type == Yii::$app->params['device_type']['android']) {
                            $status = Common::push_notification_android($device_tocken, $title, $body);
                        } else {
                            $status = Common::push_notification_android($device_tocken, $title, $body);
                        }
                        p($status);
                        if ($status) {
                            $NotificationListModel = new NotificationList();
                            $NotificationListModel->user_id = $user_id;
                            $NotificationListModel->title = $title;
                            $NotificationListModel->body = $body;
                            $NotificationListModel->status = 1;
                            $NotificationListModel->save(false);
                        }
                        /*   $account_sid = 'ACdfe15530240f01579a42172bc5261455';
                        $auth_token = 'd4f178d335e105d5196ce2d7fd376d82';*/
                        $restaurant_name = Common::get_name_by_id($requestParam['restaurant_id'], 'Restaurants');
                        /*         if (!empty($model->phone)) {
                        $account_sid = Yii::$app->params['twillio_account_sid'];
                        $auth_token = Yii::$app->params['twillio_auth_token'];
                        $twilio_number = Yii::$app->params['twillio_phone_number'];
                        // $twilio_number = "+12017338576";
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create(
                        // Where to send a text message (your cell phone?)
                        '+91' . $model->phone,
                        array(
                        'from' => $twilio_number,
                        'body' => 'Your order is received.  You can track the order through your app',
                        )
                        );
                        }*/
                        $emailformatemodel = EmailFormat::findOne(["title" => 'order_placed', "status" => '1']);
                        if ($emailformatemodel) {

                            //create template file
                            $AreplaceString = array('{username}' => $model->user_name);

                            $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                            $ssSubject = $emailformatemodel->subject;
                            //send email for new generated password
                            $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);
                            p($ssResponse, 0);

                        }
                        $amReponseParam['orderMenus'] = $menusData;
                        $ssMessage = 'Order has been successfully placed.';
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                    } else {
                        $ssMessage = 'Menus can not br blank.';
                        $amResponse = Common::errorResponse($ssMessage);
                    }

                }
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetOrdersList()
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
            $orderList = Orders::find()->with('orderPayments')->with('orderMenus')->where(['user_id' => $requestParam['user_id']])->asArray()->all();

            if (!empty($orderList)) {
                $favouriteOrders = UserFavouriteOrders::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $favouriteOrders_arr = array_column($favouriteOrders, 'order_id');
                array_walk($orderList, function ($arr) use (&$amResponseData, $favouriteOrders_arr) {
                    $ttt = $arr;
                    $ttt['is_favourite'] = in_array($ttt['id'], $favouriteOrders_arr) ? "true" : "false";
                    $ttt['restaurant_id'] = !empty($ttt['restaurant_id']) ? $ttt['restaurant_id'] : "";
                    $ttt['delivery_person'] = !empty($ttt['delivery_person']) ? $ttt['delivery_person'] : "";
                    $orderMenus = $ttt['orderMenus'];
                    array_walk($orderMenus, function ($arr) use (&$menus, $favouriteOrders_arr) {
                        $ttt = $arr;
                        $restaurant = Restaurants::find()->where(['id' => $ttt['restaurant_id']])->one();
                        $ttt['restaurant_name'] = $restaurant->name;
                        $ttt['restaurant_area'] = $restaurant->area;
                        $ttt['menu_name'] = Common::get_name_by_id($ttt['menu_id'], 'RestaurantMenu');

                        $menus[] = $ttt;
                        return $menus;
                    });
                    $ttt['orderMenus'] = $menus;
                    $ttt['restaurant_name'] = $menus[0]['restaurant_name'];
                    $amResponseData[] = $ttt;
                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
                $ssMessage = 'Orders List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $amReponseParam = [];
                $ssMessage = 'Orders not found';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetOrderDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'order_id');
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
            $orderDetails = Orders::find()->with('orderPayments')->with('orderMenus')->with('userAddress')->where(['user_id' => $requestParam['user_id'], "id" => $requestParam['order_id']])->asArray()->all();
            $favouriteOrders = UserFavouriteOrders::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
            $favouriteOrders_arr = array_column($favouriteOrders, 'order_id');

            if (!empty($orderDetails)) {
                $orderMenus = $orderDetails[0]['orderMenus'];
                $orderDetails[0]['is_favourite'] = in_array($orderDetails[0]['id'], $favouriteOrders_arr) ? "true" : "false";
                array_walk($orderMenus, function ($arr) use (&$menus) {
                    $ttt = $arr;
                    $restaurant = Restaurants::find()->where(['id' => $ttt['restaurant_id']])->one();
                    $ttt['restaurant_name'] = $restaurant->name;
                    $ttt['restaurant_area'] = $restaurant->area;
                    $ttt['menu_name'] = Common::get_name_by_id($ttt['menu_id'], 'RestaurantMenu');
                    $menus[] = $ttt;
                    return $menus;
                });
                $orderDetails[0]['orderMenus'] = $menus;
                $orderDetails[0]['restaurant_name'] = $menus[0]['restaurant_name'];
                $orderDetails[0]['special_offer_id'] = !empty($orderDetails[0]['special_offer_id']) ? $orderDetails[0]['special_offer_id'] : "";
                $orderDetails[0]['restaurant_id'] = !empty($orderDetails[0]['restaurant_id']) ? $orderDetails[0]['restaurant_id'] : "";
                $orderDetails[0]['delivery_person'] = !empty($orderDetails[0]['delivery_person']) ? $orderDetails[0]['delivery_person'] : "";
                $orderDetails[0]['coupan_code'] = !empty($orderDetails[0]['coupan_code']) ? $orderDetails[0]['coupan_code'] : "";
                $amReponseParam = $orderDetails;
                $ssMessage = 'Orders Details';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $amReponseParam = [];
                $ssMessage = 'Order not found.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionAddOrderToFavourite()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'order_id');
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
            $orderVerify = Orders::find()->where(['user_id' => $requestParam['user_id'], "id" => $requestParam['order_id']])->one();

            if (!empty($orderVerify)) {
                $orderFavourite = UserFavouriteOrders::find()->where(['user_id' => $requestParam['user_id'], "order_id" => $requestParam['order_id']])->one();
                if (!empty($orderFavourite)) {
                    $ssMessage = 'This Order is already added to favourite.';
                    $amResponse = Common::errorResponse($ssMessage);
                    Common::encodeResponseJSON($amResponse);
                } else {
                    $favouriteOrder = new UserFavouriteOrders();
                    $favouriteOrder->user_id = $requestParam['user_id'];
                    $favouriteOrder->order_id = $requestParam['order_id'];
                    $favouriteOrder->save(false);
                    $amReponseParam = $favouriteOrder;
                    $ssMessage = 'Order successfully added to favourite.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                }

            } else {
                $amReponseParam = [];
                $ssMessage = 'Order not found.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionRemoveOrderFromFavourite()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'order_id');
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
            $orderVerify = Orders::find()->where(['user_id' => $requestParam['user_id'], "id" => $requestParam['order_id']])->one();

            if (!empty($orderVerify)) {
                $favouriteOrder = UserFavouriteOrders::find()->where(["user_id" => $requestParam['user_id'], "order_id" => $requestParam['order_id']])->one();
                if (!empty($favouriteOrder)) {
                    $favouriteOrder->delete();
                    $amReponseParam = [];
                    $ssMessage = 'Order successfully removed from the favourite.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $amReponseParam = [];
                    $ssMessage = 'Order already removed from the favourite';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                }
            } else {
                $amReponseParam = [];
                $ssMessage = 'Order not found.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetUserFavouriteOrdersList()
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
            $favouriteOrderList = UserFavouriteOrders::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
            if (!empty($favouriteOrderList)) {
                $amReponseParam = $favouriteOrderList;
                $ssMessage = "User's favourite orders List";
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $amReponseParam = [];
                $ssMessage = 'No favourite orders found.';
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
