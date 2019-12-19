<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Restaurants;

/**
 * RestaurantsSearch represents the model behind the search form of `common\models\Restaurants`.
 */
class RestaurantsSearch extends Restaurants
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contact_no', 'avg_cost_for_two', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'restaurant_type', 'address', 'website', 'photo', 'is_deleted', 'created_at', 'updated_at', 'email'], 'safe'],
            [['lattitude', 'longitude'], 'number'],
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
        $query = Restaurants::find();

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
            'lattitude' => $this->lattitude,
            'longitude' => $this->longitude,
            'contact_no' => $this->contact_no,
            'avg_cost_for_two' => $this->avg_cost_for_two,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'restaurant_type', $this->restaurant_type])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'is_deleted', $this->is_deleted])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
