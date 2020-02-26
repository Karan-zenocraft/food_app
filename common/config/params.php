<?php
return [
    'adminEmail' => 'testingforproject0@gmail.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'site_url' => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'],
    'root_url' => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'] . "/food_app",
    'login_url' => '/food_app/admin/login',
    'frontend_login_url' => '/food_app/login',
    'user.passwordResetTokenExpire' => 3600,
    'userroles' => [
        'super_admin' => '1',
        'admin' => '2',
        'customer' => '3',
        'delivery_boy' => '4',
    ],
    'user_status' => array('1' => 'Active', '0' => 'In-Active'),
    'user_status_value' => array('active' => '1', 'in_active' => '0'),
    'gender' => [
        '1' => 'Female',
        '2' => 'Male',
    ],
    'gender_value' => [
        'female' => '1',
        'male' => '2',
    ],
    'bsVersion' => '4.x',
    'bsDependencyEnabled' => false,
    /*'upload_path' => UPLOAD_PATH,
    'upload_user_image' => UPLOAD_PATH . "profile_pictures" . DS,*/
    'super_admin_role_id' => '1',
    'administrator_role_id' => '2',
    'status' => array('1' => 'Active', '0' => 'In-Active'),
    'payment_type' => [
        'paypal' => '1',
        'stripe' => '2',
    ],
];
