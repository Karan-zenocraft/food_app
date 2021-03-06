<?php

namespace common\models\base;

use common\models\AccountDetails;
use common\models\Feedbacks;
use common\models\MenuCategories;
use common\models\OrderMenus;
use common\models\Orders;
use common\models\RestaurantMenu;
use common\models\RestaurantsGallery;
use common\models\RestaurantsQuery;
use common\models\RestaurantWorkingHours;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "restaurants".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $restaurant_type
 * @property string $address
 * @property double $lattitude
 * @property double $longitude
 * @property string $website
 * @property integer $contact_no
 * @property string $photo
 * @property integer $avg_cost_for_two
 * @property integer $status
 * @property string $is_deleted
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $email
 *
 * @property MenuCategories[] $menuCategories
 * @property RestaurantGallery[] $restaurantGalleries
 * @property RestaurantMenu[] $restaurantMenus
 * @property RestaurantWorkingHours[] $restaurantWorkingHours
 */
class RestaurantsBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'restaurants';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['name', 'description', 'restaurant_type', 'address', 'lattitude', 'longitude', 'avg_cost_for_two', 'created_by', 'updated_by', 'created_at', 'updated_at', 'email'], 'required'],
            [['description', 'restaurant_type', 'is_deleted'], 'string'],
            [['lattitude', 'longitude'], 'number'],
            [['contact_no', 'avg_cost_for_two', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'website', 'photo', 'email'], 'string', 'max' => 255],
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
            'restaurant_type' => 'Restaurant Type',
            'address' => 'Address',
            'lattitude' => 'Lattitude',
            'longitude' => 'Longitude',
            'website' => 'Website',
            'contact_no' => 'Contact No',
            'photo' => 'Photo',
            'avg_cost_for_two' => 'Avg Cost For Two',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'email' => 'Email',
        ];
    }
    public function getAccountDetails()
    {
        return $this->hasMany(AccountDetails::className(), ['restaurant_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedbacks::className(), ['restaurant_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuCategories()
    {
        return $this->hasMany(MenuCategories::className(), ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantGalleries()
    {
        return $this->hasMany(RestaurantsGallery::className(), ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantMenus()
    {
        return $this->hasMany(RestaurantMenu::className(), ['restaurant_id' => 'id']);
    }
    public function getOrderMenus()
    {
        return $this->hasMany(OrderMenus::className(), ['restaurant_id' => 'id']);
    }
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['restaurant_id' => 'id']);
    }
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['restaurant_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantWorkingHours()
    {
        return $this->hasMany(RestaurantWorkingHours::className(), ['restaurant_id' => 'id']);
    }
    public static function getRestaurantTypes($restaurant_id, $flag)
    {
        if (!empty($flag) && ($flag == "type")) {
            $restaurantTypes = RestaurantType::find()->select('type')->where("id in (" . $restaurant_id . ")")->asArray()->all();
            $values = array_column($restaurantTypes, 'type');
            return implode(",", $values);
        } else {
            $restaurantTypes = RestaurantType::find()->where("id in (" . $restaurant_id . ")")->asArray()->all();
            return $restaurantTypes;
        }
    }
    public static function find()
    {
        return new RestaurantsQuery(get_called_class());
    }
}
