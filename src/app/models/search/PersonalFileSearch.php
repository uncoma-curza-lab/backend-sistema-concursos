<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PersonalFile;

/**
 * PersonalFileSearch represents the model behind the search form of `app\models\PersonalFile`.
 */
class PersonalFileSearch extends PersonalFile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'person_id', 'postulation_id', 'is_valid'], 'integer'],
            [['document_type_code', 'path', 'valid_until', 'created_at', 'validated_at', 'description'], 'safe'],
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
        $query = PersonalFile::find();

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
            'person_id' => $this->person_id,
            'postulation_id' => $this->postulation_id,
            'is_valid' => $this->is_valid,
            'valid_until' => $this->valid_until,
            'created_at' => $this->created_at,
            'validated_at' => $this->validated_at,
        ]);

        $query->andFilterWhere(['ilike', 'document_type_code', $this->document_type_code])
            ->andFilterWhere(['ilike', 'path', $this->path])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }

    public function searchPersonalAndPostulation(int $postulationId, int $personId, array $params = [])
    {
        $query = PersonalFile::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andWhere([
            'person_id' => $personId,
        ]);

        $query->andWhere(['or',
            ['postulation_id' => null],
            ['postulation_id' => $postulationId],
        ]);

        $query->andFilterWhere(['ilike', 'document_type_code', $this->document_type_code])
            ->andFilterWhere(['ilike', 'path', $this->path])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
