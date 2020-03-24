<?php

namespace common\models\base;

use common\models\Restaurants;
use Yii;

/**
 * This is the model class for table "account_details".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property string $paypal_email
 * @property string $stripe_bank_account_holder_name
 * @property string $stripe_bank_account_holder_type
 * @property integer $stripe_bank_routing_number
 * @property integer $stripe_bank_account_number
 * @property string $stripe_bank_token
 * @property string $stripe_connect_account_id
 * @property string $stripe_bank_accout_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Restaurants $restaurant
 */
class AccountDetailsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'account_details';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_routing_number', 'stripe_bank_account_number'], 'required'],
            [['restaurant_id', 'stripe_bank_routing_number', 'stripe_bank_account_number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['paypal_email', 'stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_token', 'stripe_connect_account_id', 'stripe_bank_accout_id'], 'string', 'max' => 255],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Restaurant',
            'paypal_email' => 'Paypal Email',
            'stripe_bank_account_holder_name' => 'Bank Account Holder Name',
            'stripe_bank_account_holder_type' => 'Bank Account Holder Type',
            'stripe_bank_routing_number' => 'Bank Routing Number',
            'stripe_bank_account_number' => 'Bank Account Number',
            'stripe_bank_token' => 'Stripe Bank Token',
            'stripe_connect_account_id' => 'Stripe Connect Account ID',
            'stripe_bank_accout_id' => 'Stripe Bank Accout ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }
}
