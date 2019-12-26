<?php

namespace common\models\base;

use common\models\Restaurants;
use common\models\SpecialOffersQuery;
use Yii;

/**
 * This is the model class for table "special_offers".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property integer $discount
 * @property string $coupan_code
 * @property string $photo
 * @property string $from_date
 * @property string $to_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Restaurants $restaurant
 */
class SpecialOffersBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'special_offers';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['restaurant_id', 'discount', 'coupan_code', 'from_date', 'to_date', 'created_at'], 'required'],
            [['restaurant_id', 'discount'], 'integer'],
            [['from_date', 'to_date', 'created_at', 'updated_at'], 'safe'],
            [['coupan_code', 'photo'], 'string', 'max' => 255],
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
            'restaurant_id' => 'Restaurant',
            'discount' => 'Discount',
            'coupan_code' => 'Coupan Code',
            'photo' => 'Photo',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
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
     * @inheritdoc
     * @return SpecialOffersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecialOffersQuery(get_called_class());
    }
}
