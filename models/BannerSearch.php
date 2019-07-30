<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banner;

/**
 * BannerSearch represents the model behind the search form of `app\models\Banner`.
 * @property mixed name
 */
class BannerSearch extends Banner
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bannerId'], 'integer'],
            [['name'], 'string'],
            [['image', 'createTime', 'updateTime'], 'safe'],
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
        $query = Banner::find();

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
            'bannerId' => $this->bannerId,
            'name' => $this->name,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
