<?php 

use app\modules\users\models\UsersLike;
use app\modules\comments\models\UsersComment;
use yii\helpers\Html;
use app\modules\comments\widgets\CommentsWidget;
use app\modules\users\widgets\UsersLikeWidget;

$path_image = \Yii::$app->params['recepty_image']['image'];  

$this->registerCssFile('/css/catalog/detailed.css',['depends' => ['app\assets\AppAsset']]);
	
?>	
<div class="b-page-content" itemscope itemtype="http://schema.org/Recipe">
	<div style="display: none;" itemprop="name"><?= $model->name; ?></div>
	<div style="display: none;" itemprop="recipeCategory"><?= $model->categoryName; ?></div>
	<div class="item-preview">
		<div class="page_block_header">
			<div class="page_block_header__breadcrumb">
				<?= @$breadcrumbs; ?>
			</div>
		</div>
		<h1><?= $model->name; ?></h1>	
		<div class="item-preview__info_short">
			<small><?= 'Просмотров: '.$model->count_show.'<span class="divider"></span>'.$model->dateCreate; ?></small>
		</div>		
		<div class="row">
			<div class="col-md-7">		
				<div class="item-preview__image">
					<?= Html::a(
						Html::img(
							$model->imagePathBig, 
							[
								'class' => 'img-responsive center-block',
								'alt' => $model->name,
								'itemprop' => 'resultPhoto',
							]
						),
						[$model->imagePathBig],
						['title' => $model->name, 'class' => 'fancybox', 'rel' => 'groupe']) 
					?>					
				</div>
			</div>
			<div class="col-md-5">

				<?php if (!empty($author)): ?>
				<div class="author-block">
					<div class="row author">
						<div class="col-sm-3 col-xs-3">
							<?= Html::a(
								Html::img(
									$author->imagePath, 
									['class' => 'img-responsive img-circle','alt' => $author->name]
								),
								[$author->url],
								['title'=>$author->name]) 
							?>
						</div>
						<div class="col-sm-9 col-xs-9">
							<?= Html::a(
								$author->name,
								[$author->url],
								['title'=>$author->name]) 
							?>							
							<div class="author__info">
								<?= $author->profile->current_info; ?>
							</div>
						</div>
					</div>
					
					
				</div>
				<?php endif; ?>
				
				<div class="">
					<?= $html_ingredient; ?>
				</div>

			</div>
			
			
		</div>
		
		<div class="row">
			<div class="col-md-12">

				<?php if (!empty($model->short_description)): ?>
				<div class="">
					<div class="opisanie"><?= $model->short_description; ?></div>
				</div>
				<?php endif; ?>
				
				<div class="">
					<div class="opisanie"><h4>Способ приготовления</h4> <div itemprop="recipeInstructions"><?= nl2br($model->recept); ?></div></div>
				</div>
			
			</div>
		</div>	
		
		<?php if (!empty($model->url_video)): ?>
		<div class="row">
			<div class="col-md-12">
				<h4> <?= $model->name; ?> видео рецепт</h4>
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="<?php echo $video->getVideo(); ?>"></iframe>
				</div>			
			</div>
		</div>
		<?php endif; ?>
		
		<div class="item-content" id="update-<?= $model->id; ?>">
				
				<h4>Оставить комментарий</h4>
				
				<div class="caption row">
		
					<div class="view-bot-right">
						<div class="buttons-recept">
							<div class="users_like">
								<?= UsersLikeWidget::widget([
									'id_table' => $model->id,
									'table_name' => UsersComment::RECEPTY,
									'id_variate' => UsersLike::NOTE,
									]); 
								?>
							</div>
							<div class="users_like">
								<?= UsersLikeWidget::widget([
									'id_table' => $model->id,
									'table_name' => UsersComment::RECEPTY,
									'id_variate' => UsersLike::LIKE,
									]); 
								?>
							</div>						
						</div>
					</div>
					<?php if (empty($comments)): ?>
					<div class="view-bot-center">
						<div class="input-comment top-comment" rel="<?= $model->id; ?>" title="Прокомментировать">Прокомментировать</div>
					</div>				
					<?php endif; ?>
				</div>

				<?= CommentsWidget::widget([
					'id_table' => $model->id, 
					'id_user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : 0,
					'table_name' => UsersComment::RECEPTY,
					'comments' => $comments
				]); ?>					
					
		</div>
	
	</div>

</div>