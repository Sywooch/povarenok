<?php

namespace app\modules\recepty\models;

use Yii;
use app\modules\recepty\models\ReceptyTree;
use app\modules\recepty\models\ReceptyCategories;
use app\modules\recepty\models\ReceptyIngredients;
use app\modules\users\models\UsersLike;
use app\modules\comments\models\UsersComment;
use app\modules\users\models\UsersRecept;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * This is the model class for table "np_recepty".
 *
 * @property integer $id
 * @property integer $active
 * @property string $name
 * @property string $path
 * @property integer $prioritet
 * @property string $short_description
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $image
 * @property integer $time
 * @property string $url_video
 * @property string $recept
 * @property string $date_create
 * @property integer $count_show
 * @property integer $count_like
 * @property integer $count_note
 */
class Recepty extends \yii\db\ActiveRecord
{
	
	public $old_image = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_recepty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'treeArray'], 'required'],
            [['active', 'prioritet', 'time', 'count_show', 'count_like', 'count_note'], 'integer'],
            [['short_description', 'recept'], 'string'],
			['time', 'default', 'value' => 0],
            [['date_create','ingredients'], 'safe'],
            [['name', 'path', 'title', 'keywords', 'description'], 'string', 'max' => 255],
			[['title','keywords','description'], 'default', 'value' => function ($model, $attribute) {
				if ($attribute == 'title') return $model->name . ' рецепт с фото';
				if ($attribute == 'keywords') return 'Кулинарные рецепты, рецепт ' . mb_strtolower($model->name,'UTF-8');
				if ($attribute == 'description') return 'Приготовить ' . mb_strtolower($model->name,'UTF-8') . ' дома';
			}],						
			[['image'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'gif, jpeg, jpg, png',
                'mimeTypes'=>'image/gif, image/jpeg, image/jpg, image/png',			
			],
            [['url_video'], 'string', 'max' => 500]
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
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'image' => 'Изображение',
            'time' => 'Время (мин)',
            'url_video' => 'Ссылка на видео',
            'recept' => 'Рецепт',
            'date_create' => 'Дата создания',
            'count_show' => 'Количество просмотров',
            'count_like' => 'Количество лайков',
            'count_note' => 'Количество заметок',
			'treeArray' => 'Раздел',
			'ingredients' => 'Ингредиенты',
        ];
    }
	
	public function getDateCreate($min_date = false)
	{
		$date = date('Y-m-d',strtotime($this->date_create));
		$date_now = date('Y-m-d');
		$yesterday = date('Y-m-d',mktime(0, 0, 0, date('m')  , date('d')-1, date('Y')));
		
		if ($date_now == $date) $result = 'cегодня';
		elseif ($yesterday == $date) $result = 'вчера';
		elseif ($min_date) {
			$result = Yii::$app->formatter->asDate($this->date_create, 'short');			
		} else {
			$result = Yii::$app->formatter->asDate($this->date_create, 'long');
		}

		return $result;		
	}
	
	public function getImagePath()
	{
		$img_path = Yii::$app->params['recepty_image']['image']['small']['path'];
		
		return !empty($this->image) ? $img_path.$this->image : '/img/np_photo_recept.png';
	}
		
	public function getImagePathBig()
	{
		$img_path = Yii::$app->params['recepty_image']['image']['big']['path'];
		
		return !empty($this->image) ? $img_path.$this->image : '/img/np_photo_recept.png';
	}
			
	public function getTimeCreate() {
		return date('H:i',strtotime($this->date_create));
	}
	
    public function getReceptyIngredients()
    {
        return $this->hasMany(ReceptyIngredients::className(), ['recept_id' => 'id']);
    }
		
    public function getReceptyCategories()
    {
        return $this->hasMany(ReceptyCategories::className(), ['recept_id' => 'id']);
    }
		
	public function getUsersLike()
	{
		return $this->hasMany(UsersLike::className(), ['id_table' => 'id']);
	}
			
	public function getUsersComment()
	{
		return $this->hasMany(UsersComment::className(), ['id_table' => 'id']);
	}

	public function getAuthor()
	{
		return $this->hasOne(UsersRecept::className(), ['id_catalog' => 'id']);
	}	
		
	public function search($q)
	{		
		return Recepty::find()
			->where(['like', 'name', $q])
			->orWhere(['like', 'short_description', $q])
			->orderBy(['count_show' => SORT_DESC]);	
	}	
		
	public static function getReceptyNotes($id_variate)
	{		
		return Recepty::find()
			->joinWith('usersLike')
			->where([
				'table_name' => UsersComment::RECEPTY, 
				'id_variate' => $id_variate, 
				'id_user' => Yii::$app->user->id
				])
			->orderBy(['np_users_like.id' => SORT_DESC]);		
	}	
	
	public static function getReceptyNotifications()
	{		
		return Recepty::find()
			->joinWith('usersComment')
			->where([
				'np_users_comment.active' => 1,
				'table_name' => UsersComment::RECEPTY, 
				'id_user' => Yii::$app->user->id
				]);		
	}	

	public static function getReceptyByTreeId($tree_id)
	{		
		$product_ids = ReceptyTree::getChildsTree($tree_id);

		return Recepty::find()
			->joinWith('receptyCategories')
			->where(['tree_id' => $product_ids]);		
	}	
	
	public function getCountShow() 
	{
		if ($this->count_show > 20) $razryad = $this->count_show % 10;
		
		$text = 'просмотров';		
		if ($razryad == 1) $text = 'просмотр'; 
		if (($razryad > 1) && ($razryad <= 4)) $text = 'просмотра'; 

		return $this->count_show.' '.$text;
	}	
	
	public function getCategoryLink()
	{
		$item = ReceptyTree::getCategoryByIdRecept($this->id);
		return Html::a($item->name, ['/recepty/default/filtr', 'path' => $item->path],['title'=>$item->name]);
	}
	
	public function getUrl()
	{
		return Url::toRoute(['/recepty/default/view', 'path' => $this->path]);
	}
			
    public function getTrees()
    {
        return $this->hasMany(ReceptyTree::className(), ['id' => 'tree_id'])
			->viaTable('{{%recepty_categories}}', ['recept_id' => 'id']);
    }
	
    public function getReceptys()
    {
        return Recepty::find()->joinWith('trees')->orderBy(['id' => SORT_DESC]);
    }

	public function getCategoryName()
	{
		$item = ReceptyTree::getCategoryByIdRecept($this->id);
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

	
	private $_ingredients;
	
	public function setIngredients($value)
	{
		$this->_ingredients = (array)$value;
	}
	
	public function getIngredients()
	{
		if ($this->_ingredients === null) {
			$this->_ingredients = ReceptyIngredients::find()->where(['recept_id' => $this->id])->orderBy(['id' => SORT_ASC])->all();
			if (empty($this->_ingredients)) {
				$this->_ingredients = ReceptyIngredients::find()->limit(1)->all();
				$this->_ingredients[0]['ingredient_id'] = null;
				$this->_ingredients[0]['kolvo'] = null;
				$this->_ingredients[0]['id_measure'] = null;
			}			
		} 
		return $this->_ingredients;
	}

    public function afterSave($insert, $changedAttributes)
    {
		$this->updateIngredients();
        $this->updateCategory();
        parent::afterSave($insert, $changedAttributes);
    }
	
    private function updateIngredients()
    {
		if (Yii::$app->request->post('ReceptyIngredients') === null) return false;
		$recept_id = $this->id;		
		ReceptyIngredients::deleteAll(['recept_id' => $recept_id]);
		foreach(Yii::$app->request->post('ReceptyIngredients') as $item) {
			$recIng = new ReceptyIngredients();
			$recIng->recept_id = $recept_id;
			$recIng->ingredient_id = $item['ingredient_id'];
			$recIng->kolvo = $item['kolvo'];
			$recIng->id_measure = $item['id_measure'];
			$recIng->save();
		}
	}	
	
    private function updateCategory()
    {	
        $currentTreeIds = $this->getTrees()->select('id')->column();
        $newTreeIds = $this->getTreeArray();
        foreach (array_filter(array_diff($newTreeIds, $currentTreeIds)) as $treeId) {
            /** @var Tree $tree */
            if ($tree = ReceptyTree::findOne($treeId)) {
                $this->link('trees', $tree);
            }
        }
        foreach (array_filter(array_diff($currentTreeIds, $newTreeIds)) as $treeId) {
            /** @var Tree $tree */
            if ($tree = ReceptyTree::findOne($treeId)) {
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

			$param_img = Yii::$app->params['recepty_image']['image'];
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
		$param_img = Yii::$app->params['recepty_image']['image'];
		$path_big = substr($param_img['big']['path'], 1);
		$path_small = substr($param_img['small']['path'], 1);
			
		if(!empty($file)){
			@unlink($path_big.$file);
			@unlink($path_small.$file);
		}            
	} 
	
	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			ReceptyIngredients::deleteAll(['recept_id' => $this->id]);
			ReceptyCategories::deleteAll(['recept_id' => $this->id]);
			$this->deleteImage($this->image);
			return true;
		} else {
			return false;
		}		
	}
		

}
