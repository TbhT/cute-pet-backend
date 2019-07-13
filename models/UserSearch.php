<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 * @property mixed userId
 * @property mixed birth
 * @property mixed gender
 * @property mixed age
 * @property mixed high
 * @property mixed status
 * @property mixed createTime
 * @property mixed updateTime
 * @property mixed avatar
 * @property mixed mobile
 * @property mixed name
 * @property mixed nickname
 * @property mixed city
 * @property mixed province
 * @property mixed address
 * @property mixed idCard
 * @property mixed password_hash
 * @property mixed auth_key
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'gender', 'age', 'high', 'status'], 'integer'],
            [['mobile', 'avatar', 'name', 'nickname', 'birth', 'city', 'province', 'address', 'idCard', 'password_hash', 'auth_key', 'createTime', 'updateTime'], 'safe'],
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
        $query = User::find();

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
            'userId' => $this->userId,
            'birth' => $this->birth,
            'gender' => $this->gender,
            'age' => $this->age,
            'high' => $this->high,
            'status' => $this->status,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'idCard', $this->idCard])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }
}
