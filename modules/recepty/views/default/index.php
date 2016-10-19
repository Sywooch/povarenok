<?php 

use app\modules\recepty\models\Ingredients;
use app\modules\comments\models\UsersComment;
use app\modules\users\models\UsersLike;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use app\modules\comments\widgets\CommentsWidget;
use app\modules\users\widgets\UsersLikeWidget;

$path_image = \Yii::$app->params['recepty_image']['image'];

$this->registerCssFile('/css/catalog/list.css',['depends' => ['app\assets\AppAsset']]);

?>

	<div class="item-preview">
		<div class="page_block_header">
			<div class="row">
				<div class="col-sm-7">
					<div class="page_block_header__breadcrumb">
						<?= @$breadcrumbs; ?>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="count-show"><small>Всего рецептов: <?= $query->count(); ?></small></div>
				</div>
			</div>
		</div>
		
		<div class="">
			<h1><?= Yii::$app->view->title; ?></h1>
			<?= nl2br(@$tree->short_description); ?>
		</div>
	</div>




<div class="row">

	<ul id="catalog-list">
	<?php if (@$models): ?>
	<?php foreach($models as $item): ?>
	<li class="item-content" id="update-<?= $item->id; ?>">
		<div class="item-preview item-recept">
			<div class="title-head">
				<div class="row">
					<div class="col-sm-7">
						<?= $item->categoryLink; ?>
					</div>
					<div class="col-sm-5">
						<div class="count-show"><small>Просмотров: <?= $item->count_show; ?></small></div>
					</div>
				</div>
			</div>
			<div class="title">
				<div>
					<?= Html::a($item->name, [$item->url],['class'=>'title-href','title'=>$item->name]) ?>
				</div>
				<div class="title-small"><small><?= $item->dateCreate.' в '.$item->timeCreate; ?></small></div>
			</div>
			<div class="description"><?= Ingredients::getHtmlIngredient($item->id); ?></div>
			<div class="image">
				<?= Html::a(
					Html::img(
						$item->imagePath, 
						['class' => 'img-responsive center-block','alt' => $item->name]
					),
					[$item->imagePathBig],
					['class'=>'fancybox','title'=>$item->name]) 
				?>
			</div>
			<?php if (!empty($item->short_description)): ?>
			<div class="description desc__bottom"><?= $item->short_description; ?></div>
			<?php endif; ?>
			<div class="caption row">
		
				<div class="view-bot-left">
					<?= Html::a('Просмотр', [$item->url],['class'=>'btn btn-default btn-sm']) ?>
				</div>
				
				<div class="view-bot-right">
					<div class="buttons-recept">
						<div class="users_like">
							<?= UsersLikeWidget::widget([
								'id_table' => $item->id,
								'table_name' => UsersComment::RECEPTY,
								'id_variate' => UsersLike::NOTE,
								]); 
							?>
						</div>
						<div class="users_like">
							<?= UsersLikeWidget::widget([
								'id_table' => $item->id,
								'table_name' => UsersComment::RECEPTY,
								'id_variate' => UsersLike::LIKE,
								]); 
							?>
						</div>					
					</div>
				</div>
				<?php 
				$comments = UsersComment::getComments($item->id,"recepty"); 
				if (empty($comments)): ?>
				<div class="view-bot-center">
					<div class="input-comment top-comment" rel="<?= $item->id; ?>" title="Прокомментировать">Прокомментировать</div>
				</div>				
				<?php endif; ?>				
			</div>
			
			<?= CommentsWidget::widget([
				'id_table' => $item->id, 
				'id_user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : 0,
				'table_name' => UsersComment::RECEPTY,
				'comments' => $comments
			]); ?>				

		</div>	
	</li>	
	<?php endforeach;  ?>
	<?php endif; ?>
		
	</ul>

</div>
<?php
// display pagination
echo LinkPager::widget([
    'pagination' => $pagination
]);
?>

