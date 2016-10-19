<?php 
use app\models\Pages;

$item = Pages::findOne(1); 
$this->title = $item->title;
?>    
<div class="block__preview">
	<h1><?= $item->title; ?></h1>
	<div class="">
		<?= nl2br($item->short_description); ?>
	</div>
</div>
