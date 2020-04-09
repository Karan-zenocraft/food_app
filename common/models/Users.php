<?php

namespace common\models;

use common\models\UserRoles;
use Yii;
use yii\web\IdentityInterface;

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
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
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
            // [['role_id', 'status', 'restaurant_id', 'phone', 'login_type'], 'integer'],
            [['phone'], 'integer'],
            [['role_id', 'user_name', 'email', 'status', 'password'], 'required'],
            [['restaurant_id'], 'required', 'when' => function ($model) {
                return $model->role_id == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('#users-role_id').val() == 2;
            }", ],
            [['email'], 'email'],
            ['user_name', 'validateUserName'],
            ['email', 'validateEmail'],
            [['created_at', 'updated_at', 'is_code_verified', 'password_reset_token', 'badge_count', 'auth_token', 'verification_code', 'wallet'], 'safe'],
            [['photo'], 'image', 'extensions' => 'jpg, jpeg, gif, png'],
            [['user_name', 'email', 'password'], 'string', 'max' => 255],
            //[['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRoles::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role',
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
            'restaurant_id' => 'Restaurant',
            'phone' => 'Contact No',
            'login_type' => 'Login Type',
            'wallet' => 'Wallet',
        ];
    }
    public function validateEmail()
    {
        $ASvalidateemail = Users::find()->where('email = "' . $this->email . '" and id != "' . $this->id . '"')->all();
        if (!empty($ASvalidateemail)) {
            $this->addError('email', 'This email is already registered.');
            return true;
        }
    }
    public function validateUserName()
    {
        $validateName = Users::find()->where('user_name = "' . $this->user_name . '" and id != "' . $this->id . '"')->all();
        if (!empty($validateName)) {
            $this->addError('user_name', 'This user name is already registered.');
            return true;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRoles::className(), ['id' => 'role_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return true;
        //return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->verification_code = bin2hex(random_bytes(32));
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $user = new \common\models\Users();
        $user->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        return $user->password_reset_token;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
}
