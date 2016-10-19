<?php

namespace app\modules\recepty\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * This is the model class for table "np_catalog_tree".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $name
 * @property string $path
 * @property string $image
 * @property integer $active
 * @property integer $prioritet
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $short_description
 */
class ReceptyTree extends \yii\db\ActiveRecord
{
		
	public $old_image = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'np_recepty_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'name', 'path'], 'required'],
            [['pid', 'level', 'active', 'prioritet'], 'integer'],
            [['short_description'], 'string'],
            [['name', 'path'], 'string', 'max' => 100],
            [['image', 'title'], 'string', 'max' => 255],
            [['keywords', 'description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Родитель',
            'level' => 'Level',
            'name' => 'Название',
            'path' => 'Путь',
            'image' => 'Изображение',
            'active' => 'Активен',
            'prioritet' => 'Приоритет',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'short_description' => 'Описание',
        ];
    }

	public function getImagePath()
	{
		$img_path = Yii::$app->params['recepty_tree']['image']['small']['path'];
		
		return !empty($this->image) ? $img_path.$this->image : '/img/no-photo.jpg';
	}
	
	public static function getBreadcrumbs($id_tree) 
	{
		$string_tree = ReceptyTree::getParentsTree($id_tree);
		$array_id = array_reverse(array_filter(explode(',',$string_tree)));
		$html = '';
		foreach($array_id as $id) {
			$tree = ReceptyTree::findOne($id);
			if (empty($tree->path)) {
				$html .= '<li>'.Html::a($tree->name, ['/recepty']).'</li>';
			} else {			
				$html .= '<li>'.Html::a($tree->name, ['/recepty/default/filtr', 'path' => $tree->path]).'</li>';
			}
		}
		return $html;
	}
	
	public static function getTreeByPath($path)
	{
		return ReceptyTree::findOne(['path'=>$path]);
	}

    public function getReceptyCategories()
    {
        return $this->hasMany(ReceptyCategories::className(), ['tree_id' => 'id']);
    }

	public static function getCategoryByIdRecept($recept_id)
	{		
		return ReceptyTree::find()
			->joinWith('receptyCategories')
			->where(['recept_id' => $recept_id])
			->orderBy('name')
			->one();		
	}
		
	public static function getParentsTree($pid) 
	{
		$html = '';
		
		$items = ReceptyTree::find()->where(['id' => $pid])->orderBy('id asc')->all();
		foreach ($items as $item) {
			$html .= $item->id.','.ReceptyTree::getParentsTree($item->pid);
		}

		return $html;	
	}
	
	public static function getChildsTree($id) 
	{
		$result = [$id];
		$items = ReceptyTree::find()->where(['pid' => $id])->orderBy('id asc')->all();
		foreach ($items as $item) {
			$result[] = $item['id'];
			ReceptyTree::getChildsTree($item['id']);
		}

		return $result;	
	}

	public function upload()
	{
		$this->image = UploadedFile::getInstance($this, 'image');
		if (!empty($this->image)) {	

			$this->deleteImage($this->image);

			$param_img = Yii::$app->params['recepty_tree']['image'];
			$path_big = substr($param_img['big']['path'], 1);
			$path_small = substr($param_img['small']['path'], 1);
					
			$image_name = $this->path . '.' . $this->image->extension;
			
			$this->image->saveAs($path_big.$image_name);
						
			Image::thumbnail($path_big.$image_name, $param_img['small']['width'], $param_img['small']['height'])
				->save($path_small.$image_name, ['quality' => 50]);

			$this->image = $image_name;

		} else {
			$this->image = $this->old_image;			
		}
	}
	
	public function deleteImage($file)
	{ 		
		$param_img = Yii::$app->params['recepty_tree']['image'];
		$path_big = substr($param_img['big']['path'], 1);
		$path_small = substr($param_img['small']['path'], 1);
			
		if(!empty($file)){
			@unlink($path_big.$file);
			@unlink($path_small.$file);
		}            
	} 
	
}
