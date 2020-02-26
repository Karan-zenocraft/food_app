<?php

namespace common\models;

use Yii;

class RestaurantMenu extends \common\models\base\RestaurantMenuBase
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
            [['name', 'description', 'price'], 'required'],
            [['name', 'description', 'price'], 'filter', 'filter' => 'trim'],
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
            'restaurant_id' => 'Restaurant',
            'name' => 'Name',
            'description' => 'Description',
            'menu_category_id' => 'Menu Category',
            'price' => 'Price',
            'photo' => 'Photo',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
