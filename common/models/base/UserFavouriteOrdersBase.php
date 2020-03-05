<?php

namespace common\models\base;

use Yii;
use common\models\Orders;
use common\models\Users;

/**
 * This is the model class for table "user_favourite_orders".
*
    * @property integer $id
    * @property integer $user_id
    * @property integer $order_id
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Orders $order
            * @property Users $user
    */
class UserFavouriteOrdersBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'user_favourite_orders';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'order_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'order_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'user_id' => 'User ID',
    'order_id' => 'Order ID',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrder()
    {
    return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}