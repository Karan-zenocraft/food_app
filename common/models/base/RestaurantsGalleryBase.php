<?php

namespace common\models\base;

use Yii;
use common\models\Restaurants;

/**
 * This is the model class for table "restaurant_gallery".
*
    * @property integer $id
    * @property integer $restaurant_id
    * @property string $image_title
    * @property string $image_description
    * @property string $image_name
    * @property integer $status
    * @property integer $created_by
    * @property integer $updated_by
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Restaurants $restaurant
    */
class RestaurantsGalleryBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurant_gallery';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['restaurant_id', 'image_title', 'image_description', 'image_name', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['image_description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['image_title', 'image_name'], 'string', 'max' => 255],
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
    'restaurant_id' => 'Restaurant ID',
    'image_title' => 'Image Title',
    'image_description' => 'Image Description',
    'image_name' => 'Image Name',
    'status' => 'Status',
    'created_by' => 'Created By',
    'updated_by' => 'Updated By',
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