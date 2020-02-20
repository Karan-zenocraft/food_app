<?php

namespace common\models\base;

use Yii;
use common\models\Restaurants;
use common\models\RestaurantMenu;

/**
 * This is the model class for table "menu_categories".
*
    * @property integer $id
    * @property string $name
    * @property string $description
    * @property integer $restaurant_id
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Restaurants $restaurant
            * @property RestaurantMenu[] $restaurantMenus
    */
class MenuCategoriesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'menu_categories';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'restaurant_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
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
    'name' => 'Name',
    'description' => 'Description',
    'restaurant_id' => 'Restaurant ID',
    'status' => 'Status',
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

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantMenus()
    {
    return $this->hasMany(RestaurantMenu::className(), ['menu_category_id' => 'id']);
    }
}