<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "deliveryboy_account_details".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $stripe_bank_account_holder_name
 * @property string $stripe_bank_account_holder_type
 * @property integer $stripe_bank_routing_number
 * @property integer $stripe_bank_account_number
 * @property string $stripe_bank_token
 * @property string $stripe_connect_account_id
 * @property string $stripe_bank_accout_id
 * @property string $created_at
 * @property string $updated_at
 */
class UserAccountDetailsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'deliveryboy_account_details';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_routing_number', 'stripe_bank_account_number', 'stripe_bank_token', 'stripe_connect_account_id', 'stripe_bank_accout_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'stripe_bank_routing_number', 'stripe_bank_account_number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_token', 'stripe_connect_account_id', 'stripe_bank_accout_id'], 'string', 'max' => 255],
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
            'stripe_bank_account_holder_name' => 'Stripe Bank Account Holder Name',
            'stripe_bank_account_holder_type' => 'Stripe Bank Account Holder Type',
            'stripe_bank_routing_number' => 'Stripe Bank Routing Number',
            'stripe_bank_account_number' => 'Stripe Bank Account Number',
            'stripe_bank_token' => 'Stripe Bank Token',
            'stripe_connect_account_id' => 'Stripe Connect Account ID',
            'stripe_bank_accout_id' => 'Stripe Bank Accout ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
