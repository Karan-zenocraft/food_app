<?php

namespace common\models\base;

use Yii;
use common\models\RestaurantMenu;
use common\models\Orders;
use common\models\Restaurants;

/**
 * This is the model class for table "order_menus".
*
    * @property integer $id
    * @property integer $order_id
    * @property integer $restaurant_id
    * @property integer $menu_id
    * @property integer $quantity
    * @property double $price
    * @property double $menu_total
    * @property string $created_at
    * @property string $updated_at
    *
            * @property RestaurantMenu $menu
            * @property Orders $order
            * @property Restaurants $restaurant
    */
class OrderMenusBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'order_menus';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['order_id', 'restaurant_id', 'menu_id', 'quantity', 'price', 'menu_total', 'created_at', 'updated_at'], 'required'],
            [['order_id', 'restaurant_id', 'menu_id', 'quantity'], 'integer'],
            [['price', 'menu_total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantMenu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
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
    'order_id' => 'Order ID',
    'restaurant_id' => 'Restaurant ID',
    'menu_id' => 'Menu ID',
    'quantity' => 'Quantity',
    'price' => 'Price',
    'menu_total' => 'Menu Total',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMenu()
    {
    return $this->hasOne(RestaurantMenu::className(), ['id' => 'menu_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOrder()
    {
    return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurant()
    {
    return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }
}