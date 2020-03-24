<?php

namespace common\models;

use common\models\AccountDetails;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AccountDetailsSearch represents the model behind the search form of `common\models\AccountDetails`.
 */
class AccountDetailsSearch extends AccountDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'restaurant_id', 'stripe_bank_routing_number', 'stripe_bank_account_number'], 'integer'],
            [['paypal_email', 'stripe_bank_account_holder_name', 'stripe_bank_account_holder_type', 'stripe_bank_token', 'stripe_connect_account_id', 'stripe_bank_accout_id', 'created_at', 'updated_at'], 'safe'],
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
        $query = AccountDetails::find()->where(["restaurant_id" => $params['rid']]);

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
            'restaurant_id' => $this->restaurant_id,
            'stripe_bank_routing_number' => $this->stripe_bank_routing_number,
            'stripe_bank_account_number' => $this->stripe_bank_account_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'paypal_email', $this->paypal_email])
            ->andFilterWhere(['like', 'stripe_bank_account_holder_name', $this->stripe_bank_account_holder_name])
            ->andFilterWhere(['like', 'stripe_bank_account_holder_type', $this->stripe_bank_account_holder_type])
            ->andFilterWhere(['like', 'stripe_bank_token', $this->stripe_bank_token])
            ->andFilterWhere(['like', 'stripe_connect_account_id', $this->stripe_connect_account_id])
            ->andFilterWhere(['like', 'stripe_bank_accout_id', $this->stripe_bank_accout_id]);

        return $dataProvider;
    }
}
