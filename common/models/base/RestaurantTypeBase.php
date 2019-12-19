<?php

namespace common\models\base;

use common\models\RestaurantTypeQuery;
use Yii;

/**
 * This is the model class for table "restaurant_type".
 *
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class RestaurantTypeBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'restaurant_type';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['type', 'created_at', 'updated_at'], 'required'],
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

    /**
     * @inheritdoc
     * @return RestaurantTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RestaurantTypeQuery(get_called_class());
    }
}
