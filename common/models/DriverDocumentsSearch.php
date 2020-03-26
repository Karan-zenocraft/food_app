<?php

namespace common\models;

use common\models\DriverDocuments;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DriverDocumentsSearch represents the model behind the search form of `common\models\DriverDocuments`.
 */
class DriverDocumentsSearch extends DriverDocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['document_photo', 'document_photo_url', 'created_at', 'updated_at'], 'safe'],
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
        $query = DriverDocuments::find()->where(['user_id' => $params['uid']]);

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'document_photo', $this->document_photo])
            ->andFilterWhere(['like', 'document_photo_url', $this->document_photo_url]);

        return $dataProvider;
    }
}
