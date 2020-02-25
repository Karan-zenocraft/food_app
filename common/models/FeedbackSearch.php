<?php

namespace common\models;

use common\models\Feedbacks;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FeedbackSearch represents the model behind the search form of `common\models\Feedbacks`.
 */
class FeedbackSearch extends Feedbacks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rating'], 'number'],
            [['review_note', 'created_at', 'updated_at', 'user_id'], 'safe'],
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
        $query = Feedbacks::find()->where(["feedbacks.restaurant_id" => $params['rid']]);

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
            // 'user_id' => $this->user_id,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'review_note', $this->review_note]);
        $query->joinWith(['user' => function ($query) {
            $query->where('users.user_name LIKE "%' . $this->user_id . '%"');
        }]);

        return $dataProvider;
    }
}
