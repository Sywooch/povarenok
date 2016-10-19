<?php

namespace app\modules\adminpanel\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comments\models\UsersComment;

/**
 * UsersCommentSearch represents the model behind the search form about `app\modules\comments\models\UsersComment`.
 */
class UsersCommentSearch extends UsersComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_table', 'id_user', 'created_at', 'updated_at', 'pid', 'active'], 'integer'],
            [['comment', 'table_name'], 'safe'],
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
        $query = UsersComment::find();

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
            'id_table' => $this->id_table,
            'id_user' => $this->id_user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pid' => $this->pid,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'table_name', $this->table_name]);

        return $dataProvider;
    }
}
