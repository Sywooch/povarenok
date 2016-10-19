<?php
if (empty($models)) return;

use yii\widgets\LinkPager;
use yii\helpers\Html;
use app\modules\users\widgets\MessageButtonWidget;
use app\modules\users\widgets\FriendsButtonWidget;
	
foreach($models as $user):
?>	
<div class="col-md-6">
	<div class="item_user">

		<div class="item_user__image">			
			<?= Html::a(
				Html::img(
					$user->imagePath, 
					[
						'class' => 'img-responsive img-circle',
						'alt' => $user->name,
					]
				),
				[$user->url],
				['title' => $user->name]) 
			?>			
		</div> 					

		<div class="item_user__detail">
			<div class="item_user__name">
				<?= Html::a(
					$user->name,
					[$user->url],
					['title' => $user->name]) 
				?>				
			</div>
			<div class="item_user__button"><?= MessageButtonWidget::widget(['user' => $user, 'no_btn' => true]); ?></div>
			<div class="item_user__button">
				<?= FriendsButtonWidget::widget([
					'id' => $user->id, 
					'btn_style' => 'btn-xs'
				]); ?>
			</div>			
		</div>				


	</div>	
</div>
<?php endforeach; ?>