<?php

namespace app\modules\article\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\article\models\ArticleTree;
use app\modules\article\models\ArticleCategories;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "np_article".
 *
 * @property integer $id
 * @property integer $active
 * @property string $name
 * @property string $path
 * @property integer $prioritet
 * @property string $short_description
 * @property string $keywords
 * @property string $description
 * @property string $image
 * @property string $title
 * @property string $recept
 * @property integer $created_at
 * @property integer $count_show
 * @property integer $updated_at
 */
class Article extends \yii\db\ActiveRecord
{

	public $tree_id;
	public $old_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_article';
    }
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),			
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'name', 'path', 'prioritet', 'short_description', 'title', 'recept'], 'required'],
            [['active', 'prioritet', 'created_at', 'count_show', 'updated_at', 'tree_id'], 'integer'],
            [['short_description', 'recept'], 'string'],
			[['treeArray'], 'safe'],
            [['name', 'path', 'keywords', 'description', 'image', 'title'], 'string', 'max' => 255],
			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Статус',
            'name' => 'Название',
            'path' => 'Путь',
            'prioritet' => 'Приоритет',
            'short_description' => 'Краткое описание',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'image' => 'Изображение',
            'title' => 'Title',
            'recept' => 'Рецепт',
            'created_at' => 'Создан',
            'count_show' => 'Кол-во просмтров',
            'updated_at' => 'Обновлен',
			'treeArray' => 'Разделы',
        ];
    }
	
	public function getDateCreate($min_date = false)
	{
		$date = date('Y-m-d',strtotime($this->updated_at));
		$date_now = date('Y-m-d');
		$yesterday = date('Y-m-d',mktime(0, 0, 0, date('m')  , date('d')-1, date('Y')));
		
		if ($date_now == $date) $result = 'cегодня';
		elseif ($yesterday == $date) $result = 'вчера';
		elseif ($min_date) {
			$result = Yii::$app->formatter->asDate($this->updated_at, 'short');			
		} else {
			$result = Yii::$app->formatter->asDate($this->updated_at, 'long');
		}

		return $result;		
	}
			
	public function getTimeCreate() 
	{
		return date('H:i',strtotime($this->updated_at));
	}
	
	public function getCategoryLink()
	{
		$item = ArticleTree::getCategoryByIdArticle($this->id);
		return Html::a($item->name, ['/article/default/filtr', 'path' => $item->path],['title'=>$item->name]);
	}
	
	public function getUrl()
	{
		return Url::toRoute(['/article/default/view', 'path' => $this->path]);
	}
		
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategories::className(), ['id_article' => 'id']);
    }
	
	public static function getArticleByTreeId($tree_id)
	{		
		$product_ids = ArticleTree::getChildsTree($tree_id);

		return Article::find()
			->joinWith('articleCategories')
			->where(['id_tree' => $product_ids]);		
	}	
			
	public function getImagePath()
	{
		$img_path = Yii::$app->params['article']['image']['small']['path'];
		
		return !empty($this->image) ? $img_path.$this->image : '/img/no-photo.jpg';
	}
	
    public function getTrees()
    {
        return $this->hasMany(ArticleTree::className(), ['id' => 'id_tree'])
			->viaTable('{{%article_categories}}', ['id_article' => 'id']);
    }
		
    public function getArticles()
    {
        return Article::find()->joinWith('trees');
    }

	public function getCategoryName()
	{
		$item = ArticleTree::getCategoryByIdArticle($this->id);
		return $item->name;
	}
	
	private $_treeArray;
	
	public function getTreeArray()
	{
		if ($this->_treeArray === null) {
			$this->_treeArray = $this->getTrees()->select('id')->column();
		}
		return $this->_treeArray;
	}
	
	public function setTreeArray($value)
	{
		$this->_treeArray = (array)$value;
	}
	
    public function afterSave($insert, $changedAttributes)
    {
        $this->updateCategory();
        parent::afterSave($insert, $changedAttributes);
    }
	
    private function updateCategory()
    {
        $currentTreeIds = $this->getTrees()->select('id')->column();
        $newTreeIds = $this->getTreeArray();
        foreach (array_filter(array_diff($newTreeIds, $currentTreeIds)) as $treeId) {
            /** @var Tree $tree */
            if ($tree = ArticleTree::findOne($treeId)) {
                $this->link('trees', $tree);
            }
        }
        foreach (array_filter(array_diff($currentTreeIds, $newTreeIds)) as $treeId) {
            /** @var Tree $tree */
            if ($tree = ArticleTree::findOne($treeId)) {
                $this->unlink('trees', $tree, true);
            }
        }
    }

	public function upload()
	{
		$paramsCrop = Yii::$app->request;
		$this->image = UploadedFile::getInstance($this, 'image');
		if (!empty($this->image)) {	

			$this->deleteImage($this->image);

			$param_img = Yii::$app->params['article']['image'];
			$path_big = substr($param_img['big']['path'], 1);
			$path_small = substr($param_img['small']['path'], 1);
					
			$image_name = $this->path . '.' . $this->image->extension;
			
			$this->image->saveAs($path_big.$image_name);
					
			$x = ($paramsCrop->post('datax') > 0) ? $paramsCrop->post('datax') : 0;
			$y = ($paramsCrop->post('datay') > 0) ? $paramsCrop->post('datay') : 0;
						
			Image::crop($path_big.$image_name, $paramsCrop->post('width'), $paramsCrop->post('height'), [$x, $y])
				->save($path_small.$image_name, ['quality' => 50]);

			$this->image = $image_name;

		} else {
			$this->image = $this->old_image;			
		}
	}	
	
	public function deleteImage($file)
	{ 		
		$param_img = Yii::$app->params['article']['image'];
		$path_big = substr($param_img['big']['path'], 1);
		$path_small = substr($param_img['small']['path'], 1);
			
		if(!empty($file)){
			@unlink($path_big.$file);
			@unlink($path_small.$file);
		}            
	} 
		
}
