<?php

namespace common\models;

use common\models\SpecialOffers;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SpecialOffersSearch represents the model behind the search form of `common\models\SpecialOffers`.
 */
class SpecialOffersSearch extends SpecialOffers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'restaurant_id', 'discount'], 'integer'],
            [['coupan_code', 'photo', 'from_date', 'to_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SpecialOffers::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'restaurant_id' => $this->restaurant_id,
            'discount' => $this->discount,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'coupan_code', $this->coupan_code])
        //->andFilterWhere(['like', 'photo', $this->photo]);
            ->andFilterWhere(['like', 'restaurant_id', $this->restaurant_id]);

        return $dataProvider;
    }
}
