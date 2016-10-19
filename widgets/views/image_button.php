<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\ImageEditorWidget;
?>

<?= Html::a(
	'Изменить изображение',
	['#'],
	[
		'class' => 'btn btn-default button-panel__btn',
		'data-toggle' => 'modal',
		'data-target' => '#myModal',
	]);
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php $form = ActiveForm::begin([
				'action' => $widget->actionUrl,
				'options' => [
					'enctype' => 'multipart/form-data'
				],				
			]); ?>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">

							<?= $form->field($widget->user, 'id')->hiddenInput()->label(false) ?>
							<?= $form->field($widget->user, 'image')->fileInput(['id' => 'inputImage'])->label(false) ?>
							<?= ImageEditorWidget::widget([
								'image_id' => '#inputImage',
								'width' => $widget->imageSmallWidth,
								'height' => $widget->imageSmallHeight,
							]); ?>	
				
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
					<button type="submit" class="btn btn-primary">Сохранить изменения</button>
				</div>
				
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
	