<?php

namespace common\models;

class SpecialOffers extends \common\models\base\SpecialOffersBase
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
            [['restaurant_id', 'discount', 'coupan_code', 'from_date', 'to_date'], 'required'],
            [['discount'], 'integer'],
            [['from_date', 'to_date', 'created_at', 'updated_at'], 'safe'],
            [['photo'], 'image', 'extensions' => 'jpg, jpeg, gif, png'],
            [['coupan_code'], 'string', 'max' => 255],
            /* [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],*/
        ];
    }

    public static function getSpecialOffers($restaurant_id)
    {
        $date = date("Y-m-d");
        $offers = SpecialOffers::find()->where("from_date <= '" . $date . "' AND to_date >= '" . $date . "' AND find_in_set('" . $restaurant_id . "',restaurant_id) <> 0")->asArray()->all();
        return $offers;
    }
}
