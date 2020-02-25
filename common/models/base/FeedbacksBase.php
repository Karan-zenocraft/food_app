<?php

namespace common\models\base;

use Yii;
use common\models\Restaurants;
use common\models\Users;

/**
 * This is the model class for table "feedbacks".
*
    * @property integer $id
    * @property integer $restaurant_id
    * @property integer $user_id
    * @property double $rating
    * @property string $review_note
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Restaurants $restaurant
            * @property Users $user
    */
class FeedbacksBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'feedbacks';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['restaurant_id', 'user_id', 'rating', 'review_note', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'user_id'], 'integer'],
            [['rating'], 'number'],
            [['review_note'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
    'user_id' => 'User ID',
    'rating' => 'Rating',
    'review_note' => 'Review Note',
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
    public function getUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}