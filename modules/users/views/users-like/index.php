<?php 
use yii\helpers\Html;
use yii\widgets\LinkPager;

$path_image = \Yii::$app->params['recepty_image']['image'];

$this->registerCssFile('/css/users/likes_note.css',['depends' => ['app\assets\AppAsset']]);	
$this->registerCssFile('/css/users/list.css',['depends' => ['app\assets\AppAsset']]);	
?>

<div class="item-preview">

	<div class="page_block_header page_tabs">
		<div class="row">
			<div class="col-sm-8">
				<div class='friend-tab <?php if (@$_GET['variate']!=1) echo "active"; ?>'><a href="/users/users-like">Заметки</a></div>		
				<div class='friend-tab <?php if (@$_GET['variate']==1) echo "active"; ?>'><a href="/users/users-like?variate=1">Понравилось</a></div>		
			</div>
			<div class="col-sm-4 forum-desc text-right">
				<small>Всего рецептов: <?= count($models); ?></small>
			</div>
		</div>
	</div>

	<?php foreach($models as $model): ?>
	<div class="forum-item">
		<div class="row">
			<div class="col-md-5">
				<?= Html::a(
					Html::img(
						$path_image['small']['path'].$model->image, 
						['class' => 'img-responsive center-block','alt' => $model->name]
					),
					[$model->url],
					['class'=>'fancybox','title'=>$model->name]) 
				?>		
			</div>
			<div class="col-md-7">
				<?= Html::a($model->name, [$model->url],['class'=>'forum-item-title','title'=>$model->name]) ?>
				<div class="forum-sub-title"><?= $model->short_description; ?></div>
				<small><?= $model->dateCreate.' в '.$model->timeCreate; ?></small>
			</div>
		</div>				
	</div>	
	<?php endforeach; ?>

<?php
// display pagination
echo LinkPager::widget([
    'pagination' => $pagination
]);
?>	
	
</div>

	
