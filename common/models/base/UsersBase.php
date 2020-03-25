<?php

namespace common\models;

use common\models\DeviceDetails;
use common\models\DriverDocuments;
use common\models\NotificationList;
use common\models\Restaurants;
use common\models\UserAddress;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int|null $role_id
 * @property string|null $user_name
 * @property string|null $email
 * @property string|null $password
 * @property int|null $age
 * @property int|null $gender
 * @property string|null $photo
 * @property int|null $badge_count
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $restaurant_id
 *
 * @property UserRole $role
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'badge_count', 'status', 'restaurant_id'], 'integer'],
            [['verification_code', 'password_reset_token', 'auth_token'], 'required'],
            [['is_code_verified', 'password_reset_token'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_name', 'email', 'password', 'photo', 'verification_code', 'auth_token'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRoles::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
            'photo' => 'Photo',
            'verification_code' => 'Verification Code',
            'is_code_verified' => 'Is Code Verified',
            'password_reset_token' => 'Password Reset Token',
            'auth_token' => 'Auth Token',
            'badge_count' => 'Badge Count',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'restaurant_id' => 'Restaurant ID',
        ];
    }

    public function getDriverDocuments()
    {
        return $this->hasMany(DriverDocuments::className(), ['user_id' => 'id']);
    }
    public function getRestaurant()
    {
        return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }
    public function getNotificationLists()
    {
        return $this->hasMany(NotificationList::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRole::className(), ['id' => 'role_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceDetails()
    {
        return 'users';
        return $this->hasMany(DeviceDetails::className(), ['user_id' => 'id']);
    }
}
