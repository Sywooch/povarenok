<?php

namespace app\modules\recepty\models;

use Yii;
use app\modules\recepty\models\ReceptyIngredients;
use app\modules\recepty\models\Measures;

/**
 * This is the model class for table "np_ingredients".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property string $path
 * @property string $name_old
 * @property string $short_description
 * @property double $belki
 * @property double $zhiri
 * @property double $yglevodi
 * @property integer $kkal
 */
class Ingredients extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ingredients}}';
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'active', 'path'], 'required'],
            [['active', 'kkal'], 'integer'],
            [['short_description'], 'string'],
            [['belki', 'zhiri', 'yglevodi'], 'number'],
            [['name'], 'string', 'max' => 150],
            [['path'], 'string', 'max' => 100],
            [['name_old'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'active' => 'Активен',
            'path' => 'Путь',
            'name_old' => 'Name Old',
            'short_description' => 'Краткое описание',
            'belki' => 'Белки',
            'zhiri' => 'Жиры',
            'yglevodi' => 'Углеводы',
            'kkal' => 'Калорийность',			
        ];
    }
	
    public function getReceptyIngredients()
    {
        return $this->hasMany(ReceptyIngredients::className(), ['ingredient_id' => 'id']);
    }

	public function getIngredientsJoin()
	{
		return Ingredients::find()
			->joinWith('receptyIngredients')
			->orderBy('name')
			->groupBy('ingredient_id')
			->all();
	}

	public static function getHtmlIngredient($id, $href = true) 
	{
		$recepty_ingredients = ReceptyIngredients::find()->where(['recept_id'=>$id])->all();

		$html = '<h5>Ингредиенты</h5>';
		foreach($recepty_ingredients as $elem) {
			$ingredient = Ingredients::findOne($elem['ingredient_id']);
			
			if (empty($ingredient)) continue;
			
			$measure_name = Measures::findOne($elem['id_measure']);
			
			$html_posfix = '';
			
			if ($elem['kolvo']>0 and $elem['id_measure']>0) $html_posfix =  ' - '.$elem['kolvo'].' '.$measure_name['name'];
			elseif ($elem['id_measure']>0) $html_posfix = ' - '.$measure_name['name'];
			elseif ($elem['kolvo']==0 and $elem['id_measure']==0) $html_posfix = '';
			
			$html .= '<div itemprop="ingredients">';
			if ($href) {
				$html .= '<a href="/ingredients/'.$ingredient['path'].'" title="'.$ingredient['name'].'">'.$ingredient['name'].'</a>';		
			} else {
				$html .= $ingredient['name'];			
			}
			$html .= $html_posfix.'</div>';

		}	
		return $html;
	}	
}
