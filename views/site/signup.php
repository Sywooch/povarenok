<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-preview">
    <div class="page_block_header"><h1><?= Html::encode($this->title) ?></h1></div>
	
	<p>Все поля обязательны для заполнения</p>

	<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

		<?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

		<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

		<div class="form-group">
			<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-sm btn-success', 'name' => 'signup-button']) ?>
		</div>

	<?php ActiveForm::end(); ?>
	
	<div class="bs-callout bs-callout-info">
		<h4>Зарегистрировавшись на Поваренке, вы сможете:</h4>
		<p>
			сохранять понравившиеся рецепты в свои заметки;<br />
			оставлять комментарии (и получать ответы!);<br />
			ставить лайки;<br />
			добавлять наших кулинаров в друзья;<br />
			писать друг другу сообщения;<br />
		</p>
	</div>			
			
   
</div>
