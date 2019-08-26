<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pet;

/**
 * PetSearch represents the model behind the search form of `app\models\Pet`.
 */
class PetSearch extends Pet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petId', 'status', 'gender', 'age', 'vaccineStatus', 'petType', 'weight', 'neuter'], 'integer'],
            [['nickname', 'subType', 'size', 'color', 'createTime', 'updateTime'], 'safe'],
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
        $query = Pet::find();

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
            'petId' => $this->petId,
            'status' => $this->status,
            'gender' => $this->gender,
            'age' => $this->age,
            'vaccineStatus' => $this->vaccineStatus,
            'petType' => $this->petType,
            'weight' => $this->weight,
            'neuter' => $this->neuter,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'subType', $this->subType])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'color', $this->color]);

        return $dataProvider;
    }
}
