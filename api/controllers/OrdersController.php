<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\OrderMenus;
use common\models\OrderPayment;
use common\models\Orders;
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
        $amRequiredParams = array('user_id', 'total_amount', 'transaction_id', 'payment_type');
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
            $order->payment_type = $requestParam['payment_type'];
            $order->total_amount = $requestParam['total_amount'];
            $order->status = Yii::$app->params['order_status']['placed'];
            $order->delivery_charges = $requestParam['delivery_charges'];
            $order->other_charges = $requestParam['other_charges'];

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
                        $amReponseParam['orderMenus'] = $menusData;
                        $ssMessage = 'Order has been successfully placed.';
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                    } else {
                        $ssMessage = 'menus can not br blank.';
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

                $amReponseParam = $orderList;
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
}
