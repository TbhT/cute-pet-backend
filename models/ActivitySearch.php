<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;

/**
 * ActivitySearch represents the model behind the search form of `app\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activityId', 'status'], 'integer'],
            [['name', 'beginTime', 'endTime', 'joinBeginTime', 'joinEndTime', 'organizer', 'coorganizer', 'place', 'createTime', 'updateTime'], 'safe'],
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
        $query = Activity::find();

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
            'activityId' => $this->activityId,
            'status' => $this->status,
            'beginTime' => $this->beginTime,
            'endTime' => $this->endTime,
            'joinBeginTime' => $this->joinBeginTime,
            'joinEndTime' => $this->joinEndTime,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
            ->andFilterWhere(['like', 'coorganizer', $this->coorganizer])
            ->andFilterWhere(['like', 'place', $this->place]);

        return $dataProvider;
    }
}
