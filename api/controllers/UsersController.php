<?php

namespace api\controllers;

use common\components\Common;
use common\models\DeviceDetails;
use common\models\EmailFormat;
use common\models\UserAddress;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;
use \yii\web\UploadedFile;

/**
 * MainController implements the CRUD actions for APIs.
 */
class UsersController extends \yii\base\Controller
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
        $amRequiredParams = array('login_type');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        $requestParam = $amData['request_param'];
        if ($requestParam['login_type'] == "1") {
            $amRequiredParams = array('email', 'password', 'device_id', 'login_type', 'device_type');
            $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

            // If any getting error in request paramter then set error message.
            if (!empty($amParamsResult['error'])) {
                $amResponse = Common::errorResponse($amParamsResult['error']);
                Common::encodeResponseJSON($amResponse);
            }

            if (($model = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password'])])) !== null) {

                if (($modell = Users::findOne(['email' => $requestParam['email'], 'password' => md5($requestParam['password']), 'role_id' => [Yii::$app->params['userroles']['super_admin'], Yii::$app->params['userroles']['admin'], Yii::$app->params['userroles']['delivery_boy']]])) !== null) {
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
                    $amReponseParam['role'] = $model->role_id;
                    $amReponseParam['user_name'] = $model->user_name;
                    $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                    $amReponseParam['photo'] = !empty($model->photo) && file_exists(Yii::getAlias('@root') . '/' . "uploads/" . $model->photo) ? Yii::$app->params['root_url'] . '/' . "uploads/" . $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                    $amReponseParam['device_token'] = $device_model->device_tocken;
                    $amReponseParam['device_type'] = $device_model->type;
                    $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                    $amReponseParam['auth_token'] = $ssAuthToken;
                    $amReponseParam['login_type'] = $model->login_type;
                    $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
                }
            } else {
                $ssMessage = 'Invalid email OR password.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $amRequiredParams = array('email', 'device_id', 'login_type', 'photo', 'user_name', 'device_type');
            $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

            // If any getting error in request paramter then set error message.
            if (!empty($amParamsResult['error'])) {
                $amResponse = Common::errorResponse($amParamsResult['error']);
                Common::encodeResponseJSON($amResponse);
            }
            if (($model = Users::findOne(['email' => $requestParam['email']])) !== null) {
                if ($model->login_type == $requestParam['login_type']) {
                    if (($modell = Users::findOne(['email' => $requestParam['email'], 'role_id' => [Yii::$app->params['userroles']['super_admin'], Yii::$app->params['userroles']['admin']]])) !== null) {
                        $ssMessage = ' You are not authorize to login.';
                        $amResponse = Common::errorResponse($ssMessage);
                    } else if (($model1 = Users::findOne(['email' => $requestParam['email'], 'status' => "0"])) !== null) {
                        $ssMessage = ' User has been deactivated. Please contact admin.';
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
                        $amReponseParam['role'] = $model->role_id;
                        $amReponseParam['user_name'] = $model->user_name;
                        $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                        $amReponseParam['photo'] = !empty($model->photo) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                        $amReponseParam['device_token'] = $device_model->device_tocken;
                        $amReponseParam['device_type'] = $device_model->type;
                        $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                        $amReponseParam['auth_token'] = $ssAuthToken;
                        $amReponseParam['login_type'] = $model->login_type;

                        $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
                    }
                } else {
                    $model->login_type = $requestParam['login_type'];
                    $model->photo = $requestParam['photo'];
                    $model->role_id = Yii::$app->params['userroles']['customer'];
                    $model->user_name = $requestParam['user_name'];
                    $ssAuthToken = Common::generateToken($model->id);
                    $model->auth_token = $ssAuthToken;
                    $model->save(false);
                    if (($device_model = DeviceDetails::findOne(['type' => "1", 'user_id' => $model->id])) === null) {
                        $device_model = new DeviceDetails();
                    }
                    $device_model->setAttributes($amData['request_param']);
                    $device_model->device_tocken = $requestParam['device_id'];
                    $device_model->type = $requestParam['device_type'];
                    $device_model->user_id = $model->id;
                    //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                    $device_model->save(false);
                    $ssMessage = 'successfully login.';
                    $amReponseParam['email'] = $model->email;
                    $amReponseParam['user_id'] = $model->id;
                    $amReponseParam['role'] = $model->role_id;
                    $amReponseParam['user_name'] = $model->user_name;
                    $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                    $amReponseParam['photo'] = !empty($model->photo) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                    $amReponseParam['device_token'] = $device_model->device_tocken;
                    $amReponseParam['device_type'] = $device_model->type;
                    $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                    $amReponseParam['auth_token'] = $ssAuthToken;
                    $amReponseParam['login_type'] = $model->login_type;
                    $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));

                }
            } else {
                $model = new Users();
                $model->email = $requestParam['email'];
                $model->login_type = $requestParam['login_type'];
                $ssAuthToken = Common::generateToken($model->id);
                $model->auth_token = $ssAuthToken;
                $model->role_id = Yii::$app->params['userroles']['customer'];
                $model->user_name = $requestParam['user_name'];
                $model->photo = $requestParam['photo'];
                $model->is_code_verified = 1;
                $model->save(false);
                if (($device_model = DeviceDetails::findOne(['type' => "1", 'user_id' => $model->id])) === null) {
                    $device_model = new DeviceDetails();
                }
                $device_model->setAttributes($amData['request_param']);
                $device_model->device_tocken = $requestParam['device_id'];
                $device_model->type = $requestParam['device_type'];
                $device_model->user_id = $model->id;
                //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                $device_model->save(false);
                $ssMessage = 'successfully login.';
                $amReponseParam['user_id'] = $model->id;
                $amReponseParam['email'] = $model->email;
                $amReponseParam['role'] = $model->role_id;
                $amReponseParam['user_name'] = $model->user_name;
                $amReponseParam['phone'] = !empty($model->phone) ? $model->phone : "";
                $amReponseParam['photo'] = !empty($model->photo) ? $model->photo : Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                $amReponseParam['device_token'] = $device_model->device_tocken;
                $amReponseParam['device_type'] = $device_model->type;
                $amReponseParam['gcm_registration_id'] = !empty($device_model->gcm_id) ? $device_model->gcm_id : "";
                $amReponseParam['auth_token'] = $ssAuthToken;
                $amReponseParam['login_type'] = $model->login_type;
                $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
            }
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
        $model->status = Yii::$app->params['user_status_value']['active'];
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

            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : verifyEmail()
     * Description : email verification
     * Request Params : verification_code,user_id
     * Author : Rutusha Joshi
     */

    public function actionVerifyCode()
    {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array('verification_code', 'user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        $ssCode = $requestParam['verification_code'];

        $modelUsers = Users::findOne(["id" => $snUserId, "verification_code" => $ssCode]);
        if (!empty($modelUsers)) {
            $modelUsers->is_code_verified = 1;
            $modelUsers->save(false);
            $amResponseData = [
                'is_mobile_verified' => '1',
            ];
            $amResponse = Common::successResponse("Code verified successfully.", $amResponseData);
        } else {
            $amResponseData = [
                'is_mobile_verified' => '0',
            ];
            $amResponse = Common::successResponse("Invalid verification code.", $amResponseData);
        }
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : ResendVerificationCode()
     * Description : Re send verification code
     * Request Params : 'user_id', 'phone','country_code'
     * Author : Rutusha Joshi
     */

    public function actionResendVerificationCode()
    {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'phone');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        $ssPhone = $requestParam['phone'];

        $modelUsers = Users::findOne(["id" => $snUserId]);
        if (!empty($modelUsers)) {
            $SnRandomNumber = rand(1111, 9999);
            $Textmessage = "Your verification code is : " . $SnRandomNumber;
            // Common::sendSms( $Textmessage, "$requestParam[phone]" );
            $modelUsers->verification_code = $SnRandomNumber;
            $modelUsers->save(false);
            $amResponseData['Verification_code'] = $modelUsers->verification_code;
            $amResponse = Common::successResponse("Code sent successfully.", $amResponseData);
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : ChangePassword()
     * Description : user can change password
     * Request Params : user_id,old_password, new_password
     * Response Params : success or error message
     * Author : Rutusha Joshi
     */

    public function actionChangePassword()
    {

        $amData = Common::checkRequestType();

        $amResponse = array();
        $ssMessage = '';
        // Check required validation for request parameter.
        $amRequiredParams = array('old_password', 'new_password', 'user_id');

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

        if (($model = Users::findOne(['id' => $requestParam['user_id'], 'password' => md5($requestParam['old_password']), 'status' => '1'])) !== null) {

            $model->password = md5($amData['request_param']['new_password']);
            if ($model->save()) {
                $ssMessage = 'Your password has been changed successfully.';
                $amReponseParam['user_id'] = $model->id;
                $amReponseParam['email'] = $model->email;
                $amResponse = Common::successResponse($ssMessage, array_map('strval', $amReponseParam));
            }
        } else {
            $ssMessage = 'Old Password is wrong';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : ForgotPassword()
     * Description : if user can forgot passord so send password by mail.
     * Request Params : email,auth_token
     * Response Params : success or error message
     * Author : Rutusha Joshi
     */

    public function actionForgotPassword()
    {

        $amData = Common::checkRequestType();
        $amResponse = array();

        $ssMessage = '';
        // Check required validation for request parameter.
        $amRequiredParams = array('email');

        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];

        // Check User Status

        if (($omUsers = Users::findOne(['email' => $requestParam['email'], 'status' => Yii::$app->params['user_status_value']['active']])) !== null) {

            if (!Users::isPasswordResetTokenValid($omUsers->password_reset_token)) {
                $token = Users::generatePasswordResetToken();
                $omUsers->password_reset_token = $token;
                if (!$omUsers->save(false)) {
                    return false;
                }
            }
            $resetLink = Yii::$app->params['root_url'] . "/site/reset-password?token=" . $omUsers->password_reset_token;

            $emailformatemodel = EmailFormat::findOne(["title" => 'reset_password', "status" => '1']);
            if ($emailformatemodel) {

                //create template file
                $AreplaceString = array('{resetLink}' => $resetLink, '{username}' => $omUsers->user_name);
                $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

                //send email for new generated password
                $mail = Common::sendMail($omUsers->email, Yii::$app->params['adminEmail'], $emailformatemodel->subject, $body);
            }
            if ($mail == 1) {
                $amReponseParam['email'] = $omUsers->email;
                $ssMessage = 'Email has been sent successfully please check your email. ';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);
            } else {
                $ssMessage = 'Email could not be sent successfully try again later.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Please enter valid email address which is provided during sign up.';
            $amResponse = Common::errorResponse($ssMessage);
        }

        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function : Logout()
     * Description : Log out
     * Request Params : user_id,auth_token
     * Response Params :
     * Author : Rutusha Joshi
     */

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

}
