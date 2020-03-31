<?php

namespace common\models;

use common\components\Common;
use common\models\Orders;
use Yii;
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
            [['payment_type', 'created_at', 'updated_at', 'user_id', 'delivery_person'], 'safe'],
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
        $user_id = Yii::$app->user->id;
        $role = Common::get_user_role($user_id, $flag = "1");
        if ($role->role_id == Yii::$app->params['userroles']['super_admin']) {
            $query = Orders::find();
        } else {
            $query = Orders::find()->where(['orders.restaurant_id' => $role->restaurant_id]);
        }
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
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payment_type', $this->payment_type]);
        $query->joinWith(['user' => function ($query) {
            $query->where('user.user_name LIKE "%' . $this->user_id . '%"');
        }]);
        $query->joinWith(['deliveryPerson' => function ($query) {
            $query->where('deliveryPerson.user_name LIKE "%' . $this->delivery_person . '%"');
        }]);
        return $dataProvider;
    }
}
