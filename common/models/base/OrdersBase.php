<?php

namespace common\models\base;

use common\models\OrderMenus;
use common\models\OrderPayment;
use common\models\SpecialOffers;
use common\models\UserAddress;
use common\models\UserFavouriteOrders;
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
 * @property integer $special_offer_id
 * @property double $discount
 * @property string $coupan_code
 * @property integer $user_address_id
 * @property double $discounted_price
 * @property double $amount_with_tax_discount
 * @property double $price_to_owner
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderMenus[] $orderMenuses
 * @property OrderPayment[] $orderPayments
 * @property Users $user
 * @property SpecialOffers $specialOffer
 * @property UserFavouriteOrders[] $userFavouriteOrders
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
            [['user_id', 'payment_type', 'delivery_charges', 'other_charges', 'special_offer_id', 'discount', 'coupan_code', 'user_address_id', 'discounted_price', 'amount_with_tax_discount', 'price_to_owner', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'special_offer_id', 'user_address_id', 'status'], 'integer'],
            [['payment_type'], 'string'],
            [['total_amount', 'delivery_charges', 'other_charges', 'discount', 'discounted_price', 'amount_with_tax_discount', 'price_to_owner'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['coupan_code'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['special_offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialOffers::className(), 'targetAttribute' => ['special_offer_id' => 'id']],
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
            'payment_type' => 'Payment Type',
            'total_amount' => 'Total Amount',
            'delivery_charges' => 'Delivery Charges',
            'other_charges' => 'Other Charges',
            'special_offer_id' => 'Special Offer ID',
            'discount' => 'Discount',
            'coupan_code' => 'Coupan Code',
            'user_address_id' => 'User Address ID',
            'discounted_price' => 'Discounted Price',
            'amount_with_tax_discount' => 'Amount With Tax Discount',
            'price_to_owner' => 'Price To Owner',
            'status' => 'Status',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderPayments()
    {
        return $this->hasMany(OrderPayment::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getUserAddress()
    {
        return $this->hasOne(UserAddress::className(), ['id' => 'user_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialOffer()
    {
        return $this->hasOne(SpecialOffers::className(), ['id' => 'special_offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavouriteOrders()
    {
        return $this->hasMany(UserFavouriteOrders::className(), ['order_id' => 'id']);
    }
}
