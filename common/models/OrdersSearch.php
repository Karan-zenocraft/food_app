<?php

namespace common\models;

use common\models\Orders;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch represents the model behind the search form of `common\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_address_id', 'status'], 'integer'],
            [['payment_type', 'created_at', 'updated_at', 'user_id'], 'safe'],
            [['total_amount', 'delivery_charges', 'other_charges'], 'number'],
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
        $query = Orders::find();

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
            // 'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
            'delivery_charges' => $this->delivery_charges,
            'other_charges' => $this->other_charges,
            'user_address_id' => $this->user_address_id,
            'orders.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payment_type', $this->payment_type]);
        $query->joinWith(['user' => function ($query) {
            $query->where('users.user_name LIKE "%' . $this->user_id . '%"');
        }]);
        return $dataProvider;
    }
}
