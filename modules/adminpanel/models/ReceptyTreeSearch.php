<?php

namespace app\modules\adminpanel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\recepty\models\ReceptyTree;

/**
 * ReceptyTreeSearch represents the model behind the search form about `app\modules\recepty\models\ReceptyTree`.
 */
class ReceptyTreeSearch extends ReceptyTree
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'level', 'active', 'prioritet'], 'integer'],
            [['name', 'path', 'image', 'title', 'keywords', 'description', 'short_description'], 'safe'],
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
        $query = ReceptyTree::find()->orderBy(['pid' => SORT_ASC]);

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
            'pid' => $this->pid,
            'level' => $this->level,
            'active' => $this->active,
            'prioritet' => $this->prioritet,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'short_description', $this->short_description]);

        return $dataProvider;
    }
}
