<?php

namespace common\models\base;

use common\models\Users;
use Yii;

/**
 * This is the model class for table "withdraw_details".
 *
 * @property integer $id
 * @property integer $user_id
 * @property double $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 */
class WithdrawDetailsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'withdraw_details';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'created_at', 'updated_at'], 'required'],
            [['user_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'transfer_id'], 'safe'],
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
            'amount' => 'Amount',
            'transfer_id' => 'Transfer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
