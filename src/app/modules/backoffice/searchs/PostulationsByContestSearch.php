<?php

namespace app\modules\backoffice\searchs;

use app\models\Contests;
use app\models\Postulations;
use app\models\PostulationStatus;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostulationsByContestSearch extends Postulations
{

    private $contestSlug;

    public function __construct(string $contestSlug)
    {
        $this->contestSlug = $contestSlug;
        parent::__construct();
    }

    public function attributes()
    {
        $customAttributes = [
            'personFullName',
            'personEmail',
        ];

        return array_merge(parent::attributes(), $customAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'person_id'], 'integer'],
            [['meet_date', 'personFullName', 'personEmail'], 'safe'],
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
        $contest = $this->findContest();

        $query = Postulations::find()->where([
            '=',
            'contest_id',
            $contest->id
        ])->joinWith(['person']);

        // add conditions that should always apply here
        if(\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'jury')){
            $query->andWhere(['=', 'postulations.status', PostulationStatus::ACCEPTED]);
        }

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
        //$query->andFilterWhere([
        //    'id' => $this->id,
        //    'contest_id' => $this->contest_id,
        //    'person_id' => $this->person_id,
        //]);

        $query->andFilterWhere(['ilike', 'persons.email', $this->personEmail])
            ->andFilterWhere(['ilike', 'concat(persons.first_name, \' \', persons.last_name)', $this->personFullName]);

        return $dataProvider;
    }

    private function findContest()
    {
        return Contests::find()->findBySlug($this->contestSlug);
    }
}
