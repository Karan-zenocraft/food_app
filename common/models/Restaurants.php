<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class Restaurants extends \common\models\base\RestaurantsBase
{
    public function beforeSave($insert)
    {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_by', $user_id);
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $this->setAttribute('updated_by', $user_id);

        return parent::beforeSave($insert);
    }
    public function rules()
    {
        return [
            [['name', 'description', 'restaurant_type', 'address', 'lattitude', 'longitude', 'avg_cost_for_two', 'email'], 'required'],
            [['description'], 'string'],
            [['photo'], 'image', 'extensions' => 'jpg, jpeg, gif, png'],
            [['lattitude', 'longitude'], 'number'],
            [['contact_no', 'avg_cost_for_two', 'status'], 'integer'],
            [['created_at', 'updated_at', 'status', 'restaurant_type', 'created_by', 'updated_by', 'is_deleted'], 'safe'],
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
    public static function getRestaurantNamesWithId($restaurant_id)
    {
        $restaurantNames = Restaurants::find()->select('id,name')->where("id in (" . $restaurant_id . ")")->asArray()->all();
        return $restaurantNames;
    }

    public static function getRestaurantNames($restaurant_id, $flag)
    {
        if (!empty($flag) && ($flag == "name")) {
            $restaurantNames = Restaurants::find()->select('name')->where("id in (" . $restaurant_id . ")")->asArray()->all();
            $values = array_column($restaurantNames, 'name');
            return implode(",", $values);
        } else {
            $restaurantNames = Restaurants::find()->where("id in (" . $restaurant_id . ")")->asArray()->all();
            return $restaurantNames;
        }
    }
    public static function RestaurantsDropdown()
    {
        $restaurants = ArrayHelper::map(Restaurants::find()->orderBy('name')->asArray()->all(), 'id', 'name');
        return $restaurants;
    }
}
