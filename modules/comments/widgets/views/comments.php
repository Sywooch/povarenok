<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$comments = $widget->comments;
$kolvo_end = 3;

?>
<div class="comment-block <?php if (empty($comments)): ?>hide<?php endif; ?>">
	
	<div id="comment-content">
		<?= $this->render('@app/modules/comments/views/site/index',['comments' => $comments,'id_user' => $widget->id_user]); ?>
	</div>
	
	<div class="comment-bottom">
		<div class="input-comment" title="Прокомментировать">Прокомментировать</div>
		<div class="form-comment hide">
			<a href="" class="comment-image">
				<?php if (Yii::$app->user->identity): ?>
				<img src="<?= Yii::$app->user->identity->imagePath; ?>" alt="">
				<?php else: ?>
				<img src="/img/no-photo.jpg" alt="">
				<?php endif; ?>
			</a>					
			<?php
				$form = ActiveForm::begin([
					'enableAjaxValidation' => false,
					'action' => '/comments/site/add',
					'options' => [
						'class' => 'add-comment'
					],		
					]); 
					echo $form->field($model, 'id_user')->hiddenInput()->label(false);
					echo $form->field($model, 'table_name')->hiddenInput()->label(false);
					echo $form->field($model, 'active')->hiddenInput()->label(false);
					echo $form->field($model, 'id_table')->hiddenInput()->label(false);
					echo $form->field($model, 'comment')->textArea()->label(false);

					echo Html::submitButton('Отправить', ['class' => 'btn btn-sm btn-success']);
					echo Html::button('Отмена', ['class' => 'btn btn-sm btn-default comment-cancel', 'rel' => $widget->id_table]);
				ActiveForm::end();
			?>
		</div>	
	</div>
	
	<?= $this->render('@app/modules/comments/views/site/_form_comment_del'); ?>
</div>