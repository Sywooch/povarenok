<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([	
		'action' => '/comments/site/edit',
		'options' => [
			'class' => 'myform comm-edit'
		],		
	]); 
?>

<?= Html::input('hidden','id',$model->id); ?>
<div class="form-group">
	<?= Html::textarea('comment',$model->comment,['class' => 'form-control']); ?>
</div>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-sm btn-success']); ?>
<?= Html::button('Отмена', ['class' => 'btn btn-sm btn-default comment-cancel', 'rel' => $model->id_table]); ?>

<?php ActiveForm::end(); ?>

