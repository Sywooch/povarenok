<?php 

use app\modules\comments\models\UsersComment;
use app\modules\users\models\UsersLike;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use app\modules\comments\widgets\CommentsWidget;
use app\modules\users\widgets\UsersLikeWidget;

$path_image = \Yii::$app->params['article_image']['image'];

$this->registerCssFile('/css/article/list.css',['depends' => ['app\assets\AppAsset']]);

?>

<h1><?= Yii::$app->view->title; ?></h1>

<?php if (isset($breadcrumbs)): ?>
<div class="breadcrumb"><?= $breadcrumbs; ?></div>
<?php endif; ?>

<div class="row">
	<ul id="catalog-list">
	<?php foreach($models as $item): ?>
	<li class="item-content" id="update-<?= $item->id; ?>">
		<div class="item-preview item-recept">
			<div class="title-head">
				<?= $item->categoryLink; ?>
				
				<div class="pull-right count-show"><small>Просмотров: <?= $item->count_show; ?></small></div>
			</div>
			<div class="title">
				<div>
					<?= Html::a(
							$item->name, 
							[$item->url],
							['class'=>'title-href','title'=>$item->name]) 
					?>
				</div>
				<div class="title-small"><small><?= $item->dateCreate.' в '.$item->timeCreate; ?></small></div>
			</div>
			<div class="description"><?= $item->short_description; ?></div>
			<div class="image">
				<?= Html::a(
					Html::img(
						$path_image['small']['path'].$item->image, 
						['class' => 'img-responsive center-block','alt' => $item->name]
					),
					[$path_image['big']['path'].$item->image],
					['class'=>'fancybox','title'=>$item->name]) 
				?>			
			</div>
			<div class="caption row">
		
				<div class="view-bot-left">
					<?= Html::a(
							'Просмотр', 
							[$item->url],
							['class'=>'btn btn-default btn-sm']) 
					?>
				</div>
				
				<div class="view-bot-right">
					<div class="buttons-recept">
						<div class="users_like">
							<?= UsersLikeWidget::widget([
								'id_table' => $item->id,
								'table_name' => UsersComment::ARTICLE,
								'id_variate' => UsersLike::NOTE,
								]); 
							?>
						</div>
						<div class="users_like">
							<?= UsersLikeWidget::widget([
								'id_table' => $item->id,
								'table_name' => UsersComment::ARTICLE,
								'id_variate' => UsersLike::LIKE,
								]); 
							?>
						</div>					
					</div>
				</div>
				<?php 
				$comments = UsersComment::getComments($item->id,"article"); 
				if (empty($comments)): ?>
				<div class="view-bot-center">
					<div class="input-comment top-comment" rel="<?= $item->id; ?>" title="Прокомментировать">Прокомментировать</div>
				</div>				
				<?php endif; ?>	
			</div>
			
			<?= CommentsWidget::widget([
				'id_table' => $item->id, 
				'id_user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : 0,
				'table_name' => UsersComment::ARTICLE,
				'comments' => $comments
			]); ?>			
			
		</div>	
	</li>	
	<?php endforeach; ?>		
	</ul>
</div>
<?php
// display pagination
echo LinkPager::widget([
    'pagination' => $pagination
]);
?>
<?php if (@$tree['short_description']) : ?>
	<div class="item-preview">
		<h3><?= $tree['title']; ?></h3>
		<div class="">
			<?= nl2br($tree['short_description']); ?>
		</div>
	</div>
<?php endif; ?>
