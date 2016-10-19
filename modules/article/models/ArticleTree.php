<?php

namespace app\modules\article\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "np_article_tree".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $name
 * @property string $path
 * @property integer $active
 * @property integer $prioritet
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $short_description
 */
class ArticleTree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_article_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'name', 'path', 'active', 'prioritet', 'title', 'keywords', 'description', 'short_description'], 'required'],
            [['pid', 'level', 'active', 'prioritet'], 'integer'],
            [['short_description'], 'string'],
            [['name', 'path'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 255],
            [['keywords', 'description'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'level' => 'Level',
            'name' => 'Name',
            'path' => 'Path',
            'active' => 'Active',
            'prioritet' => 'Prioritet',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'short_description' => 'Short Description',
        ];
    }

	public static function getBreadcrumbs($id_tree) 
	{
		$string_tree = ArticleTree::getParentsTree($id_tree);
		$array_id = array_reverse(array_filter(explode(',',$string_tree)));
		$html = '';
		foreach($array_id as $id) {
			$tree = ArticleTree::findOne($id);
			if (empty($tree->path)) {
				$html .= '<li>'.Html::a($tree->name, ['/article']).'</li>';
			} else {
				$html .= '<li>'.Html::a($tree->name, ['/article/default/filtr', 'path' => $tree->path]).'</li>';
			}	
		}
		return $html;
	}
	
	public static function getTreeByPath($path)
	{
		return ArticleTree::findOne(['path'=>$path]);
	}
		
	public static function getArticleTree()
	{
		return ArticleTree::find()->orderBy('prioritet desc')
			->where(['active' => 1,'pid' => 1])
			->limit(8)
            ->all();
	}

    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategories::className(), ['id_tree' => 'id']);
    }

	public static function getCategoryByIdArticle($id_article)
	{		
		return ArticleTree::find()
			->joinWith('articleCategories')
			->where(['id_article' => $id_article])
			->orderBy('name')
			->one();		
	}
		
	public static function getParentsTree($pid) 
	{
		$html = '';
		
		$items = ArticleTree::find()->where(['id' => $pid])->orderBy('id asc')->all();
		foreach ($items as $item) {
			$html .= $item->id.','.ArticleTree::getParentsTree($item->pid);
		}

		return $html;	
	}
	
	public static function getChildsTree($id) 
	{
		$result = [$id];
		$items = ArticleTree::find()->where(['pid' => $id])->orderBy('id asc')->all();
		foreach ($items as $item) {
			$result[] = $item['id'];
			ArticleTree::getChildsTree($item['id']);
		}

		return $result;	
	}
	
}
