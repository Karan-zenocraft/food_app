<?php

namespace common\models\base;

use Yii;
use common\models\Users;

/**
 * This is the model class for table "user_address".
*
    * @property integer $id
    * @property integer $user_id
    * @property string $address
    * @property double $lat
    * @property double $longg
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
            [['user_id', 'address', 'lat', 'longg'], 'required'],
            [['user_id'], 'integer'],
            [['address'], 'string'],
            [['lat', 'longg'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
    'lat' => 'Lat',
    'longg' => 'Longg',
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
     * @return UserAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAddressQuery(get_called_class());
}
}