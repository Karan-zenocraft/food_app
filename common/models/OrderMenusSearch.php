<?php

namespace common\models;

use common\models\OrderMenus;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderMenusSearch represents the model behind the search form of `common\models\OrderMenus`.
 */
class OrderMenusSearch extends OrderMenus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'restaurant_id', 'menu_id', 'quantity'], 'integer'],
            [['price', 'menu_total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = OrderMenus::find()->where(['order_id' => $params['order_id']]);

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
            'order_id' => $this->order_id,
            'restaurant_id' => $this->restaurant_id,
            'menu_id' => $this->menu_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'menu_total' => $this->menu_total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
