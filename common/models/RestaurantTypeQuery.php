<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RestaurantType]].
 *
 * @see RestaurantType
 */
class RestaurantTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return RestaurantType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RestaurantType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
