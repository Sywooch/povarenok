<?php

namespace app\modules\adminpanel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `app\modules\article\models\Article`.
 */
class ArticleSearch extends Article
{
		
	public $tree_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'prioritet', 'created_at', 'count_show', 'updated_at', 'tree_id'], 'integer'],
            [['name', 'path', 'short_description', 'keywords', 'description', 'image', 'title', 'recept'], 'safe'],
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
        $query = Article::getArticles();

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
            'prioritet' => $this->prioritet,
            'created_at' => $this->created_at,
            'count_show' => $this->count_show,
            'updated_at' => $this->updated_at,
			'{{%article_tree}}.id' => $this->tree_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'recept', $this->recept]);

        return $dataProvider;
    }
}
