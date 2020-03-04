<?php

namespace common\models\base;

use Yii;
use common\models\Orders;

/**
 * This is the model class for table "order_payment".
*
    * @property integer $id
    * @property integer $order_id
    * @property string $transaction_id
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Orders $order
    */
class OrderPaymentBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'order_payment';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['order_id', 'transaction_id', 'created_at', 'updated_at'], 'required'],
            [['order_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['transaction_id'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'order_id' => 'Order ID',
    'transaction_id' => 'Transaction ID',
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
}