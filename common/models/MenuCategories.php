<?php

namespace common\models;

use Yii;

class MenuCategories extends \common\models\base\MenuCategoriesBase
{
    public function beforeSave($insert)
    {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        return parent::beforeSave($insert);
    }
    public function rules()
    {
        return [
            [['name', 'status', 'description'], 'required'],
            [['name', 'status', 'description'], 'filter', 'filter' => 'trim'],
            [['restaurant_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'restaurant_id' => 'Restaurant',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
