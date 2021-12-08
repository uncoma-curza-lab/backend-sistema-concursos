<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Persons;

/**
 * PersonsSearch represents the model behind the search form of `app\models\Persons`.
 */
class PersonsSearch extends Persons
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'place_of_birth', 'user_id'], 'integer'],
            [['first_name', 'last_name', 'uid', 'dni', 'contact_email', 'cellphone', 'phone', 'real_address', 'legal_address', 'citizenship', 'date_of_birth'], 'safe'],
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
        $query = Persons::find();

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
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'uid', $this->uid])
            ->andFilterWhere(['ilike', 'dni', $this->dni])
            ->andFilterWhere(['ilike', 'contact_email', $this->contact_email])
            ->andFilterWhere(['ilike', 'cellphone', $this->cellphone])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'real_address', $this->real_address])
            ->andFilterWhere(['ilike', 'legal_address', $this->legal_address])
            ->andFilterWhere(['ilike', 'citizenship', $this->citizenship]);

        return $dataProvider;
    }
}
