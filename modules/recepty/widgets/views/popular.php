<?php

use yii\helpers\Html;

$this->registerCssFile('/css/catalog/popular.css',['depends' => ['app\assets\AppAsset']]);

?>
<div class="item-preview hidden-xs">
	<div class="popular_widget">
		<span class="popular_widget__title">Популярные рецепты</span>
		<?php foreach($items as $item): ?>
			<div class="popular_widget__item">
				<div class="">
					<div class="popular_widget__image">
						<?= Html::a(
							Html::img(
								$path_image['small']['path'].$item->image, 
								['class' => 'img-responsive center-block','alt' => $item->name]
							),
							[$item->url],
							['title'=>$item->name]) 
						?>
					</div>				
				</div>
				<div class="">
					<div class="popular_widget__name"><?= $item->name; ?></div>
					<div class="popular_widget__count_show"><?= $item->countShow; ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
