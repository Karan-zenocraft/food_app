<?php

namespace common\models\base;

use common\models\OrderMenus;
use common\models\OrderPayment;
use common\models\UserAddress;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $payment_type
 * @property double $total_amount
 * @property double $delivery_charges
 * @property double $other_charges
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderMenus[] $orderMenuses
 * @property OrderPayment[] $orderPayments
 * @property Users $user
 */
class OrdersBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'orders';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'payment_type', 'delivery_charges', 'other_charges', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['payment_type'], 'string'],
            [['total_amount', 'delivery_charges', 'other_charges'], 'number'],
            [['created_at', 'updated_at', 'user_address_id'], 'safe'],
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
            'user_id' => 'Buyer',
            'payment_type' => 'Payment Type',
            'total_amount' => 'Total Amount',
            'delivery_charges' => 'Delivery Charges',
            'other_charges' => 'Other Charges',
            'status' => 'Status',
            'user_address_id' => 'Shipping Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderMenus()
    {
        return $this->hasMany(OrderMenus::className(), ['order_id' => 'id']);
    }
    public function getUserAddress()
    {
        return $this->hasOne(UserAddress::className(), ['id' => 'user_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderPayments()
    {
        return $this->hasOne(OrderPayment::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
