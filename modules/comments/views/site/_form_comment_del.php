<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="modal fade" id="dialog-remove-comment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
<?php $form = ActiveForm::begin([
		'enableAjaxValidation' => false,	
		'action' => '/comments/site/del',
		'options' => [
			'class' => 'form-horizontal form-remove-comment'
		],		
	]); 
?>
		<div class="modal-content">
			<div class="modal-body">
				<?= Html::input('hidden','id','',['id'=>'id_comment']); ?>
				Удалить этот комментарий навсегда?
			</div>
			<div class="modal-footer">
				<?= Html::button('Отмена', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
				<?= Html::submitButton('Удалить', ['class' => 'btn btn-danger']); ?>
			</div>
		</div>				
	</div>
</div>

<?php ActiveForm::end(); ?>

