<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\users\models\User;
use app\modules\users\models\UsersProfile;
use app\functions\Functions;
use app\modules\users\widgets\MessageButtonWidget;
use app\modules\users\widgets\FriendsButtonWidget;
use app\widgets\ImageButtonWidget;

$this->registerCssFile('/css/users/list.css',['depends' => ['app\assets\AppAsset']]);

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */

$f = new Functions();

?>

<div class="row">
	<div class="col-xs-12">

		<div class="row">
					
			<div class="col-md-4">

				<div class="item-preview">
					<?= Html::a(
						Html::img(
							$user->imagePathBig, 
							[
								'class' => 'img-responsive center-block',
								'alt' => $user->name,
							]
						),
						[$user->imagePathBig],
						['title' => $user->name, 'class' => 'fancybox']) 
					?>					
					<div class="button-panel">
						<?php 
						if ($user['id'] != @\Yii::$app->user->identity->id) {
							echo MessageButtonWidget::widget(['user' => $user]); 
							echo FriendsButtonWidget::widget([
										'id' => $user->id, 
									]);
						} else {
							echo ImageButtonWidget::widget([
								'user' => $user,
								'imageSmallWidth' => Yii::$app->params['users']['image']['small']['width'],
								'imageSmallHeight' => Yii::$app->params['users']['image']['small']['height'],
								'actionUrl' => '/users/site/save-avatar/',
							]);
							echo Html::a(
								'Редактировать',
								['/users/settings'],
								[
									'class' => 'btn btn-default button-panel__btn',
								]);

						}
						?>
					</div>
				</div>
				
			</div>		

			<div class="col-md-8">					
					
				<div class="item-preview">
					<div class="cabinet-title">
						<div class="row">
							<div class="col-sm-6"><?= $profile->name; ?></div>
							<div class="col-sm-6">
								<div class="text-right">
									<small><?= $user->lastVisit; ?></small>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12"><small><a href="#"><?= $profile->current_info; ?></a></small></div>
						</div>								
					</div>
					<div class="cabinet-description">
						<div class="row">
							<div class="col-xs-4"><small>Пол:</small></div>
							<div class="col-xs-8"><small><a href="#"><?= UsersProfile::getSexDropList()[$profile->sex]; ?></a></small></div>
						</div>
						<div class="row">
							<div class="col-xs-4"><small>Дата рождения:</small></div>
							<div class="col-xs-8"><small><?= $profile->birthday; ?></small></div>
						</div>
						<div class="row">
							<div class="col-xs-4"><small>Город:</small></div>
							<div class="col-xs-8"><small><a href="#"><?= $profile->city; ?></a></small></div>
						</div>
						<div class="row">
							<div class="col-xs-4"><small>О себе:</small></div>
							<div class="col-xs-8"><small><?= $profile->about; ?></small></div>
						</div>
						<div class="row">
							<div class="col-xs-4"><small>Интересы:</small></div>
							<div class="col-xs-8"><small><?= $profile->interes; ?></small></div>
						</div>

					</div>	
					<div class="cabinet-bottom">
						<div class="row">
							<div class="col-xs-3">
								<a href="" class="cabinet-bottom__page-counter">
									<div class="cabinet-bottom__count"><?= $count_friends; ?></div>
									<div class="cabinet-bottom__label"><?= $f->count_with_text($count_friends,['друзей','друг','друга']); ?></div>
								</a>
							</div>
							<div class="col-xs-3">
								<a href="" class="cabinet-bottom__page-counter">
									<div class="cabinet-bottom__count"><?= $count_subscribe; ?></div>
									<div class="cabinet-bottom__label"><?= $f->count_with_text($count_subscribe,['подписчиков','подписчик','подписчика']); ?></div>
								</a>
							</div>
							<div class="col-xs-3">
								<a href="" class="cabinet-bottom__page-counter">
									<div class="cabinet-bottom__count"><?= $count_recepts; ?></div>
									<div class="cabinet-bottom__label"><?= $f->count_with_text($count_recepts,['рецептов','рецепт','рецепта']); ?></div>
								</a>
							</div>
							<div class="col-xs-3">
								<a href="" class="cabinet-bottom__page-counter">
									<div class="cabinet-bottom__count"><?= $count_notes; ?></div>
									<div class="cabinet-bottom__label"><?= $f->count_with_text($count_notes,['заметок','заметка','заметки']); ?></div>
								</a>
							</div>
												
						</div>
					</div>
				</div>
				
			</div>
			
		</div>

	</div>
</div>
