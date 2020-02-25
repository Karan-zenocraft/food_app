<?php

namespace common\models;

class Feedbacks extends \common\models\base\FeedbacksBase
{
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Restaurant',
            'user_id' => 'User',
            'rating' => 'Rating',
            'review_note' => 'Review Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
