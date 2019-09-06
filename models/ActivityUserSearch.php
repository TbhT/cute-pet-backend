<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivityUser;

/**
 * ActivityUserSearch represents the model behind the search form of `app\models\ActivityUser`.
 */
class ActivityUserSearch extends ActivityUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'activityId', 'type'], 'integer'],
            [['name', 'phone', 'relation', 'size', 'createTime', 'updateTime', 'tag'], 'safe'],
            [['amount'], 'number'],
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
        $query = ActivityUser::find();

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
//            'userId' => $this->userId,
            'activityId' => $this->activityId,
            'createTime' => $this->createTime,
//            'updateTime' => $this->updateTime,
            'type' => $this->type,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'relation', $this->relation])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        return $dataProvider;
    }
}
