<?php

namespace common\models;
use Yii;

class RestaurantsGallery extends \common\models\base\RestaurantsGalleryBase
{
    public static function tableName()
{
return 'restaurant_gallery';
}
  public function beforeSave($insert) {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_by',$user_id);
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $this->setAttribute('updated_by',$user_id);

        return parent::beforeSave($insert);
    }
/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['image_title', 'image_description'], 'required'],
            [['image_name'], 'image','extensions'=>'jpg, jpeg, gif, png'],
            [['image_description'],'string','max'=>100],
            [['image_name'], 'image', 'skipOnEmpty'=>TRUE, 'extensions'=>'jpg, jpeg, gif, png', 'on'=>'update'],
            [['restaurant_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['image_description'], 'string'],
            [['restaurant_id', 'created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
            [['image_title'], 'string', 'max' => 255],
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
    'image_name' => 'Upload Image',
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