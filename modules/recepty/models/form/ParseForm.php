<?php
namespace app\modules\recepty\models\form;

use Yii;
use yii\base\Model;
use app\modules\recepty\models\Recepty;
use app\modules\recepty\models\ReceptyIngredients;
use app\modules\recepty\models\Ingredients;
use app\modules\recepty\models\Measures;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;

/**
 * Login form
 */
class ParseForm extends Model
{
    public $url;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['url', 'required'],
			['url', 'string'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'url' => 'Урл',
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function parse()
    {
        if ($this->validate()) {
			$html = SHD::file_get_html($this->url); 
			
			$ingredient_tag = '.recipe-ing';
			$instruction_tag = '.recipe-text';
			$instruction_tag2 = '.recipe-steps tr';
			
			$model = new Recepty();
			
			if (count($html->find('time[itemprop=totalTime]',0))) 
			$model->time = (int)$html->find('time[itemprop=totalTime]',0)->plaintext;	

			if (count($html->find('span[itemprop=summary]',0))) 
			$model->short_description = $html->find('span[itemprop=summary]',0)->plaintext;		

			if (count($html->find('h1 > a',3)))
			$model->name = $html->find('h1 > a',3)->plaintext;		
			
			$i = 0;			
			if(count($html->find($ingredient_tag))) {	
				foreach($html->find($ingredient_tag) as $div) {
					$kolvo_ing = count($div->find('span[itemprop=name]'));
					for($i=0;$i<$kolvo_ing;$i++) {
						$ingredient = $div->find('span[itemprop=name]',$i)->plaintext;
						
						if (count($div->find('span[itemprop=amount]',$i))) {
							$value = $div->find('span[itemprop=amount]',$i)->plaintext;
							$kolvo = substr($value, 0, strpos($value, ' '));
							$measure = substr($value, strpos($value, ' '));
						} else {
							$kolvo = '';
							$measure = '';					
						}
						$ing[$i]['ingredient_id'] = $ingredient;
						$ing[$i]['kolvo'] = $kolvo;
						$ing[$i]['id_measure'] = trim($measure);

					}
				}
			}
			
			//echo "<pre>";
			//print_r($ing);
			//die;

			$ingredients = ReceptyIngredients::find()->limit($kolvo_ing)->all();
			$k = 0;
			foreach($ingredients as $ig) {
				$ingredient = Ingredients::findOne(['name' => $ing[$k]['ingredient_id']]);
				$measure = Measures::findOne(['name' => $ing[$k]['id_measure']]);

				$ig->id = $k;
				$ig->ingredient_id = $ingredient->id;
				$ig->kolvo = $ing[$k]['kolvo'];
				$ig->id_measure = ($measure === null) ? 0 : $measure->id;
				
				$k++;
			}
			
			$model->ingredients = $ingredients;
			
			$i = 1;		
			$model->recept = '';
			if(count($html->find($instruction_tag2))) {	
				foreach($html->find($instruction_tag2) as $div){
					$model->recept .= $i++.". ".$div->last_child()->plaintext."\n";		
				}
			}

			if(count($html->find($instruction_tag))) {	
				foreach($html->find($instruction_tag) as $div){
					$model->recept .= $div->plaintext;		
				}
			}

			$html->clear(); 
			unset($html);
			
            return $model;
        } else {
            return false;
        }
    }

}
