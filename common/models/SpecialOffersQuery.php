<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SpecialOffers]].
 *
 * @see SpecialOffers
 */
class SpecialOffersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SpecialOffers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SpecialOffers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
