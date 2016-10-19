<?php

namespace app\modules\adminpanel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\recepty\models\Ingredients;

/**
 * IngredientsSearch represents the model behind the search form about `app\modules\recepty\models\Ingredients`.
 */
class IngredientsSearch extends Ingredients
{
    /**
     * @inheritdoc
     */
	public function rules()
    {
        return [
            [['id', 'active', 'kkal'], 'integer'],
            [['name', 'path', 'name_old', 'short_description'], 'safe'],
            [['belki', 'zhiri', 'yglevodi'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Ingredients::find();

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
            'active' => $this->active,
            'belki' => $this->belki,
            'zhiri' => $this->zhiri,
            'yglevodi' => $this->yglevodi,
            'kkal' => $this->kkal,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name_old', $this->name_old])
            ->andFilterWhere(['like', 'short_description', $this->short_description]);

        return $dataProvider;
    }
}
