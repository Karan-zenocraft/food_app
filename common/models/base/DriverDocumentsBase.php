<?php

namespace common\models\base;

use Yii;
use common\models\Users;

/**
 * This is the model class for table "driver_documents".
*
    * @property integer $id
    * @property integer $user_id
    * @property string $document_photo
    * @property string $document_photo_url
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Users $user
    */
class DriverDocumentsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'driver_documents';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'document_photo', 'document_photo_url', 'created_at', 'updated_at'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['document_photo', 'document_photo_url'], 'string', 'max' => 255],
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
    'document_photo' => 'Document Photo',
    'document_photo_url' => 'Document Photo Url',
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