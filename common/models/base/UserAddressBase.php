<?php

namespace common\models\base;

use common\models\UserAddressQuery;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $address_type
 * @property string $is_default
 * @property string $area
 * @property double $lat
 * @property double $long
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 */
class UserAddressBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'user_address';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['address', 'is_default'], 'string'],
            [['lat', 'long'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['address_type', 'area'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'address_type' => 'Address Type',
            'is_default' => 'Is Default',
            'area' => 'Area',
            'lat' => 'Lattitude',
            'long' => 'Longitude',
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

    /**
     * @inheritdoc
     * @return \app\models\UserAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\UserAddressQuery(get_called_class());
    }
}
