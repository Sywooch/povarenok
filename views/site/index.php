<?php
use yii\helpers\Html;

$path_image = \Yii::$app->params['recepty_tree']['image']['small']['path'];
?>
<div class="index__razdel">
	<ul class="row">
		<?php foreach($trees as $tree): ?>
		<li class="item-content col-lg-3  col-md-4 col-sm-6">
			<div class="item-preview item-block grid">
				<figure class="effect-bubba">		
					<img src="<?= $path_image.$tree->image; ?>" alt="<?= $tree->name; ?>" class="img-responsive center-block">
					<figcaption>
						<h2><span><?= $tree->name; ?></span></h2>
						<div class="description"><?= $tree->description; ?></div>
						<?= Html::a('Показать', ['/recepty/default/filtr', 'path' => $tree->path],['title'=>$tree->name]) ?>
					</figcaption>			
				</figure>
			</div>	
		</li>
		<?php endforeach; ?>
	</ul>

	<?= $this->render("about"); ?>

</div>
