<?php

namespace common\models\base;

use common\models\MenuCategories;
use common\models\Restaurants;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "restaurant_menu".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property string $name
 * @property string $description
 * @property integer $menu_category_id
 * @property double $price
 * @property string $photo
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $createdBy
 * @property MenuCategories $menuCategory
 * @property Restaurants $restaurant
 * @property Users $updatedBy
 */
class RestaurantMenuBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'restaurant_menu';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['restaurant_id', 'name', 'description', 'menu_category_id', 'price', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'menu_category_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['menu_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategories::className(), 'targetAttribute' => ['menu_category_id' => 'id']],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'name' => 'Name',
            'description' => 'Description',
            'menu_category_id' => 'Menu Category ID',
            'price' => 'Price',
            'photo' => 'Photo',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuCategory()
    {
        return $this->hasOne(MenuCategories::className(), ['id' => 'menu_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }
}
