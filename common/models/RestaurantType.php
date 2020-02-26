<?php

namespace common\models;

use yii\helpers\ArrayHelper;

class RestaurantType extends \common\models\base\RestaurantTypeBase
{
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
    }
    public function rules()
    {
        return [
            [['type', 'description'], 'required'],
            [['type', 'description'], 'filter', 'filter' => 'trim'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'description'], 'string', 'max' => 255],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function RestaurantTypesDropdown()
    {
        $restaurantsTypes = ArrayHelper::map(RestaurantType::find()->orderBy('type')->asArray()->all(), 'id', 'type');
        return $restaurantsTypes;
    }
}
