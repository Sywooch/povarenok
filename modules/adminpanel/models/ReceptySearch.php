<?php

namespace app\modules\adminpanel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\recepty\models\Recepty;

/**
 * ReceptySearch represents the model behind the search form about `app\modules\recepty\models\Recepty`.
 */
class ReceptySearch extends Recepty
{
	public $tree_id;	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'prioritet', 'time', 'count_show', 'count_like', 'count_note', 'tree_id'], 'integer'],
            [['name', 'path', 'short_description', 'title', 'keywords', 'description', 'image', 'url_video', 'recept', 'date_create'], 'safe'],
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
        $query = Recepty::getReceptys();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [ 
				'pageSize' => 50 
			],
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
            '{{%recepty}}.active' => $this->active,
            '{{%recepty}}.prioritet' => $this->prioritet,
            'time' => $this->time,
            'date_create' => $this->date_create,
            'count_show' => $this->count_show,
            'count_like' => $this->count_like,
            'count_note' => $this->count_note,
			'{{%recepty_tree}}.id' => $this->tree_id,
        ]);

        $query->andFilterWhere(['like', '{{%recepty}}.name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'url_video', $this->url_video])
            ->andFilterWhere(['like', 'recept', $this->recept]);

		$query->groupBy('{{%recepty}}.id');	
			
        return $dataProvider;
    }
}
