<?php
if ($_SERVER['HTTP_HOST'] == "localhost") {

    Yii::setAlias('@common_base', '/food_app/common/');

} else {

    Yii::setAlias('@common_base', '/food_app/common/');
}
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api'); // add api alias
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@root', realpath(dirname(__FILE__) . '/../../'));

//START: site configuration
Yii::setAlias('site_title', 'Food App');
Yii::setAlias('site_footer', 'Food App');
//END: site configuration

//START: BACK-END message

//START: Admin users
Yii::setAlias('admin_user_change_password_msg', 'Your password has been changed successfully !');
Yii::setAlias('admin_user_forget_password_msg', 'E-Mail has been sent with new password successfully !');
//END: Admin user

//START: Email template message
Yii::setAlias('email_template_add_message', 'Template has been added successfully !');
Yii::setAlias('email_template_update_message', 'Template has been updated successfully !');
Yii::setAlias('email_template_delete_message', 'Template has been deleted successfully !');
//END: Email template message

//START: Restaurant message
Yii::setAlias('restaurant_add_message', 'Restaurant has been added successfully !');
Yii::setAlias('restaurant_update_message', 'Restaurant has been updated successfully !');
Yii::setAlias('restaurant_delete_message', 'Restaurant has been deleted successfully !');
//END:  Restaurant message

//START: Sub Categories message
Yii::setAlias('menucategory_add_message', 'menu Category has been added successfully !');
Yii::setAlias('menucategory_update_message', 'menu Category has been updated successfully !');
Yii::setAlias('menucategory_delete_message', 'menu Category has been deleted successfully !');
//END:  Sub Categories message

//START: Sub Categories message
Yii::setAlias('menu_add_message', 'menu has been added successfully !');
Yii::setAlias('menu_update_message', 'menu has been updated successfully !');
Yii::setAlias('menu_delete_message', 'menu has been deleted successfully !');
//END:  Sub Categories message
//START: Restaurant Gallery message
Yii::setAlias('restaurant_gallery_add_message', 'Photo has been added successfully !');
Yii::setAlias('restaurant_gallery_update_message', 'Photo has been updated successfully !');
Yii::setAlias('restaurant_gallery_delete_message', 'Photo has been deleted successfully !');
Yii::setAlias('order_update_message', 'Order has been updated successfully !');

//END:  Restaurant Gallery message
