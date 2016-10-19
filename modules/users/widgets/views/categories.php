<?php

use yii\widgets\Menu;

?>

<div class="popup-sidebar">
	<?= Menu::widget([
		'options' => ['class' => 'popup-sidebar__nav'],
		'linkTemplate' => '<a href="{url}" class="popup-sidebar__link">{label}</a>',
		'submenuTemplate' => "\n<ul class=\"popup-sidebar__item--sublist hidden-sm hidden-xs\">\n{items}\n</ul>\n",		
		'activateParents' => true,
		'items' => $items,
	]);
	?>
</div>