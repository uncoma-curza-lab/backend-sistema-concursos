<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contests;
use Yii;

/**
 * ContestSearch represents the model behind the search form of `app\models\Contests`.
 */
class ContestSearch extends Contests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'qty', 'remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id', 'share_id'], 'integer'],
            [['name', 'code', 'init_date', 'end_date', 'enrollment_date_end', 'description', 'course_id'], 'safe'],
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
        $query = Contests::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->orderBy(['created_at' => SORT_DESC]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $user = Yii::$app->user;
        $roles = array_keys(Yii::$app->getAuthManager()->getRolesByUser($user->id));
        if (in_array('jury', $roles)) {
            $query->joinWith(['juries'])->andFilterWhere(['=', 'contest_juries.user_id', $user->id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'qty' => $this->qty,
            'init_date' => $this->init_date,
            'end_date' => $this->end_date,
            'enrollment_date_end' => $this->enrollment_date_end,
            'remuneration_type_id' => $this->remuneration_type_id,
            'working_day_type_id' => $this->working_day_type_id,
            'category_type_id' => $this->category_type_id,
            'area_id' => $this->area_id,
            'orientation_id' => $this->orientation_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'course_id', $this->course_id]);

        return $dataProvider;
    }
}
