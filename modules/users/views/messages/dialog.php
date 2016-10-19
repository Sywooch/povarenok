<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\modules\users\models\UsersMessages;
use app\modules\users\models\Messages;

$this->registerCssFile('/css/messages/dialog.css',['depends' => ['app\assets\AppAsset']]);
$this->registerJs("$('.dialog__wrap').scrollTop(99999);");
?>

</script>
<div class="dialogs">
	<div class="item-preview">
		<div class="dialog__wrap scroll__bar--white">
		<?php 
		foreach($models as $model): 
		$sender = User::findById($model->from_user_id); 
		$message = Messages::findOne($model->id_message);
		?>
			<div class="dialog__line <?php if ($model->is_read == 0) echo 'dialog__line--noread'; ?> dialog__message<?= $model->id; ?>">
				<div class="row">
					<div class="col-xs-1">
						<div class="dialog__image">
							<?= Html::a(
								Html::img(
									$sender->imagePath, 
									['class' => 'img-responsive img-circle','alt' => $sender->name]
								),
								[$sender->url],
								['title'=>$sender->name]) 
							?>
						</div>
					</div>
					<div class="col-xs-11">			
						<div class="dialog__block-text">
							<div class="dialog__name-user">
								<?= Html::a(
									$sender->name,
									[$sender->url],
									['title'=>$sender->name]) 
								?>	
							</div>
							<div class="dialog__date text-right">
								<?= $message->lastMessage; ?>

								<span class="dialog__remove-btn btn-remove__message" rel="<?= $model['id']; ?>" data-toggle="modal">
									<span class="glyphicon glyphicon-remove" title="Удалить"></span>
								</span>	
			
							</div>
							<div class="dialog__comment"><?= nl2br($message->comment); ?></div>
						</div>
					</div>
				</div>
			</div>
		
		<?php endforeach; ?>
		</div>
		<div class="dialog__controls-msg">
			<div class="row">
				<div class="col-xs-1">
					<?php $from_user = User::findById(\Yii::$app->user->identity->id); ?>
					<div class="dialog__controls-img">
						<?= Html::a(
							Html::img(
								$from_user->imagePath, 
								['class' => 'img-responsive img-circle','alt' => $from_user->name]
							),
							[$from_user->url],
							['title'=>$from_user->name]) 
						?>						
					</div>					
				</div>
				<div class="col-xs-10">
					<?php ActiveForm::begin([			
							'action' => '/users/messages/create',
							'enableAjaxValidation' => true,
							'options' => [
								'class' => 'jsform'
							],
					]); ?>	
						<?= Html::input('hidden','id',$user['id']); ?>
						<?= Html::textarea('comment','',['class' => 'form-control dialog__controls-textarea']) ?>						
						
						<div class="dialog__controls-btns">
							<?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
						</div>				
					<?php ActiveForm::end(); ?>				
				</div>
				<div class="col-xs-1">
					<?php $for_user = User::findById($user->id); ?>
					<div class="dialog__controls-img">
						<?= Html::a(
							Html::img(
								$for_user->imagePath, 
								['class' => 'img-responsive img-circle','alt' => $for_user->name]
							),
							[$for_user->url],
							['title'=>$for_user->name]) 
						?>
					</div>	
				</div>
			</div>	
		</div>
	</div>
</div>

<div class="modal fade" id="dialog-remove__message" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<?php ActiveForm::begin([			
				'action' => '/users/messages/delete',	
				'enableAjaxValidation' => false,
				'options' => [
					'class' => 'form-horizontal jsform',
				],
		]); ?>		
			<div class="modal-content">
				<div class="modal-body">
					<?= Html::input('hidden','id'); ?>
					<?= 'Удалить это сообщение навсегда?'; ?>
				</div>
				<div class="modal-footer">
					<?= Html::button('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
					<?= Html::submitButton('Удалить', ['class' => 'btn btn-danger']) ?>					
				</div>				
			</div>
		<?php ActiveForm::end(); ?>	
	</div>
</div>	
