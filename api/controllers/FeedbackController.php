<?php

namespace api\controllers;

use common\components\Common;

/* USE COMMON MODELS */
use common\models\Feedbacks;
use common\models\Restaurants;
use common\models\Users;
use Yii;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class FeedbackController extends \yii\base\Controller
{
    public function actionAddFeedback()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'restaurant_id', 'rating', 'review_note');
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
            $modelRestaurant = Restaurants::findOne(["id" => $requestParam['restaurant_id']]);
            if (!empty($modelRestaurant)) {
                $model = Users::findOne(["id" => $snUserId]);
                $feedbackModel = Feedbacks::find()->where(['restaurant_id' => $requestParam['restaurant_id'], "user_id" => $requestParam['user_id']])->one();
                if (empty($feedbackModel)) {
                    $feedback = new Feedbacks();
                    $feedback->user_id = $requestParam['user_id'];
                    $feedback->restaurant_id = $requestParam['restaurant_id'];
                    $feedback->rating = $requestParam['rating'];
                    $feedback->review_note = $requestParam['review_note'];
                    $feedback->save(false);
                    $amReponseParam = $feedback;
                    $ssMessage = 'Feedback added Successfully.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'You already gave feedback on this restaurant.';
                    $amResponse = Common::errorResponse($ssMessage);
                }

            } else {
                $ssMessage = 'Invalid Restaurant.';
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
