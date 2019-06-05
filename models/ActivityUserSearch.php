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
            [['auId', 'activityId', 'userId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
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
            'auId' => $this->auId,
            'activityId' => $this->activityId,
            'userId' => $this->userId,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        return $dataProvider;
    }
}
