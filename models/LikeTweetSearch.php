<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LikeTweet;

/**
 * LikeTweetSearch represents the model behind the search form of `app\models\LikeTweet`.
 */
class LikeTweetSearch extends LikeTweet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['likeId', 'tweetId'], 'integer'],
            [['userId', 'createTime', 'updateTime'], 'safe'],
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
        $query = LikeTweet::find();

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
            'likeId' => $this->likeId,
            'tweetId' => $this->tweetId,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'userId', $this->userId]);

        return $dataProvider;
    }
}
