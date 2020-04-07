<?php

namespace api\controllers;

use common\components\Common;
use common\models\DeviceDetails;
use common\models\DriverDocuments;
use common\models\EmailFormat;
use common\models\Orders;
use common\models\Restaurants;
use common\models\UserAddress;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;
use \yii\web\UploadedFile;

/**
 * MainController implements the CRUD actions for APIs.
 */
class DeliveryboyController extends \yii\base\Controller
{
    /*
     * Function : Login()
     * Description : The Restaurant's manager can login from application.
     * Request Params :Email address and password.
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionLogin()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];
        // Check required validation for request parameter.
        $requestParam = $amData['request_param'];

        $amRequiredParams = array('email', 'password', 'device_id', 'login_type', 'device_type');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        if (($model = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password'])])) !== null) {

            if (($modell = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'role_id' => [Yii::$app->params['userroles']['super_admin'], Yii::$app->params['userroles']['admin'], Yii::$app->params['userroles']['customer']]])) !== null) {
                $ssMessage = ' You are not authorize to login.';
                $amResponse = Common::errorResponse($ssMessage);
            } else if (($model1 = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'status' => "0"])) !== null) {
                $ssMessage = ' User has been deactivated. Please contact admin.';
                $amResponse = Common::errorResponse($ssMessage);
            } else if (($model2 = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'is_code_verified' => "0"])) !== null) {
                $ssMessage = ' Your Email is not verified.Please check your inbox to verify email';
                $amResponse = Common::errorResponse($ssMessage);
            } else {
                if (($device_model = DeviceDetails::findOne(['type' => "1", 'user_id' => $model->id])) === null) {
                    $device_model = new DeviceDetails();
                }

                $device_model->setAttributes($amData['request_param']);
                $device_model->device_tocken = $requestParam['device_id'];
                $device_model->type = $requestParam['device_type'];
                $device_model->user_id = $model->id;
                //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                $device_model->save(false);
                $ssAuthToken = Common::generateToken($model->id);
                $model->auth_token = $ssAuthToken;
                $model->save(false);

                $ssMessage = 'successfully login.';
                $amReponseParam['email'] = $model->email;
                $amReponseParam['user_id'] = $model->id;
                $amReponseParam['role'] = "$model->role_id";
                $amReponseParam['user_name'] = $model->user_name;
                $amReponseParam['phone'] = !empty($model->phone) ? "$model->phone" : "";
                $amReponseParam['photo'] = !empty($model->photo) && file_exists(Yii::getAlias('@root') . '/' . "uploads/" . $model->photo) ? Yii::$app->params['root_url'] . '/' . "uploads/" . $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                $amReponseParam['device_token'] = $device_model->device_tocken;
                $amReponseParam['device_type'] = $device_model->type;
                $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                $amReponseParam['auth_token'] = $ssAuthToken;
                $amReponseParam['login_type'] = $model->login_type;
                $amReponseParam['documents'] = DriverDocuments::find()->where(['user_id' => $model->id])->asArray()->all();
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid email OR password.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : SignUp()
     * Description : new user singup.
     * Request Params : irst_name,last_name,email address,contact_no
     * Response Params : user_id,firstname,email,last_name, email,status
     * Author : Rutusha Joshi
     */

    public function actionSignUp()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('role', 'user_name', 'email', 'password', 'device_id', 'device_type', 'phone');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        if (empty($requestParam['user_id'])) {
            if (!empty(Users::find()->where(["email" => $requestParam['email']])->one())) {
                $amResponse = Common::errorResponse("This Email id is already registered.");
                Common::encodeResponseJSON($amResponse);
            }
            if (!empty(Users::find()->where(["phone" => $requestParam['phone']])->one())) {
                $amResponse = Common::errorResponse("Phone you entered is already registered by other user.");
                Common::encodeResponseJSON($amResponse);
            }
            if (!empty(Users::find()->where(["user_name" => $requestParam['user_name']])->one())) {
                $amResponse = Common::errorResponse("This user name is not avalaible.Please try another user name");
                Common::encodeResponseJSON($amResponse);
            }
            $model = new Users();
            $model->login_type = 1;
        } else {
            $snUserId = $requestParam['user_id'];
            $model = Users::findOne(["id" => $snUserId]);
            if (!empty($model)) {
                $ssEmail = $model->email;
                $modelUser = Users::find()->where("id != '" . $snUserId . "' AND email = '" . $requestParam['email'] . "'")->all();
                if (!empty($modelUser)) {
                    $amResponse = Common::errorResponse("Email you entered is already registred by other user.");
                    Common::encodeResponseJSON($amResponse);
                }
                $modelUserr = Users::find()->where("id != '" . $snUserId . "' AND phone = '" . $requestParam['phone'] . "'")->all();
                if (!empty($modelUserr)) {
                    $amResponse = Common::errorResponse("Phone you entered is already registered by other user.");
                    Common::encodeResponseJSON($amResponse);
                }
                $modelUserr = Users::find()->where("id != '" . $snUserId . "' AND user_name = '" . $requestParam['user_name'] . "'")->all();
                if (!empty($modelUserr)) {
                    $amResponse = Common::errorResponse("This user name is not avalaible.Please try another user name");
                    Common::encodeResponseJSON($amResponse);
                }
            }
        }
        // Common::sendSms( $Textmessage, "$requestParam[phone]" );
        // Database field
        $model->user_name = $requestParam['user_name'];
        $model->email = $requestParam['email'];
        $amReponseParam['login_type'] = $model->login_type;
        $model->password = md5($requestParam['password']);
        /* $model->address_line_1 = !empty($requestParam['address_line_1']) ? $requestParam['address_line_1'] : "";*/
        $model->phone = !empty($requestParam['phone']) ? Common::clean_special_characters($requestParam['phone']) : "";
        $model->role_id = $requestParam['role'];
        $model->status = Yii::$app->params['user_status_value']['in_active'];
        $ssAuthToken = Common::generateToken($model->id);
        $model->auth_token = $ssAuthToken;
        $model->generateAuthKey();
        Yii::$app->urlManager->createUrl(['site/email-verify', 'verify' => base64_encode($model->verification_code), 'e' => base64_encode($model->email)]);
        $email_verify_link = Yii::$app->params['root_url'] . '/site/email-verify?verify=' . base64_encode($model->verification_code) . '&e=' . base64_encode($model->email);

        if (isset($requestFileparam['photo']['name'])) {

            $model->photo = UploadedFile::getInstanceByName('photo');
            $Modifier = md5(($model->photo));
            $OriginalModifier = $Modifier . rand(11111, 99999);
            $Extension = $model->photo->extension;
            $model->photo->saveAs(__DIR__ . "../../../uploads/" . $OriginalModifier . '.' . $model->photo->extension);
            $model->photo = $OriginalModifier . '.' . $Extension;
        }
        if ($model->save(false)) {
            if (isset($requestFileparam['documents']['name'])) {
                foreach ($requestFileparam['documents']['name'] as $key => $name) {
                    $documentModel = new DriverDocuments();
                    $documentModel->document_photo = UploadedFile::getInstanceByName("documents[$key]");
                    $documentModel->user_id = $model->id;

                    $Modifier = md5(($documentModel->document_photo));
                    $OriginalModifier = $Modifier . rand(11111, 99999);
                    $Extension = $documentModel->document_photo->extension;
                    $documentModel->document_photo->saveAs(__DIR__ . "../../../uploads/documents/" . $OriginalModifier . '.' . $documentModel->document_photo->extension);
                    $filename = $OriginalModifier . '.' . $Extension;
                    $documentModel->document_photo = $filename;
                    //$documentModel->document_name =
                    $documentModel->document_photo_url = Yii::$app->params['root_url'] . '/' . "uploads/documents/" . $filename;
                    $documentModel->save(false);
                    $documentsPhotos[] = $documentModel;
                }
            }
            // Device Registration
            if (($device_model = Devicedetails::findOne([/*'gcm_id' => $amData['request_param']['gcm_registration_id'], */'user_id' => $model->id])) === null) {
                $device_model = new Devicedetails();
            }

            $device_model->setAttributes($amData['request_param']);
            $device_model->device_tocken = $requestParam['device_id'];
            $device_model->type = $requestParam['device_type'];
            $device_model->gcm_id = !empty($requestParam['gcm_registration_id']) ? $requestParam['gcm_registration_id'] : "";
            $device_model->user_id = $model->id;
            $device_model->save(false);

            ///////////////////////////////////////////////////////////
            //Get email template from database for sign up WS
            ///////////////////////////////////////////////////////////
            if (empty($ssEmail)) {
                $ssEmail = $model->email;
            }
            if (empty($requestParam['user_id']) || ($ssEmail != $requestParam['email'])) {
                $emailformatemodel = EmailFormat::findOne(["title" => 'user_registration', "status" => '1']);
                if ($emailformatemodel) {

                    //create template file
                    $AreplaceString = array('{password}' => $requestParam['password'], '{username}' => $model->user_name, '{email}' => $model->email, '{email_verify_link}' => $email_verify_link);

                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                    $ssSubject = $emailformatemodel->subject;
                    //send email for new generated password
                    $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                }
            }

            $ssMessage = 'You are successfully registered.';
            $amReponseParam['email'] = $model->email;
            $amReponseParam['user_id'] = $model->id;
            $amReponseParam['role'] = $model->role_id;
            $amReponseParam['user_name'] = $model->user_name;
            $amReponseParam['phone'] = $model->phone;
            $amReponseParam['photo'] = !empty($model->photo) && file_exists(Yii::getAlias('@root') . '/' . "uploads/" . $model->photo) ? Yii::$app->params['root_url'] . '/' . "uploads/" . $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
            $amReponseParam['device_token'] = $device_model->device_tocken;
            $amReponseParam['device_type'] = $device_model->type;
            $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
            $amReponseParam['auth_token'] = $ssAuthToken;
            if (isset($requestFileparam['documents']) && isset($requestFileparam['documents']['name'])) {
                $amReponseParam['documents'] = $documentsPhotos;
            }
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : AddAddress()
     * Description : Add address
     * Request Params :user_id,address
     * Response Params :
     * Author : Rutusha Joshi
     */

    public function actionAddAddress()
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
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            if (!empty($requestParam['address'])) {
                $addresses = $requestParam['address'];
                $address = $addresses[0];
                $amRequiredParamsAdd = array('address', 'area', 'lat', 'long', 'address_type');
                $amParamsResult = Common::checkRequestParameterKey($address, $amRequiredParamsAdd);
                // If any getting error in request paramter then set error message.
                if (!empty($amParamsResult['error'])) {
                    $amResponse = Common::errorResponse($amParamsResult['error']);
                    Common::encodeResponseJSON($amResponse);
                }
                if (isset($address['id']) && !empty($address['id'])) {
                    $addressModel = UserAddress::findOne($address['id']);
                    if (!empty($addressModel)) {
                        $addressModel->user_id = $requestParam['user_id'];
                        $addressModel->address = $address['address'];
                        $addressModel->area = $address['area'];
                        $addressModel->lat = $address['lat'];
                        $addressModel->long = $address['long'];
                        $addressModel->address_type = $address['address_type'];
                        $addressModel->save(false);
                    } else {
                        $ssMessage = 'Invalid Address id.';
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);
                    }
                } else {
                    $useraddresses = UserAddress::updateAll(['is_default' => '0'], ['user_id' => $requestParam['user_id']]);
                    $addressModel = new UserAddress();
                    $addressModel->user_id = $requestParam['user_id'];
                    $addressModel->address = $address['address'];
                    $addressModel->area = $address['area'];
                    $addressModel->lat = $address['lat'];
                    $addressModel->long = $address['long'];
                    $addressModel->is_default = 1;
                    $addressModel->address_type = $address['address_type'];
                    $addressModel->save(false);
                }

                $response = UserAddress::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $ssMessage = 'Your address has been added successfully.';
                $amReponseParam = $response;
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $response = UserAddress::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $ssMessage = 'Address List';
                $amReponseParam = $response;
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : GetUserDetails()
     * Description : Get User Details
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionSetDefaultAddress()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'address_id');
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
            // Device Registration
            $addressModel = UserAddress::find()->where(['id' => $requestParam['address_id'], "user_id" => $requestParam['user_id']])->one();
            if (!empty($addressModel)) {
                $useraddresses = UserAddress::updateAll(['is_default' => '0'], ['user_id' => $requestParam['user_id']]);
                $addressModel->is_default = 1;
                $addressModel->save(false);
                $amReponseParam = UserAddress::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $ssMessage = 'Default address successfully updated.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $ssMessage = 'Invalid address id.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : DeleteAddress()
     * Description : Add address
     * Request Params :user_id,address
     * Response Params :
     * Author : Rutusha Joshi
     */

    public function actionDeleteAddress()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $address = UserAddress::findOne($requestParam['id']);
            if (!empty($address)) {
                $address->delete();
                $response = UserAddress::find()->where(['user_id' => $requestParam['user_id']])->asArray()->all();
                $amReponseParam = $response;
                $ssMessage = 'Your address has been deleted successfully.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid Address id.';
                $amResponse = Common::errorResponse($ssMessage);
            }

        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    /*
     * Function : GetUserDetails()
     * Description : Get User Details
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionGetUserDetails()
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
            // Device Registration
            $ssMessage = 'User Profile Details.';

            $amReponseParam['user_email'] = $model->email;
            $amReponseParam['user_id'] = $model->id;
            $amReponseParam['first_name'] = $model->first_name;
            $amReponseParam['last_name'] = $model->last_name;
            $amReponseParam['address'] = $model->address;
            $amReponseParam['contact_no'] = $model->contact_no;

            $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function :
     * Description : Reset Badge Count
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionResetBadgeCount()
    {

        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');

        $amParamsResult = Common::checkRequiredParams($amData['request_param'], $amRequiredParams);

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
        $oModelUser = Users::findOne($requestParam['user_id']);
        if (!empty($oModelUser)) {

            $oModelUser->badge_count = 0;
            $oModelUser->save(false);
            $ssMessage = "Badge count updated successfully.";
            $amResponse = Common::successResponse($ssMessage);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    public function actionSendNotification()
    {
        $title = "Android Notification title";
        $body = "Android Notification Message";
        $actionSendNotification = Common::push_notification_android("fIWU-c9XH3k:APA91bFqKmvP3_rCb0Z1Kvi7Bqam-Z7hGKnEAP6vUdQ83GmTsV6UF0yeEXFuxdj5vl4o4BPGntfPSwyWG7GYPs69bRMWMV1XyIGjM1c-9b7wRNq198GtdkzHbOZDaYj4mcuEeIfdbW9t", $title, $body);
        p($actionSendNotification);
    }

    public function actionRefreshDeviceToken()
    {

        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'device_token');

        $amParamsResult = Common::checkRequiredParams($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        /*  $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);*/
        $oModelUser = Users::findOne($requestParam['user_id']);
        if (!empty($oModelUser)) {
            $deviceModel = DeviceDetails::find()->where(["user_id" => $requestParam['user_id']])->one();
            $deviceModel->device_tocken = $requestParam['device_token'];
            $deviceModel->save(false);
            $deviceModel->gcm_id = !empty($deviceModel->gcm_id) ? $deviceModel->gcm_id : "";
            $ssMessage = "Device Token updated successfully.";
            $amReponseParam = $deviceModel;
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
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
        $amRequiredParams = array('user_id', 'lat', 'long');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchRole($requestParam['user_id']);
        Common::matchUserStatus($requestParam['user_id']);
        Common::matchDeliveryBoyStatus($requestParam['user_id']);

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        $user_latitude = $requestParam['lat'];
        $user_longitude = $requestParam['long'];
        $radius = 20;
        if (!empty($model)) {

            $orders = Orders::find()->select("orders.id,orders.user_id,orders.restaurant_id,user_address.lat,user_address.long,user_address.address,user_address.area") /*->with(['user' => function ($q) {
            return $q->select("user_name");
            }])->with(['restaurant' => function ($q) {
            return $q->select("name,area,city,address,pincode,lattitude,longitude");
            }])*/    ->leftJoin('user_address', 'orders.user_address_id=user_address.id')
                ->where("round(( 3959 * acos( least(1.0,cos( radians(" . $user_latitude . ") ) * cos( radians(user_address.lat) ) * cos( radians(user_address.long) - radians(" . $user_longitude . ") ) + sin( radians(" . $user_latitude . ") ) * sin( radians(user_address.lat))))), 1) < " . $radius . " AND orders.status=" . Yii::$app->params['order_status']['accepted'] . " AND orders.delivery_person is NULL")->asArray()->all();
            /* with(['userAddress' => function ($q) use ($user_latitude, $user_longitude, $radius) {
            return $q->where("round(( 3959 * acos( least(1.0,cos( radians(" . $user_latitude . ") ) * cos( radians(`lat`) ) * cos( radians(`long`) - radians(" . $user_longitude . ") ) + sin( radians(" . $user_latitude . ") ) * sin( radians(`lat`))))), 1) < " . $radius . "");
            }])->asArray()->all();*/
            if (!empty($orders)) {
                array_walk($orders, function ($arr) use (&$amResponseData) {
                    $ttt = $arr;
                    $ttt['user_name'] = Common::get_user_name($ttt['user_id']);
                    $ttt['user_address'] = $ttt['address'];
                    $ttt['user_area'] = $ttt['area'];
                    $ttt['user_lat'] = $ttt['lat'];
                    $ttt['user_long'] = $ttt['long'];
                    $restaurant = Restaurants::find()->where(['id' => $ttt['restaurant_id']])->one();
                    $ttt['restaurant_name'] = $restaurant->name;
                    $ttt['restaurant_lat'] = $restaurant->lattitude;
                    $ttt['restaurant_long'] = $restaurant->longitude;
                    $ttt['restaurant_area'] = $restaurant->area;
                    $ttt['restaurant_city'] = $restaurant->city;
                    $ttt['restaurant_address'] = $restaurant->address;
                    $ttt['restaurant_pincode'] = $restaurant->pincode;
                    unset($ttt['user_id']);
                    unset($ttt['restaurant_id']);
                    unset($ttt['lat']);
                    unset($ttt['long']);
                    unset($ttt['area']);
                    unset($ttt['address']);
                    $amResponseData[] = $ttt;

                    return $amResponseData;
                });
                $amReponseParam = $amResponseData;
                // Device Registration
                $ssMessage = 'Orders List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $amReponseParam = [];
                // Device Registration
                $ssMessage = 'Orders List';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionUpdateStatus()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'status');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchRole($requestParam['user_id']);
        Common::matchUserStatus($requestParam['user_id']);
        // Common::matchDeliveryBoyStatus($requestParam['user_id']);

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $model->status_delivery_boy = $requestParam['status'];
            $model->save(false);
            $amReponseParam = $model;
            $model->password_reset_token = !empty($model->password_reset_token) ? $model->password_reset_token : "";
            $model->badge_count = !empty($model->badge_count) ? $model->badge_count : "";
            $model->restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            // Device Registration
            $ssMessage = 'Status update successfully';
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionAcceptOrder()
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
        Common::matchRole($requestParam['user_id']);
        Common::matchUserStatus($requestParam['user_id']);

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $order = Orders::find()->where(['id' => $requestParam['order_id']])->one();
            if (!empty($order)) {
                $order->delivery_person = $snUserId;
                $order->save(false);
                $amReponseParam = $order;
                $ssMessage = 'Order accepted successfully';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid Order.';
                $amResponse = Common::successResponse($ssMessage, []);
            }
            // Device Registration
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
        Common::matchRole($requestParam['user_id']);
        Common::matchUserStatus($requestParam['user_id']);

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $order = Orders::find()->with(['user' => function ($q) {
                return $q->select('phone,user_name');
            }])->with('orderMenus')->with(['restaurant' => function ($q) {
                return $q->select('name,lattitude,longitude,area,city,address,pincode');
            }])->with('userAddress')->where(['id' => $requestParam['order_id']])->asArray()->all();
            if (!empty($order)) {
                $order[0]['special_offer_id'] = !empty($order[0]['special_offer_id']) ? $order[0]['special_offer_id'] : "";
                $order[0]['delivery_person'] = !empty($order[0]['delivery_person']) ? $order[0]['delivery_person'] : "";
                $order[0]['user']['phone'] = !empty($order[0]['user']['phone']) ? $order[0]['user']['phone'] : "";
                $amReponseParam = $order;
                $ssMessage = 'Order Details';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid Order.';
                $amResponse = Common::successResponse($ssMessage, []);
            }
            // Device Registration
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionOrderDelivered()
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
        Common::matchRole($requestParam['user_id']);
        Common::matchUserStatus($requestParam['user_id']);

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $order = Orders::find()->where(['delivery_person' => $snUserId, 'id' => $requestParam['order_id']])->one();
            if (!empty($order)) {
                $order->status = Yii::$app->params['order_status']['delievered'];
                $order->save(false);
                $order->special_offer_id = !empty($order->special_offer_id) ? $order->special_offer_id : "";
                $amReponseParam = $order;
                $ssMessage = 'Order status updated to delivered.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid Order.';
                $amResponse = Common::successResponse($ssMessage, []);
            }
            // Device Registration
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    public function actionGetOrderHistory()
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
        Common::matchRole($requestParam['user_id']);
        Common::matchUserStatus($requestParam['user_id']);

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $orders = Orders::find()->select("DATE(created_at) dateOnly")->where(['delivery_person' => $snUserId])->asArray()->groupBy('dateOnly')->all();
            if (!empty($orders)) {
                foreach ($orders as $key => $value) {
                    $getDataDateWise = Orders::find()->where(['DATE(created_at)' => $value['dateOnly'], 'delivery_person' => $requestParam['user_id']])->asArray()->all();
                    $amReponseParam[$key]['date'] = $value['dateOnly'];
                    array_walk($getDataDateWise, function ($arr) use (&$amResponseData) {
                        $ttt = $arr;
                        $ttt['special_offer_id'] = !empty($ttt['special_offer_id']) ? $ttt['special_offer_id'] : "";
                        $amResponseData[] = $ttt;
                        return $amResponseData;
                    });
                }
                $amReponseParam[$key]['datewiseData'] = $amResponseData;
                $ssMessage = 'Order History';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Invalid Order.';
                $amResponse = Common::successResponse($ssMessage, []);
            }
            // Device Registration
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    // For Geting Daily data by date
    public function actionLogout()
    {
        $amData = Common::checkRequestType();
        $amResponse = array();
        $ssMessage = '';
        $amRequiredParams = array('user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);
        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        // Check User Status
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);

        $userModel = Users::findOne(['id' => $requestParam['user_id']]);
        if (!empty($userModel)) {
            if (!empty($amData['request_param']['device_id'])) {
                if (($device_model = Devicedetails::findOne(['device_tocken' => $amData['request_param']['device_id'], 'user_id' => $requestParam['user_id']])) !== null) {
                    $device_model->delete();
                } else {
                    $ssMessage = 'Your deivce token is invalid.';
                    $amResponse = Common::errorResponse($ssMessage);
                }
            }
            $userModel->status_delivery_boy = 0;
            $userModel->auth_token = "";
            $amReponseParam = [];
            $userModel->save(false);
            $ssMessage = 'Logout successfully';
            $amResponse = Common::successResponse($ssMessage, $amReponseParam);

        } else {
            $ssMessage = 'Invalid user_id';
            $amResponse = Common::errorResponse($ssMessage);
        }
        Common::encodeResponseJSON($amResponse);
    }

    public function actionEditProfile()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_name', 'email', 'phone', 'user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model) && ($model->role == Yii::$app->params['userroles']['delivery_boy'])) {
            $modelUser = Users::find()->where("id != '" . $snUserId . "' AND email = '" . $requestParam['email'] . "'")->all();
            if (!empty($modelUser)) {
                $amResponse = Common::errorResponse("Email you entered is already registred by other user.");
                Common::encodeResponseJSON($amResponse);
            }
            $modelUserr = Users::find()->where("id != '" . $snUserId . "' AND phone = '" . $requestParam['phone'] . "'")->all();
            if (!empty($modelUserr)) {
                $amResponse = Common::errorResponse("Phone you entered is already registered by other user.");
                Common::encodeResponseJSON($amResponse);
            }
            $modelUserr = Users::find()->where("id != '" . $snUserId . "' AND user_name = '" . $requestParam['user_name'] . "'")->all();
            if (!empty($modelUserr)) {
                $amResponse = Common::errorResponse("This user name is not avalaible.Please try another user name");
                Common::encodeResponseJSON($amResponse);
            }

            // Common::sendSms( $Textmessage, "$requestParam[phone]" );
            // Database field
            $model->user_name = !empty($requestParam['user_name']) ? $requestParam['user_name'] : $model->user_name;
            $model->email = !empty($requestParam['email']) ? $requestParam['email'] : $model->email;
            $amReponseParam['login_type'] = 1;
            // $model->password = md5($requestParam['password']);
            /* $model->address_line_1 = !empty($requestParam['address_line_1']) ? $requestParam['address_line_1'] : "";*/
            $model->phone = !empty($requestParam['phone']) ? Common::clean_special_characters($requestParam['phone']) : $model->phone;

            if (isset($requestFileparam['photo']['name'])) {

                $model->photo = UploadedFile::getInstanceByName('photo');
                $Modifier = md5(($model->photo));
                $OriginalModifier = $Modifier . rand(11111, 99999);
                $Extension = $model->photo->extension;
                $model->photo->saveAs(__DIR__ . "../../../uploads/" . $OriginalModifier . '.' . $model->photo->extension);
                $model->photo = $OriginalModifier . '.' . $Extension;
            }
            if ($model->save(false)) {
                $device_model = Devicedetails::find()->where(['user_id' => $model->id])->one();

                $ssMessage = 'Your profile has been successfully updated.';
                $amReponseParam['email'] = $model->email;
                $amReponseParam['user_id'] = $model->id;
                $amReponseParam['role'] = $model->role_id;
                $amReponseParam['user_name'] = $model->user_name;
                $amReponseParam['phone'] = $model->phone;
                $amReponseParam['photo'] = !empty($model->photo) && file_exists(Yii::getAlias('@root') . '/' . "uploads/" . $model->photo) ? Yii::$app->params['root_url'] . '/' . "uploads/" . $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                $amReponseParam['device_token'] = $device_model->device_tocken;
                $amReponseParam['device_type'] = $device_model->type;
                $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                $amReponseParam['auth_token'] = $model->auth_token;
                $amReponseParam['documents'] = [];
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            }
        } else {
            $ssMessage = 'Invalid user';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

}
