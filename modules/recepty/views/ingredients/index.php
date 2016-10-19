<?php
use app\modules\recepty\models\Ingredients;

	$array = array();
	foreach($items as $item) {	
		$array[mb_substr($item['name'], 0, 1, 'UTF-8')][] = $item;
	}

$this->title = "Ингредиенты";	
?>
<div class="item-preview ingredients">
	<div class="page_block_header">
		<?= $this->title; ?>
	</div>
	<ul id="ingredients-list" class="row">
		<?php 
		foreach($array as $key => $value) {
			echo '<li class="first-letter"><a href="#"><strong>'.$key.'</strong></a></li>';
			foreach($value as $val) {
				echo '<li><a href="/ingredients/'.$val['path'].'" title="'.$val['name'].'">'.$val['name'].'</a></li>';
			}
		}
		?>
	</ul>
</div>
