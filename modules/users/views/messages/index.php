<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\modules\users\models\UsersMessages;
use app\modules\users\models\Messages;

$this->registerCssFile('/css/messages/list.css',['depends' => ['app\assets\AppAsset']]);
?>
<div class="messages">
	<div class="item-preview">

		<div class="page_block_header"><?= \Yii::$app->view->title; ?></div>		
		<?php foreach($models as $model): 

		$recipient = User::findById($model->iuser_id); 
		$sender = User::findById($model->im_user_id); 			
	
		$last_message = UsersMessages::find()
			->where(['is_delete' => 0])
			->andWhere(['id_dialog' => $model->id])
			->orderBy(['id' => SORT_DESC])
			->one();
		
		if (empty($last_message)) continue;
		$message = Messages::findOne($last_message['id_message']);
		?>
			<div class="message__line <?php if ($last_message->is_read == 0 && $last_message->for_user_id == $recipient->id) echo 'message__line--noread'; ?>" id="dialog<?= $model->im_user_id; ?>" rel="<?= $model->id; ?>">
				<div class="row">
					<div class="col-xs-4">
						<div class="row">
							<div class="col-xs-4">
								<div class="message__image">
								<?= Html::a(
									Html::img(
										$sender->imagePath, 
										['class' => 'img-responsive','alt' => $sender->name]
									),
									[$sender->url],
									['title'=>$sender->name]) 
								?>					
								</div>							
							</div>
							<div class="col-xs-8">
								<div class="message__name-user">
									<?= Html::a(
										$sender->name,
										[$sender->url],
										['title'=>$sender->name]) 
									?>										
								</div>
								<div class="message__date">
									<?= $message->lastMessage; ?>
								</div>
								<span class="message__kolvo">
									<?= $model->countMsg; ?>
								</span>
								
							</div>
						</div>

						
					</div>
					<div class="col-xs-8">		
						<div class="message__block-text <?php if ($last_message->is_read == 0 && $last_message->for_user_id != $recipient->id) echo 'message__line--noread'; ?>">

							<span class="message__remove-btn btn-remove__dialog" rel="1" data-toggle="modal">
								<span class="glyphicon glyphicon-remove" title="Удалить"></span>
							</span>	
	
							<?php if ($last_message->for_user_id != $recipient->id): ?>
	
							<div class="message__image--small">
								<?= Html::img(
										$recipient->imagePath, 
										['class' => 'img-responsive','alt' => $recipient->name]
									); 
								?>
							</div>							
					
							<?php endif; ?>

							<div class="message__text">	
								<div class="message__comment"><?= nl2br($message->comment); ?></div>							
							</div>

						</div>
					</div>
				</div>
			</div>
		
		<?php endforeach; ?>
	</div>
</div>

<div class="modal fade" id="dialog-remove__dialog" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<?php ActiveForm::begin([			
				'action' => '/users/messages/dialog-del',
				'enableAjaxValidation' => false,
				'options' => [
					'class' => 'form-horizontal jsform',
				],
		]); ?>			
			<div class="modal-content">
				<div class="modal-body">
					<?= Html::input('hidden','id'); ?>
					<?= 'Вы действительно хотите удалить всю переписку в этой беседе?<br/><br/>Отменить это действие будет невозможно.'; ?>
				</div>
				<div class="modal-footer">
					<?= Html::button('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
					<?= Html::submitButton('Удалить', ['class' => 'btn btn-danger']) ?>
				</div>				
			</div>
		<?php ActiveForm::end(); ?>		
	</div>
</div>	
