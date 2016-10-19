<?php 

use app\modules\users\models\UsersLike;
use app\modules\comments\models\UsersComment;
use yii\helpers\Html;
use app\modules\comments\widgets\CommentsWidget;
use app\modules\users\widgets\UsersLikeWidget;

$path_image = \Yii::$app->params['article_image']['image'];  

$this->registerCssFile('/css/article/detailed.css',['depends' => ['app\assets\AppAsset']]);
	
?>
<div class="b-page-content" itemscope itemtype="http://schema.org/ScholarlyArticle">
	<div style="display: none;" itemprop="headline"><?= $model->name; ?></div>
	<div style="display: none;" itemprop="articleSection"><?= $model->categoryName; ?></div>
	<div class="item-preview">
		<div class="page_block_header">
			<div class="page_block_header__breadcrumb">
				<?= @$breadcrumbs; ?>
			</div>
		</div>	
		<div class="row">		
			<div class="col-md-12">	
				<h1><?= Html::encode($model->name); ?></h1>	
				<div class="item-preview__info_short">
					<small><?= 'Просмотров: '.$model->count_show.'<span class="divider"></span>'.$model->dateCreate; ?></small>
				</div>
				<div class="">
					<?= Html::a(
						Html::img(
							$path_image['big']['path'].$model->image, 
							['class' => 'img-responsive center-block','alt' => $model->name,'itemprop' => 'image']
						),
						[$path_image['big']['path'].$model->image],
						['class'=>'fancybox','title'=>$model->name,'rel'=>'groupe']) 
					?>					
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
					<div class="opisanie"><div itemprop="articleBody"><?= nl2br($model->recept); ?></div></div>
				</div>
			
			</div>
		</div>

		<div class="item-content" id="update-<?= $model->id; ?>">
			
			<h4>Оставить комментарий</h4>
			
			<div class="caption row">
	
				<div class="view-bot-right">
					<div class="buttons-recept">
						<div class="users_like">
							<?= UsersLikeWidget::widget([
								'id_table' => $model->id,
								'table_name' => UsersComment::ARTICLE,
								'id_variate' => UsersLike::NOTE,
								]); 
							?>
						</div>
						<div class="users_like">
							<?= UsersLikeWidget::widget([
								'id_table' => $model->id,
								'table_name' => UsersComment::ARTICLE,
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
				'table_name' => UsersComment::ARTICLE,
				'comments' => $comments
			]); ?>	
			
		</div>
	
	</div>

</div>	