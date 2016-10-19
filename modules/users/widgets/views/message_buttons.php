<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>


<?= Html::a(
	'Написать сообщение',
	['#'],
	[
		'class' => $no_btn ? 'button-panel__btn' : 'btn btn-default button-panel__btn',
		'onclick' => 'return showDialogMsg(event, '.$user->id.')',
	]);
?>		
<div class="modal fade modal__messages" tabindex="-1" id="dialog-message<?= $user->id; ?>" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">					
		<?php $form = ActiveForm::begin([			
				'action' => '/users/messages/create',
				'enableAjaxValidation' => true,
				'options' => [
					'class' => 'jsform'
				],				
		]); ?>			
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h5 class="modal-title">Новое сообщение</h5>						
				</div>
				<div class="modal-body">
				
					<div class="dialog-message__user">
						<div class="dialog-message__image">
							<?= Html::a(
								Html::img(
									$user->imagePath, 
									['class' => 'img-responsive img-circle','alt' => $user->profile->name]
								),
								[$user->url],
								['title'=>$user->profile->name]); 
							?>							
						</div>
						<div class="dialog-message__text">
							<?= Html::a(
								'<strong>'.$user->profile->name.'</strong>',
								[$user->url],
								['title'=>$user->profile->name]);
							?>
							<div class="dialog-message__info">
								<?= Html::a(
									'Перейти к диалогу',
									['/users/messages/dialog', 'id' => $user->id],
									['title'=>$user->profile->name]);
								?>									
							</div>
						</div>
					</div>
				
					<?= Html::input('hidden','id',$user['id']); ?>
					<?= Html::textarea('comment','',['class' => 'form-control dialog__controls-textarea']) ?>						
										
				</div>
				<div class="modal-footer text-left">
					<?= Html::button('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
					<?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
				</div>				
			</div>
		<?php ActiveForm::end(); ?>	
	</div>
</div>
